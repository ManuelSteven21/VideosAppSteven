<?php

namespace Tests\Feature\Videos;

use App\Models\User;
use App\Models\Series;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Helpers\UserHelper;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\Session;

class VideosManageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        UserHelper::createPermissions();
        UserHelper::defineGates();
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);

        // Añadir esto para manejar sesión en pruebas
        Session::start();
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
    public function regular_user_can_create_video()
    {
        $user = UserHelper::createRegularUser(); // Ya tiene create-videos según tu helper
        Series::factory()->create(['id' => 1]);

        Session::start();
        $token = csrf_token();

        $response = $this->actingAs($user)
            ->withHeaders(['Referer' => route('videos.manage.index')])
            ->post(route('videos.manage.store'), [
                '_token' => $token,
                'title' => 'Test Video',
                'description' => 'Test Description',
                'url' => 'http://example.com',
                'series_id' => 1,
            ]);

        $response->assertRedirect(); // No especificar ruta exacta por el controlador
        $this->assertDatabaseHas('videos', ['title' => 'Test Video']);
    }

    #[Test]
    public function user_with_permissions_can_store_videos()
    {
        $user = UserHelper::createVideoManagerUser();
        Series::factory()->create(['id' => 1]); // Crear la serie necesaria

        Session::start();
        $token = csrf_token();

        $response = $this->actingAs($user)
            ->post(route('videos.manage.store'), [
                '_token' => $token,
                'title' => 'Test Video',
                'description' => 'Test Description',
                'url' => 'http://example.com',
                'series_id' => 1,
                'user_id' => $user->id,
            ]);

        // Verificar redirección genérica ya que depende del referer
        $response->assertRedirect();
        $this->assertDatabaseHas('videos', ['title' => 'Test Video']);
    }

    #[Test]
    public function regular_user_can_view_own_video()
    {
        $user = UserHelper::createRegularUser();
        $video = Video::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->get(route('videos.show', $video->id));

        $response->assertStatus(200);
        $response->assertSee($video->title);
    }

    #[Test]
    public function regular_user_can_delete_own_video()
    {
        $user = UserHelper::createRegularUser();
        $video = Video::factory()->create(['user_id' => $user->id]);

        Session::start();
        $token = csrf_token();

        $response = $this->actingAs($user)
            ->withHeaders(['Referer' => route('videos.index')])
            ->delete(route('videos.manage.destroy', $video->id), [
                '_token' => $token,
            ]);

        $response->assertRedirect(route('videos.index'));
        $this->assertDatabaseMissing('videos', ['id' => $video->id]);
    }

    #[Test]
    public function user_with_permissions_can_destroy_videos()
    {
        $user = UserHelper::createVideoManagerUser();
        $video = Video::factory()->create();
        session(['video_deletion_referer' => route('videos.manage.index')]);

        $response = $this->actingAs($user)
            ->withHeaders(['Referer' => route('videos.manage.index')])
            ->delete(route('videos.manage.destroy', $video->id), [
                '_token' => csrf_token()
            ]);

        $this->assertDatabaseMissing('videos', ['id' => $video->id]);
        $response->assertRedirect(route('videos.manage.index'));
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
    public function regular_user_can_edit_own_video()
    {
        $user = UserHelper::createRegularUser();
        $video = Video::factory()->create(['user_id' => $user->id]);
        Session::start();
        $token = csrf_token();

        $this->actingAs($user)
            ->put(route('videos.manage.update', $video->id), [
                '_token' => $token,
                'title' => 'Updated Title',
            ])->assertRedirect();

        $this->assertDatabaseHas('videos', [
            'id' => $video->id,
            'title' => 'Updated Title',
        ]);
    }

    #[Test]
    public function user_with_permissions_can_update_videos()
    {
        $user = UserHelper::createVideoManagerUser();
        $video = Video::factory()->create();
        session(['video_edition_referer' => route('videos.manage.index')]);

        $response = $this->actingAs($user)
            ->withHeaders(['Referer' => route('videos.manage.index')])
            ->put(route('videos.manage.update', $video->id), [
                '_token' => csrf_token(),
                'title' => 'Updated Video'
            ]);

        $this->assertDatabaseHas('videos', ['id' => $video->id, 'title' => 'Updated Video']);
        $response->assertRedirect(route('videos.manage.index'));
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
            ->assertForbidden();
    }

    #[Test]
    public function guest_users_cannot_manage_videos()
    {
        $this->get(route('videos.manage.index'))
            ->assertRedirect(route('login')); // Verifica que es redirigeix a login
    }
}
