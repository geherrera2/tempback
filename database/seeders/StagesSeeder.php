<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stage;

class StagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Stage::create(['description' => 'Instalación']);
        Stage::create(['description' => 'Producción']);
        Stage::create(['description' => 'Recolección']);
    }
}
