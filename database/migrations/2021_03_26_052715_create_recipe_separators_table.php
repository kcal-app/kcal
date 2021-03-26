<?php

use App\Models\Recipe;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeSeparatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_separators', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Recipe::class)->index()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('container')->index();
            $table->unsignedInteger('weight')->index();
            $table->longText('text')->nullable();
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
        Schema::dropIfExists('recipe_separators');
    }
}
