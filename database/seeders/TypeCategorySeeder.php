<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeCategory;

class TypeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // TypeCategory::create(['description' => 'Bancos']);
        // TypeCategory::create(['description' => 'Estatal']);
        // TypeCategory::create(['description' => 'Servicios públicos']);

        TypeCategory::create(['description' => 'Mayordomo']);
        TypeCategory::create(['description' => 'Transporte']);
        TypeCategory::create(['description' => 'Impuesto predial']);
        TypeCategory::create(['description' => 'Papelería']);
        TypeCategory::create(['description' => 'Salario - Parafiscales']);
        TypeCategory::create(['description' => 'Prestaciones Sociales']);
        TypeCategory::create(['description' => 'Servicios públicos Agua']);
        TypeCategory::create(['description' => 'Servicios públicos Energía']);
        TypeCategory::create(['description' => 'Servicios públicos Gas']);
        TypeCategory::create(['description' => 'Servicios públicos Telefonía']);
        TypeCategory::create(['description' => 'Alimentación']);
        TypeCategory::create(['description' => 'Arriendo']);


    }
}
