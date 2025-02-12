<?php

namespace Tests\Feature\Videos;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VideosManageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Asegurar que la base de datos de prueba se reinicialice correctamente
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);
        // Configurar la clave de aplicación para el entorno de pruebas
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function user_with_permissions_can_manage_videos()
    {
        $user = $this->loginAsVideoManager();

        $this->assertTrue($user->can('manage videos'));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function regular_users_cannot_manage_videos()
    {
        $user = $this->loginAsRegularUser();

        $this->assertFalse($user->can('manage videos'));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function guest_users_cannot_manage_videos()
    {
        $this->assertGuest();

        $response = $this->get('/videos/manage');
        $response->assertRedirect('/login');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function superadmins_can_manage_videos()
    {
        $user = $this->loginAsSuperAdmin();

        $this->assertTrue($user->can('manage videos'));
    }

    protected function loginAsVideoManager()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $user->assignRole('video_manager');

        return $user;
    }

    protected function loginAsSuperAdmin()
    {
        $user = User::factory()->create(['super_admin' => true]);
        $this->actingAs($user);
        $user->assignRole('super_admin');

        return $user;
    }

    protected function loginAsRegularUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $user->assignRole('regular');

        return $user;
    }
}
