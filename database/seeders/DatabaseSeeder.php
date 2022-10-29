<?php

namespace Database\Seeders;

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
        $this->call([
            SetupSeeder::class,
            RolesAndPermissions::class,
            DocumentTypes::class,
            DepartmentSeeder::class,
            HoldingSeeder::class,
            RelationsLotsSeeder::class,
            ProductTypeSeeder::class,
            UnitMeasurementSeeder::class,
            StagesSeeder::class,
            TypeActivitySeeder::class,
            TypeCategorySeeder::class,
            TypeCostSeeder::class,
            TypeWorkSeeder::class,
            SalesTypeCoffee::class
        ]);        
    }
}
