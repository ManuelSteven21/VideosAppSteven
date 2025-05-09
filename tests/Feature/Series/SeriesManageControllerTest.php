<?php

namespace Tests\Feature\Series;

use App\Models\Series;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use App\Helpers\UserHelper;

class SeriesManageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        UserHelper::createPermissions();
        UserHelper::defineGates();
        // Puedes mantenerlo o quitarlo si agregas el token manualmente:
        // $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function loginAsVideoManager()
    {
        $user = UserHelper::createVideoManagerUser();
        $this->actingAs($user);
        $this->assertTrue($user->can('manage-videos'));
    }

    public function loginAsSuperAdmin()
    {
        $user = UserHelper::createSuperAdminUser();
        $this->actingAs($user);
        return $user;
    }

    public function loginAsRegularUser()
    {
        $user = UserHelper::createRegularUser();
        $this->actingAs($user);
        return $user;
    }

    public function test_user_with_permissions_can_see_add_series()
    {
        $this->loginAsSuperAdmin();
        $response = $this->get(route('series.manage.create'));
        $response->assertStatus(200);
    }

    public function test_user_with_permissions_can_store_series()
    {
        $this->loginAsSuperAdmin();
        Session::start();

        $data = [
            '_token'      => csrf_token(),
            'title'       => 'Test Series',
            'description' => 'Test Description',
            'image'       => 'http://example.com/image.jpg',
        ];

        $response = $this->post(route('series.manage.store'), $data);
        $response->assertRedirect(route('series.show', Series::first()->id));
        $this->assertDatabaseHas('series', ['title' => 'Test Series']);
    }

    public function test_user_with_permissions_can_destroy_series()
    {
        $this->loginAsSuperAdmin();
        Session::start();

        $series = Series::factory()->create();
        $response = $this->delete(route('series.manage.destroy', $series->id), ['_token' => csrf_token()]);
        $response->assertRedirect(route('series.index'));
        $this->assertDatabaseMissing('series', ['id' => $series->id]);
    }

    public function test_user_with_permissions_can_see_edit_series()
    {
        $this->loginAsSuperAdmin();
        $series = Series::factory()->create();
        $response = $this->get(route('series.manage.edit', $series->id));
        $response->assertStatus(200);
    }

    public function test_user_with_permissions_can_update_series()
    {
        $this->loginAsSuperAdmin();
        Session::start();

        $series = Series::factory()->create();
        $data = [
            '_token'      => csrf_token(),
            'title'       => 'Updated Title',
            'description' => 'Updated Description',
            'image'       => 'http://example.com/newimage.jpg',
        ];
        $response = $this->put(route('series.manage.update', $series->id), $data);
        $response->assertRedirect(route('series.show', $series->id));
        $this->assertDatabaseHas('series', ['title' => 'Updated Title']);
    }

    public function test_user_with_permissions_can_manage_series()
    {
        $this->loginAsSuperAdmin();
        $response = $this->get(route('series.manage.index'));
        $response->assertStatus(200);
    }

    public function test_regular_users_cannot_manage_series()
    {
        $this->loginAsRegularUser();
        $response = $this->get(route('series.manage.index'));
        $response->assertStatus(403);
    }

    public function test_guest_users_cannot_manage_series()
    {
        $response = $this->get(route('series.manage.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_videomanagers_can_manage_series()
    {
        $this->loginAsVideoManager();
        $response = $this->get(route('series.manage.index'));
        $response->assertStatus(200);
    }

    public function test_superadmins_can_manage_series()
    {
        $this->loginAsSuperAdmin();
        $response = $this->get(route('series.manage.index'));
        $response->assertStatus(200);
    }
}
