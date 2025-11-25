<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Merchandise>
 */
class MerchandiseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $names = ['Tecnologia', 'Electrodomésticos', 'Alimentos en granel', 'Liquidos Consumibles', 'Medicamentos', 'Muebles', 'Repuestos', 'Químicos', 'Materiales de Construcción'];
        $tipos = ['Normal', 'Peligrosa', 'Extrapesada', 'Desechos Peligrosos'];
        
        return [
            'mercan_name' => fake()->randomElement($names),
            'mercan_type' => fake()->randomElement($tipos),
            'mercan_rndc_id' => fake()->unique()->bothify('RNDC-0000####-???'),
            'mercan_califi' => fake()->randomElement(['A1', 'B2', 'C3', 'D4']),
            'is_active' => true,
        ];
    }
}
