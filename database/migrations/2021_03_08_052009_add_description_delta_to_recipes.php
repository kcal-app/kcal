<?php

use App\Models\Recipe;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionDeltaToRecipes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->longText('description_delta')->nullable()->after('description');
        });

        foreach (Recipe::all() as $recipe) {
            if (empty($recipe->description)) {
                continue;
            }

            // Format as a basic Quill Delta.
            // See: https://quilljs.com/docs/delta/
            $delta = ['ops' => [['insert' => "{$recipe->description}\n"]]];
            $recipe->description_delta = json_encode($delta);
            $recipe->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropColumn('description_delta');
        });
    }
}
