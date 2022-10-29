<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeWork;

class TypeWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeWork::create([
            'description' => 'limpia'
        ]);

        TypeWork::create([
            'description' => 'Fertilización'
        ]);

        TypeWork::create([
            'description' => 'Control de malezas'
        ]);
    }
}
