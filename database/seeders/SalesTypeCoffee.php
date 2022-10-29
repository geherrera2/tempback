<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeCoffeeSale;

class SalesTypeCoffee extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeCoffeeSale::create(['description' => 'Pasilla']);
        TypeCoffeeSale::create(['description' => 'Café Permamino Seco']);
        TypeCoffeeSale::create(['description' => 'Café Humedo']);
        TypeCoffeeSale::create(['description' => 'Cafe Cereza']);
    }
}
