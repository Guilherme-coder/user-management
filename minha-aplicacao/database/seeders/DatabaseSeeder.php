<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminProfile = Profile::firstOrCreate(['profile' => 'Administrador']);
        $userProfile = Profile::firstOrCreate(['profile' => 'Usuario']);

        $adminUser = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@claro.com',
        ]);
        $adminUser->profiles()->attach($adminProfile->id);

        $users = User::factory(10)->create();
        foreach ($users as $user) {
            $user->profiles()->attach($userProfile->id);
        }
    }
}
