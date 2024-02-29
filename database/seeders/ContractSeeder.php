<?php

namespace Database\Seeders;

use App\Models\Contract;
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
            'name'            => 'Documentation',
            'slug'            => 'documentation',
            'form_schema'     => json_decode(file_get_contents(database_path('seeders/forms/test.json')), true),
            'content'         => file_get_contents(database_path('seeders/contracts/doc.html')),
            'is_published'    => true,
            'user_id'         => User::first()->id,
            'price'           => 4900,
            'signature_price' => 900,
        ]);

        Contract::create([
            'name'         => 'Exemple',
            'slug'         => 'exemple',
            'form_schema'  => json_decode(file_get_contents(database_path('seeders/forms/example.json')), true),
            'content'      => file_get_contents(database_path('seeders/contracts/example.html')),
            'is_published' => true,
            'user_id'      => User::first()->id,
            'price'        => 9999,
        ]);
    }
}
