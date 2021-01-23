<?php

use Illuminate\Database\Migrations\Migration;

class ConvertFoodAmountsToIngredientAmounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('ingredient_amounts')->truncate();
        $query = "INSERT INTO ingredient_amounts (ingredient_id, ingredient_type, amount, unit, detail, weight, parent_id, parent_type, created_at, updated_at) VALUES ";
        $foodAmounts = DB::select(DB::raw("SELECT * FROM food_amounts;"));
        foreach ($foodAmounts as $foodAmount) {
            $query .= sprintf("(%d, '%s', %s, %s, %s, %s, %d, '%s', '%s', '%s'),", ...[
                $foodAmount->food_id,
                'App\Models\Food',
                $foodAmount->amount,
                $foodAmount->unit ? "'{$foodAmount->unit}'" : 'null',
                $foodAmount->detail ? "'" . addslashes($foodAmount->detail) . "'" : 'null',
                $foodAmount->weight,
                $foodAmount->recipe_id,
                'App\Models\Recipe',
                $foodAmount->created_at,
                $foodAmount->updated_at,
            ]);
        }
        $query = substr($query, 0, -1) . ';';
        DB::unprepared($query);
        DB::table('food_amounts')->truncate();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('food_amounts')->truncate();
        $query = "INSERT INTO food_amounts (food_id, amount, unit, recipe_id, weight, created_at, updated_at, detail) VALUES ";
        $ingredientAmounts = DB::select(DB::raw("SELECT * FROM ingredient_amounts WHERE ingredient_type = 'App\Models\Food';"));
        foreach ($ingredientAmounts as $ingredientAmount) {
            $query .= sprintf("(%d, %s, %s, %d, %s, '%s', '%s', %s),", ...[
                $ingredientAmount->ingredient_id,
                $ingredientAmount->amount,
                $ingredientAmount->unit ? "'{$ingredientAmount->unit}'" : 'null',
                $ingredientAmount->parent_id,
                $ingredientAmount->weight,
                $ingredientAmount->created_at,
                $ingredientAmount->updated_at,
                $ingredientAmount->detail ? "'" . addslashes($ingredientAmount->detail) . "'" : 'null',
            ]);
        }
        $query = substr($query, 0, -1) . ';';
        DB::unprepared($query);
        DB::table('ingredient_amounts')->truncate();
    }
}
