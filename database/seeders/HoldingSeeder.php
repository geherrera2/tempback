<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Holding;

class HoldingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Holding::firstOrCreate(['description' => 'Administrador']);
        Holding::firstOrCreate(['description' => 'Aparceros']);
        Holding::firstOrCreate(['description' => 'Arrendatario']);
        Holding::firstOrCreate(['description' => 'Herencia']);
        Holding::firstOrCreate(['description' => 'Miembro del Grupo Familiar']);
        Holding::firstOrCreate(['description' => 'Propietario']);
        Holding::firstOrCreate(['description' => 'Resguardos Indigenas']);
        Holding::firstOrCreate(['description' => 'Trabajador Permanente']);
    }
}
