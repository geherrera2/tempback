<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostSupplieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cost_supplie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cost_id')->constrained('costs')->onDelete('cascade');
            $table->foreignId('supplie_id')->constrained('supplies')->onDelete('cascade');
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
        Schema::dropIfExists('cost_supplie');
    }
}
