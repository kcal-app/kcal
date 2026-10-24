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
            $table->string('slug')->unique();
            $table->string('detail')->nullable();
            $table->string('brand')->nullable();
            $table->string('source')->nullable();
            $table->string('notes')->nullable();
            $table->decimal('serving_size', 10, 8)->unsigned();
            $table->enum('serving_unit', ['tsp', 'tbsp', 'cup', 'oz'])->nullable();
            $table->string('serving_unit_name')->nullable();
            $table->float('serving_weight')->unsigned();
            $table->float('calories')->unsigned()->default(0);
            $table->float('fat')->unsigned()->default(0);
            $table->float('cholesterol')->unsigned()->default(0);
            $table->float('sodium')->unsigned()->default(0);
            $table->float('carbohydrates')->unsigned()->default(0);
            $table->float('protein')->unsigned()->default(0);
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
