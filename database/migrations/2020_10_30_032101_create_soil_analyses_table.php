<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoilAnalysesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soil_analyses', function (Blueprint $table) {
            $table->id();
            $table->date('analysis_date');
            $table->integer('ph')->nullable();
            $table->integer('organic_matter')->nullable();
            $table->integer('phosphates')->nullable();
            $table->integer('calcium')->nullable();
            $table->integer('magnesium')->nullable();
            $table->integer('potassium')->nullable(); 
            $table->integer('aluminum')->nullable();
            $table->integer('sulphur')->nullable();
            $table->string('texture')->nullable();
            $table->foreignId('lot_id')->constrained('lots')->onDelete('cascade');
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
        Schema::dropIfExists('soil_analyses');
    }
}
