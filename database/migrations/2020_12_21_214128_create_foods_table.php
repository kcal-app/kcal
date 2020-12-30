<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('detail')->nullable();
            $table->unsignedFloat('calories')->default(0);
            $table->unsignedFloat('carbohydrates')->default(0);
            $table->unsignedFloat('cholesterol')->default(0);
            $table->unsignedFloat('fat')->default(0);
            $table->unsignedFloat('protein')->default(0);
            $table->unsignedFloat('sodium')->default(0);
            $table->unsignedFloat('unit_weight')->nullable();
            $table->unsignedFloat('cup_weight')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
}
