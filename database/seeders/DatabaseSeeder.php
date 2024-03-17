<?php

namespace Database\Seeders;

use App\Models\EditorUi;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            ContractSeeder::class,
            EditorUiSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
