<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_user_is_superadmin()
    {
        // Crear un usuari amb super_admin = true
        $user = User::factory()->create([
            'super_admin' => true,
        ]);

        // Verificar que isSuperAdmin() retorni true
        $this->assertTrue($user->isSuperAdmin());
    }

    #[Test]
    public function test_user_is_not_superadmin()
    {
        // Crear un usuari amb super_admin = false
        $user = User::factory()->create([
            'super_admin' => false,
        ]);

        // Verificar que isSuperAdmin() retorni false
        $this->assertFalse($user->isSuperAdmin());
    }

    #[Test]
    public function test_user_has_no_superadmin_field()
    {
        // Crear un usuari sense definir el camp super_admin
        $user = User::factory()->create();

        // Verificar que isSuperAdmin() retorni false per defecte
        $this->assertFalse($user->isSuperAdmin());
    }
}
