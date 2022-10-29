<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeActivity;

class TypeActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeActivity::create(['description' => 'Instalación de Café']);
        TypeActivity::create(['description' => 'Renovación']);
        TypeActivity::create(['description' => 'Fertilización']);
        TypeActivity::create(['description' => 'Manejo de arvenses']);
        TypeActivity::create(['description' => 'Manejo de plagas y enfermedades']);
        TypeActivity::create(['description' => 'Recolección']);
        TypeActivity::create(['description' => 'Beneficio']);
        TypeActivity::create(['description' => 'Manejo de la acidez']);
        TypeActivity::create(['description' => 'Regulación de sombrio']);
        TypeActivity::create(['description' => 'Otras labores de sostenimiento']);
        
    }
}
