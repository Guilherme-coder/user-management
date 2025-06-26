<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        Profile::firstOrCreate(['profile' => 'Administrador']);
        Profile::firstOrCreate(['profile' => 'Usuario']);
    }
}
