<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Administrateur',
            'email'    => 'admin@pdf.fr',
            'password' => bcrypt('password'),
        ])->assignRole('Super Admin');

        if (app()->isLocal()) {
            User::factory(10)->create();
        }
    }
}