<?php

namespace Database\Seeders;

use App\Models\Contract;
use App\Models\Form;
use App\Models\User;
use Illuminate\Database\Seeder;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contract::create([
            'name'         => 'Documentation',
            'slug'         => 'documentation',
            'content'      => file_get_contents(database_path('seeders/contracts/doc.md')),
            'is_published' => true,
            'user_id'      => User::first()->id,
            'form_id'      => Form::first()->id,
        ]);

        if (app()->isLocal()) {
            Contract::factory(10)->create();
        }
    }
}
