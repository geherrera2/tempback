<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('total_area');
            $table->string('ubication')->nullable();
            $table->integer('above_sea_level')->nullable();//Altura nivel del mar
            $table->text('description')->nullable();//Descripcion
            $table->foreignId('varietie_coffee_id')->nullable()->constrained('varietie_coffees')->onDelete('cascade');//Variedad cafe
            $table->string('other_varietie_coffe')->nullable();
            $table->foreignId('renewal_id')->nullable()->constrained('renewals')->onDelete('cascade');//Renovacion
            $table->foreignId('type_renewal_id')->nullable()->constrained('type_renewals')->onDelete('cascade');//Tipo renovacion
            $table->date('date_renewal')->nullable();//Fecha renovacion
            $table->integer('age')->nullable();//Edad en meses
            $table->foreignId('brightness_id')->nullable()->constrained('brightnesses')->onDelete('cascade');//Luminosidad
            $table->string('range_brightness')->nullable(); //Rango luminosidad           
            $table->foreignId('type_somber_id')->nullable()->constrained('type_sombers')->onDelete('cascade');//Tipo sombrio
            $table->foreignId('stroke_id')->nullable()->constrained('strokes')->onDelete('cascade');//Trazo
            $table->integer('number_plants');
            $table->integer('distance_sites');//Distancia sitios
            $table->integer('distance_furrow');//Distancia surco
            $table->integer('stems_sites');//Tallos por sitios
            $table->integer('density_hectares')->nullable();//Densidad en hectareas
            $table->integer('sites_crop');//sitios por cultivo
            $table->foreignId('farm_id')->constrained('farms')->onDelete('cascade');
            $table->boolean('state')->default('true');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lots');
    }
}
