<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeCost;

class TypeCostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeCost::create(['description' => 'Actividad']);
        TypeCost::create(['description' => 'Administrativo']);
    }
}
