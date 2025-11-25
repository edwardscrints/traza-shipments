<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Crear usuarios de prueba
        \App\Models\User::factory()->create([
            'name' => 'AdminGabriel',
            'email' => 'edward.gabriel@grupooet.com',
            'password' => bcrypt('password'),
        ]);
        
        \App\Models\User::factory(5)->create();

        \App\Models\Third::factory(60)->create();

        \App\Models\Merchandise::factory(90)->create();

        \App\Models\Shipment::factory(20)->create();

        $this->command->info('Base de datos poblada exitosamente!');
    }
}
