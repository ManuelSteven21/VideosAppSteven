<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Helpers\UserHelper;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\Session;


class UsersManageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        UserHelper::createPermissions();
        UserHelper::defineGates();
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
        $this->withoutMiddleware(\Illuminate\Auth\Middleware\RedirectIfAuthenticated::class);
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
        $this->assertTrue($user->can('manage-users'));
    }

    #[Test]
    public function loginAsRegularUser()
    {
        $user = UserHelper::createRegularUser();
        $this->actingAs($user);
        $this->assertFalse($user->can('manage-users'));
    }

    #[Test]
    public function user_with_permissions_can_see_add_users()
    {
        $user = UserHelper::createSuperAdminUser();
        $this->actingAs($user)
            ->get(route('users.manage.create'))
            ->assertStatus(200);
    }

    #[Test]
    public function user_without_users_manage_create_cannot_see_add_users()
    {
        $user = UserHelper::createRegularUser();
        $this->actingAs($user)
            ->get(route('users.manage.create'))
            ->assertForbidden();
    }

    #[Test]
    public function user_with_permissions_can_store_users()
    {
        $user = UserHelper::createSuperAdminUser();
        $this->actingAs($user);

        // Generar token CSRF y añadirlo a la solicitud
        Session::start();
        $token = csrf_token();

        $response = $this->post(route('users.manage.store'), [
            '_token' => $token,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'role' => 'regular',
        ]);

        $response->assertRedirect(route('users.manage.index'));
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    #[Test]
    public function user_without_permissions_cannot_store_users()
    {
        $user = UserHelper::createRegularUser();
        $this->actingAs($user);

        Session::start();
        $token = csrf_token();

        $response = $this->post(route('users.manage.store'), [
            '_token' => $token,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'role' => 'regular',
        ]);

        $response->assertForbidden();
    }

    #[Test]
    public function user_with_permissions_can_destroy_users()
    {
        $user = UserHelper::createSuperAdminUser();
        $this->actingAs($user);
        $userToDelete = UserHelper::createRegularUser();

        Session::start();
        $token = csrf_token();

        $response = $this->delete(route('users.manage.destroy', $userToDelete->id), [
            '_token' => $token,
        ]);

        $response->assertRedirect(route('users.manage.index'));
        $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
    }

    #[Test]
    public function user_without_permissions_cannot_destroy_users()
    {
        $user = UserHelper::createRegularUser();
        $userToDelete = UserHelper::createDefaultUser();

        Session::start();
        $token = csrf_token();

        $response = $this->actingAs($user)
            ->delete(route('users.manage.destroy', $userToDelete->id), [
                '_token' => $token,
            ]);

        $response->assertForbidden();
        $this->assertDatabaseHas('users', ['id' => $userToDelete->id]);
    }

    #[Test]
    public function user_with_permissions_can_see_edit_users()
    {
        $user = UserHelper::createSuperAdminUser();
        $userToEdit = UserHelper::createRegularUser();
        $this->actingAs($user)
            ->get(route('users.manage.edit', $userToEdit->id))
            ->assertStatus(200);
    }

    #[Test]
    public function user_without_permissions_cannot_see_edit_users()
    {
        $user = UserHelper::createRegularUser();
        $userToEdit = UserHelper::createDefaultUser();
        $this->actingAs($user)
            ->get(route('users.manage.edit', $userToEdit->id))
            ->assertForbidden();
    }

    #[Test]
    public function user_with_permissions_can_update_users()
    {
        $user = UserHelper::createSuperAdminUser();
        $userToUpdate = UserHelper::createRegularUser();

        Session::start();
        $token = csrf_token();

        $response = $this->actingAs($user)
            ->put(route('users.manage.update', $userToUpdate->id), [
                '_token' => $token,
                'name' => 'Updated User',
                'email' => 'updated@example.com',
                'role' => 'video_manager',
            ]);

        $response->assertRedirect(route('users.manage.index'));
        $this->assertDatabaseHas('users', [
            'id' => $userToUpdate->id,
            'name' => 'Updated User',
            'email' => 'updated@example.com'
        ]);
    }

    #[Test]
    public function user_without_permissions_cannot_update_users()
    {
        $user = UserHelper::createRegularUser();
        $userToUpdate = UserHelper::createDefaultUser();

        Session::start();
        $token = csrf_token();

        $response = $this->actingAs($user)
            ->put(route('users.manage.update', $userToUpdate->id), [
                '_token' => $token,
                'name' => 'Updated User',
                'email' => 'updated_' . uniqid() . '@example.com',
                'role' => 'video_manager',
            ]);

        $response->assertForbidden();
        $this->assertDatabaseMissing('users', [
            'id' => $userToUpdate->id,
            'name' => 'Updated User'
        ]);
    }

    #[Test]
    public function user_with_permissions_can_manage_users()
    {
        $user = UserHelper::createSuperAdminUser();
        $this->actingAs($user)
            ->get(route('users.manage.index'))
            ->assertStatus(200);
    }

    #[Test]
    public function regular_users_cannot_manage_users()
    {
        $user = UserHelper::createRegularUser();
        $this->actingAs($user)
            ->get(route('users.manage.index'))
            ->assertForbidden();
    }

    #[Test]
    public function guest_users_cannot_manage_users()
    {
        $this->get(route('users.manage.index'))
            ->assertRedirect(route('login'));
    }

    #[Test]
    public function superadmins_can_manage_users()
    {
        $user = UserHelper::createSuperAdminUser();
        $this->actingAs($user)
            ->get(route('users.manage.index'))
            ->assertStatus(200);
    }
}
