<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->isLocal()) {
            User::factory()->create([
                'name'  => 'Administrateur',
                'email' => 'admin@pdf.fr',
            ]);

            User::factory(10)->create();
        }
    }
}