<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VarietieCoffee;
use App\Models\Renewal;
use App\Models\TypeRenewal;
use App\Models\Brightness;
use App\Models\TypeSomber;
use App\Models\Stroke;

class RelationsLotsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Varieties coffees
        VarietieCoffee::create(
            ['description' => 'Borbón']
        );

        VarietieCoffee::create(
            ['description' => 'Caturra']
        );

        VarietieCoffee::create(
            ['description' => 'Castillo Regional']
        );

        VarietieCoffee::create(
            ['description' => 'Castillo General']
        );

        VarietieCoffee::create(
            ['description' => 'Cenicafé 1']
        );

        VarietieCoffee::create(
            ['description' => 'Típica']
        );

        VarietieCoffee::create(
            ['description' => 'Maragogipe']
        );

        VarietieCoffee::create(
            ['description' => 'Tabi']
        );

        VarietieCoffee::create(
            ['description' => 'Variedad Colombia']
        );

        //Renewal
        Renewal::create([
            'description' => 'Renovación por Zoca'
        ]);

        Renewal::create([
            'description' => 'Renovación por Siembra'
        ]);

        Renewal::create([
            'description' => 'Poda Calavera'
        ]);

        Renewal::create([
            'description' => 'Poda Pulmón'
        ]);

        //Renewal Type
        TypeRenewal::create([
            'description' => 'Tipo renovación'
        ]);

        TypeRenewal::create([
            'description' => 'Tradicional'
        ]);

        //Brightness       

        Brightness::create([
            'id' => 1,
            'description' => 'Sol, entre 0 y 19%',
        ]);

        Brightness::create([
            'id' => 2,
            'description' => 'Semisombra, entre 20 - 55%',
        ]);

        Brightness::create([
            'id' => 3,
            'description' => 'Sombra, > 55 %',
        ]);

        //Type Sombers
        TypeSomber::create([
            'description' => 'Permanente',
        ]);

        TypeSomber::create([
            'description' => 'Transitorio',
        ]);

        //Strokes
        Stroke::create([
            'description' => 'Cuadrado'
        ]);

        Stroke::create([
            'description' => 'Triángulo'
        ]);
    }
}
