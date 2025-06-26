<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminProfile = Profile::where('profile', 'Administrador')->first();
        $userProfile = Profile::where('profile', 'Usuario')->first();

        $adminUser = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@claro.com',
        ]);
        $adminUser->profiles()->attach($adminProfile->id);

        $users = User::factory(100)->create();
        foreach ($users as $user) {
            $user->profiles()->attach($userProfile->id);
        }
    }
}
