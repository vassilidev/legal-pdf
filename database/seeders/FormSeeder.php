<?php

namespace Database\Seeders;

use App\Models\Form;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Form::create([
            'name'        => 'Test',
            'form_schema' => json_decode(file_get_contents(database_path('seeders/forms/test.json')), true),
            'user_id'     => User::first()->id,
        ]);

        Form::create([
            'name'        => 'Exemple',
            'form_schema' => json_decode(file_get_contents(database_path('seeders/forms/example.json')), true),
            'user_id'     => User::first()->id,
        ]);
    }
}
