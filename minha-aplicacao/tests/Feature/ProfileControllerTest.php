<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_profile(): void
    {
        $admin = $this->createUserAdmin();

        $response = $this->post(route('profiles.store'), [
            'profile' => 'Novo Perfil',
        ]);

        $response->assertRedirect(route('profiles.index'));
        $this->assertDatabaseHas('profiles', ['profile' => 'Novo Perfil']);
    }

    public function test_admin_can_update_profile(): void
    {
        $admin = $this->createUserAdmin();
        $profile = Profile::create(['profile' => 'Perfil nome antigo']);

        $response = $this->put(route('profiles.update', $profile), [
            'profile' => 'Perfil nome novo',
        ]);

        $response->assertRedirect(route('profiles.index'));
        $this->assertDatabaseHas('profiles', ['id' => $profile->id, 'profile' => 'Perfil nome novo']);
    }

    public function test_admin_can_delete_profile(): void
    {
        $admin = $this->createUserAdmin();
        $profile = Profile::create(['profile' => 'Perfil criado']);

        $response = $this->delete(route('profiles.destroy', $profile));

        $response->assertRedirect(route('profiles.index'));
        $this->assertSoftDeleted('profiles', ['id' => $profile->id]);
    }

    public function test_non_admin_cannot_create_profile(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('profiles.store'), [
            'profile' => 'Novo Perfil',
        ]);

        $response->assertForbidden();
        $this->assertDatabaseMissing('profiles', ['profile' => 'Novo Perfil']);
    }

    public function test_non_admin_cannot_update_profile(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $profile = Profile::create(['profile' => 'Perfil nome antigo']);

        $response = $this->put(route('profiles.update', $profile), [
            'profile' => 'Perfil nome novo',
        ]);

        $response->assertForbidden();
        $this->assertDatabaseHas('profiles', ['id' => $profile->id, 'profile' => 'Perfil nome antigo']);
    }

    public function test_non_admin_cannot_delete_profile(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $profile = Profile::create(['profile' => 'Perfil criado']);

        $response = $this->delete(route('profiles.destroy', $profile));

        $response->assertForbidden();
        $this->assertDatabaseHas('profiles', ['id' => $profile->id]);
    }

    public function test_admin_can_sync_users_to_profile(): void
    {
        $admin = $this->createUserAdmin();

        $profile = Profile::create(['profile' => 'Gerente']);
        $targetUsers = User::factory(5)->create();

        $userIds = $targetUsers->pluck('id')->toArray();

        $response = $this->post(route('profiles.syncUsers', $profile), [
            'users' => $userIds,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertEqualsCanonicalizing(
            $userIds,
            $profile->users()->pluck('id')->toArray()
        );
    }

    public function test_non_admin_cannot_sync_users_to_profile(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $profile = Profile::create(['profile' => 'Gerente']);
        $targetUsers = User::factory(3)->create();

        $userIds = $targetUsers->pluck('id')->toArray();

        $response = $this->post(route('profiles.syncUsers', $profile), [
            'users' => $userIds,
        ]);

        $response->assertForbidden();
        $this->assertEmpty($profile->users);
    }

    public function test_admin_profile_cannot_be_deleted(): void
    {
        $admin = User::factory()->create();
        $adminProfile = Profile::create(['profile' => 'Administrador']);
        $admin->profiles()->attach($adminProfile->id);

        $this->actingAs($admin);

        $response = $this->delete(route('profiles.destroy', $adminProfile));
        $response->assertRedirect(route('profiles.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('profiles', ['profile' => 'Administrador']);
    }

    public function test_user_profile_cannot_be_deleted(): void
    {
        $admin = User::factory()->create();
        $adminProfile = Profile::create(['profile' => 'Administrador']);
        $admin->profiles()->attach($adminProfile->id);

        $userProfile = Profile::create(['profile' => 'Usuario']);

        $this->actingAs($admin);

        $response = $this->delete(route('profiles.destroy', $userProfile));
        $response->assertRedirect(route('profiles.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('profiles', ['profile' => 'Usuario']);
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
