<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UnitMeasurement;

class UnitMeasurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UnitMeasurement::firstOrCreate([
            'name' => 'mg/kg'
        ]);

        UnitMeasurement::firstOrCreate([
            'name' => 'mg/L'
        ]);
    }
}
