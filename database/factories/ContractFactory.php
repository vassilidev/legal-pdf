<?php

namespace Database\Factories;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contract>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'         => fake()->jobTitle,
            'content'      => '**' . fake()->sentence . '**',
            'is_published' => fake()->boolean(70),
            'user_id'      => User::inRandomOrder()->first()->id,
            'price'        => fake()->numberBetween(2000, 99999),
        ];
    }
}
