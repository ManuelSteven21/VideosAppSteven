<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\Models\User;
use App\Helpers\UserHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Crea permisos i rols amb el helper
        UserHelper::createPermissions();
    }

    #[Test]
    public function user_without_permissions_can_see_default_users_page()
    {
        $user = UserHelper::createRegularUser();

        $response = $this->actingAs($user)->get(route('users.index'));

        $response->assertStatus(200);
    }

    #[Test]
    public function user_with_permissions_can_see_default_users_page()
    {
        $user = UserHelper::createVideoManagerUser();

        $response = $this->actingAs($user)->get(route('users.index'));

        $response->assertStatus(200);
    }

    #[Test]
    public function not_logged_users_cannot_see_default_users_page()
    {
        $response = $this->get(route('users.index'));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function user_without_permissions_can_see_user_show_page()
    {
        $user = UserHelper::createRegularUser();
        $targetUser = UserHelper::createSuperAdminUser();

        $response = $this->actingAs($user)->get(route('users.show', $targetUser->id));

        $response->assertStatus(200);
    }

    #[Test]
    public function user_with_permissions_can_see_user_show_page()
    {
        $user = UserHelper::createSuperAdminUser();
        $targetUser = UserHelper::createRegularUser();

        $response = $this->actingAs($user)->get(route('users.show', $targetUser->id));

        $response->assertStatus(200);
    }

    #[Test]
    public function not_logged_users_cannot_see_user_show_page()
    {
        $targetUser = UserHelper::createRegularUser();

        $response = $this->get(route('users.show', $targetUser->id));

        $response->assertRedirect(route('login'));
    }
}
