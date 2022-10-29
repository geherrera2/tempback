<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('farm_id')->constrained('farms')->onDelete('cascade');
            $table->foreignId('lot_id')->constrained('lots')->onDelete('cascade');
            $table->integer('amount_loads');
            $table->double('sale_value');
            $table->string('buyer')->nullable();
            // new
            $table->foreignId('sales_type_coffee_id')->constrained('sales_type_coffee')->onDelete('cascade');
            $table->integer('kilos_coffee_prod')->nullable();
            $table->integer('kilos_coffee_des')->nullable();
            $table->double('sale_value_base');
            $table->string('bonus')->nullable();
            $table->string('bonus_other')->nullable();
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
        Schema::dropIfExists('sales');
    }
}
