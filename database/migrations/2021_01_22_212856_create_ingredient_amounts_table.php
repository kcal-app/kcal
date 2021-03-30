<?php

use App\Support\Nutrients;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngredientAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredient_amounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('ingredient_id');
            $table->string('ingredient_type');
            $table->unsignedFloat('amount');
            $table->enum('unit', Nutrients::units()->pluck('value')->toArray())->nullable();
            $table->string('detail')->nullable();
            $table->unsignedInteger('weight');
            $table->unsignedInteger('parent_id')->index();
            $table->string('parent_type');
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
        Schema::dropIfExists('ingredient_amounts');
    }
}
