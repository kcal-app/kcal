<?php

use App\Models\Food;
use App\Models\Recipe;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

class ConvertNamesLowercase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (Recipe::all() as $recipe) {
            $recipe->name = Str::lower($recipe->name);
            $recipe->save();
        }
        foreach (Food::all() as $recipe) {
            $recipe->name = Str::lower($recipe->name);
            $recipe->save();
        }
    }

}
