<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shipment>
 */
class ShipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $ciudades = ['Bogotá', 'Medellín', 'Cali', 'Barranquilla', 'Cartagena', 'Bucaramanga', 'Pereira', 'Manizales'];
        $estados = ['En Alistamiento', 'Asignado a Vehiculo', 'En Transito', 'Despacho Finalizado', 'Cancelado', 'Devuelto'];
        
        return [
            'tracking_number' => fake()->unique()->bothify('TRK-####-????'),
            'origin' => fake()->randomElement($ciudades),
            'destination' => fake()->randomElement($ciudades),
            'status' => fake()->randomElement($estados),
            'remesa' => fake()->optional()->bothify('REM-########'),
            'manifiesto' => fake()->optional()->bothify('MAN-########'),
            'date_manifiesto' => fake()->optional()->dateTimeBetween('-1 month', 'now'),
            'plate' => fake()->optional()->bothify('???-###'),
            'weight' => fake()->optional()->randomFloat(2, 10, 5000),
            'declared_price' => fake()->optional()->randomFloat(2, 100000, 50000000),
            'is_active' => true,
            'observation' => fake()->optional()->sentence(),
            'third_id_driver' => \App\Models\Third::factory(),
            'third_id_remite' => \App\Models\Third::factory(),
            'third_id_destin' => \App\Models\Third::factory(),
            'merchandise_id' => \App\Models\Merchandise::factory(),
            'created_by' => \App\Models\User::factory(),
            'updated_by' => null,
        ];
    }
}
