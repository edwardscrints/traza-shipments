<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Third>
 */
class ThirdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'third_name' => fake()->name(),
            'document_type' => fake()->randomElement(['CC', 'NIT', 'CE', 'PPT', 'TI']),
            'document_number' => fake()->unique()->numerify('##########'),
            'third_type' => fake()->randomElement(['cliente remitente', 'conductor', 'transportadora']),
            'third_address' => fake()->address(),
            'is_active' => true,
        ];
    }
}
