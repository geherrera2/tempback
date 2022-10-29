<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFarmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farms', function (Blueprint $table) {
            $table->id();
            $table->string('cadastral_record')->nullable();//Ficha catastral
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->foreignId('municipality_id')->constrained('municipalities')->onDelete('cascade');
            $table->foreignId('village_id')->constrained('villages')->onDelete('cascade');//Vereda
            $table->string('name');
            $table->string('ubication')->nullable();
            $table->integer('total_area');//Area total en Hectareas
            $table->foreignId('holding_id')->nullable()->constrained('holdings')->onDelete('cascade');//Tenencias
            $table->string('other_holding')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('available_area');
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
        Schema::dropIfExists('farms');
    }
}
