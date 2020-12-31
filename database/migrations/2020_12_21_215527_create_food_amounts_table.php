<?php

use App\Models\Food;
use App\Models\Recipe;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_amounts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Food::class);
            $table->unsignedFloat('amount');
            $table->enum('unit', ['tsp', 'tbsp', 'cup', 'oz'])->nullable();
            $table->foreignIdFor(Recipe::class);
            $table->unsignedInteger('weight');
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
        Schema::dropIfExists('food_amounts');
    }
}
