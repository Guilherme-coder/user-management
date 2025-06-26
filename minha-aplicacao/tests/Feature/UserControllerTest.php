<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_user_with_profiles(): void
    {
        $admin = $this->createUserAdmin();

        $profile = Profile::create(['profile' => 'Test name profile']);

        $response = $this->post(route('users.store'), [
            'name' => 'User created by admin',
            'email' => 'user@test.com',
            'password' => 'password',
            'profiles' => [$profile->id],
        ]);

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', ['email' => 'user@test.com']);
    }

    public function test_admin_can_update_user(): void
    {
        $admin = $this->createUserAdmin();
        $user = User::factory()->create(['name' => 'Teste']);

        $response = $this->put(route('users.update', $user), [
            'name' => 'Teste editado',
            'email' => $user->email,
        ]);

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Teste editado']);
    }

    public function test_admin_can_delete_user(): void
    {
        $admin = $this->createUserAdmin();
        $user = User::factory()->create();

        $response = $this->delete(route('users.destroy', $user));

        $response->assertRedirect(route('users.index'));
        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    public function test_non_admin_cannot_create_user(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $profile = Profile::create(['profile' => 'Usuario']);

        $response = $this->post(route('users.store'), [
            'name' => 'User created by admin',
            'email' => 'user@test.com',
            'password' => 'password',
            'profiles' => [$profile->id],
        ]);

        $response->assertForbidden();
        $this->assertDatabaseMissing('users', ['email' => 'user@test.com']);
    }

    public function test_non_admin_cannot_update_user(): void
    {
        $userNonAdmin = User::factory()->create();
        $this->actingAs($userNonAdmin);

        $user = User::factory()->create(['name' => 'Teste']);

        $response = $this->put(route('users.update', $user), [
            'name' => 'Teste editado',
            'email' => $user->email,
        ]);

        $response->assertForbidden();
        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Teste']);
    }

    public function test_non_admin_cannot_delete_user(): void
    {
        $userNonAdmin = User::factory()->create();
        $this->actingAs($userNonAdmin);

        $user = User::factory()->create();

        $response = $this->delete(route('users.destroy', $user));

        $response->assertForbidden();
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    public function test_user_with_admin_profile_cannot_be_deleted(): void
    {
        $admin = $this->createUserAdmin();

        $response = $this->delete(route('users.destroy', $admin));
        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    private function createUserAdmin(): User
    {
        $admin = User::factory()->create();
        $adminProfile = Profile::create(['profile' => 'Administrador']);
        $admin->profiles()->attach($adminProfile->id);
        $this->actingAs($admin);

        return $admin;
    }
}
