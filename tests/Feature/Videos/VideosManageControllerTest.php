<?php

namespace Tests\Feature\Videos;

use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Helpers\UserHelper;
use PHPUnit\Framework\Attributes\Test;

class VideosManageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
//        $this->artisan('migrate:fresh');
        UserHelper::createPermissions();
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
    }

    #[Test]
    public function user_without_permissions_can_see_default_videos_page()
    {
        $user = UserHelper::createRegularUser();

        $this->actingAs($user)
            ->get(route('videos.index'))
            ->assertStatus(200);
    }

    #[Test]
    public function user_with_permissions_can_see_default_videos_page()
    {
        $user = UserHelper::createVideoManagerUser();

        $this->actingAs($user)
            ->get(route('videos.index'))
            ->assertStatus(200);
    }

    #[Test]
    public function not_logged_users_can_see_default_videos_page()
    {
        $this->get(route('videos.index'))
            ->assertStatus(200); // Verifica que els usuaris no autenticats poden veure la pàgina
    }

    #[Test]
    public function loginAsVideoManager()
    {
        $user = UserHelper::createVideoManagerUser();
        $this->actingAs($user);
        $this->assertTrue($user->can('manage-videos'));
    }

    #[Test]
    public function loginAsSuperAdmin()
    {
        $user = UserHelper::createSuperAdminUser();
        $this->actingAs($user);
        $this->assertTrue($user->can('manage-videos'));
    }

    #[Test]
    public function loginAsRegularUser()
    {
        \Log::info('Starting loginAsRegularUser test');
        $user = UserHelper::createRegularUser();
        \Log::info('Regular user created: ' . $user->email);

        $this->actingAs($user);
        \Log::info('User is acting as regular user');

        $this->assertFalse($user->can('manage-videos'));
        \Log::info('Test completed: Regular user cannot manage videos');
    }

    #[Test]
    public function user_with_permissions_can_see_add_videos()
    {
        $user = UserHelper::createVideoManagerUser();
        $this->actingAs($user)
            ->get(route('videos.manage.create'))
            ->assertStatus(200);
    }

    #[Test]
    public function user_without_videos_manage_create_cannot_see_add_videos()
    {
        $user = UserHelper::createRegularUser();
        $this->actingAs($user)
            ->get(route('videos.manage.create'))
            ->assertForbidden(); // Verifica que es retorna un 403
    }

    #[Test]
    public function user_with_permissions_can_store_videos()
    {
        $user = UserHelper::createVideoManagerUser();
        $this->actingAs($user)
            ->post(route('videos.manage.store'), [
                'title' => 'Test Video',
                'description' => 'Test Description',
                'url' => 'http://example.com',
                'series_id' => 1,
                'user_id' => $user->id, // Afegir user_id aquí
            ])->assertRedirect(route('videos.manage.index'));
    }


    #[Test]
    public function user_without_permissions_cannot_store_videos()
    {
        $user = UserHelper::createRegularUser();
        $this->actingAs($user)
            ->post(route('videos.manage.store'), [
                'title' => 'Test Video',
                'url' => 'http://example.com',
                'series_id' => 1,
            ])->assertForbidden(); // Verifica que es retorna un 403
    }

    #[Test]
    public function user_with_permissions_can_destroy_videos()
    {
        $user = UserHelper::createVideoManagerUser();
        $video = Video::factory()->create();
        $this->actingAs($user)
            ->delete(route('videos.manage.destroy', $video->id))
            ->assertRedirect(route('videos.manage.index'));
    }

    #[Test]
    public function user_without_permissions_cannot_destroy_videos()
    {
        $user = UserHelper::createRegularUser();
        $video = Video::factory()->create();
        $this->actingAs($user)
            ->delete(route('videos.manage.destroy', $video->id))
            ->assertForbidden(); // Verifica que es retorna un 403
    }

    #[Test]
    public function user_with_permissions_can_see_edit_videos()
    {
        $user = UserHelper::createVideoManagerUser();
        $video = Video::factory()->create();
        $this->actingAs($user)
            ->get(route('videos.manage.edit', $video->id))
            ->assertStatus(200);
    }

    #[Test]
    public function user_without_permissions_cannot_see_edit_videos()
    {
        $user = UserHelper::createRegularUser();
        $video = Video::factory()->create();
        $this->actingAs($user)
            ->get(route('videos.manage.edit', $video->id))
            ->assertForbidden(); // Verifica que es retorna un 403
    }

    #[Test]
    public function user_with_permissions_can_update_videos()
    {
        $user = UserHelper::createVideoManagerUser();
        $video = Video::factory()->create();
        $this->actingAs($user)
            ->put(route('videos.manage.update', $video->id), ['title' => 'Updated Video'])
            ->assertRedirect(route('videos.manage.index'));
    }

    #[Test]
    public function user_without_permissions_cannot_update_videos()
    {
        $user = UserHelper::createRegularUser();
        $video = Video::factory()->create();
        $this->actingAs($user)
            ->put(route('videos.manage.update', $video->id), ['title' => 'Updated Video'])
            ->assertForbidden(); // Verifica que es retorna un 403
    }

    #[Test]
    public function user_with_permissions_can_manage_videos()
    {
        // Crear un usuari amb permisos per gestionar vídeos
        $user = UserHelper::createVideoManagerUser();

        // Crear 3 vídeos
        $videos = Video::factory()->count(3)->create();

        // Actuar com l'usuari i fer una petició a la ruta de gestió de vídeos
        $response = $this->actingAs($user)
            ->get(route('videos.manage.index'));

        // Verificar que la resposta té un estat 200 (OK)
        $response->assertStatus(200);

        // Verificar que els 3 vídeos es mostren a la vista
        foreach ($videos as $video) {
            $response->assertSee($video->title); // Verifica que el títol de cada vídeo es mostra
        }
    }

    #[Test]
    public function regular_users_cannot_manage_videos()
    {
        $user = UserHelper::createRegularUser();
        \Log::info('Regular user permissions: ' . implode(', ', $user->getAllPermissions()->pluck('name')->toArray()));
        $this->actingAs($user)
            ->get(route('videos.manage.index'))
            ->assertForbidden(); // Verifica que es retorna un 403
    }

    #[Test]
    public function guest_users_cannot_manage_videos()
    {
        $this->get(route('videos.manage.index'))
            ->assertRedirect(route('login')); // Verifica que es redirigeix a login
    }
}
