<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_cost_id')->constrained('type_costs')->onDelete('cascade');
            $table->foreignId('type_category_id')->nullable()->constrained('type_categories')->onDelete('cascade');
            $table->foreignId('type_activity_id')->nullable()->constrained('type_activities')->onDelete('cascade');
            $table->foreignId('farm_id')->constrained('farms')->onDelete('cascade');
            $table->foreignId('lot_id')->nullable()->constrained('lots')->onDelete('cascade');
            $table->foreignId('stage_id')->constrained('stages')->onDelete('cascade');
            $table->foreignId('type_work_id')->nullable()->constrained('type_works')->onDelete('cascade');
            $table->double('amount');
            $table->double('unit_cost');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('costs');
    }
}
