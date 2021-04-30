<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RefactorGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('goals')->truncate();
        Schema::table('goals', function (Blueprint $table) {
            $table->unsignedTinyInteger('days')->default(127)->after('to');
            $table->unsignedFloat('calories')->nullable()->after('name');
            $table->unsignedFloat('fat')->nullable()->after('calories');
            $table->unsignedFloat('cholesterol')->nullable()->after('fat');
            $table->unsignedFloat('sodium')->nullable()->after('cholesterol');
            $table->unsignedFloat('carbohydrates')->nullable()->after('sodium');
            $table->unsignedFloat('protein')->nullable()->after('carbohydrates');
            $table->dropColumn(['frequency', 'goal']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('goals')->truncate();
        Schema::table('goals', function (Blueprint $table) {
            $table->string('frequency')->nullable()->after('to');
            $table->unsignedFloat('goal')->nullable()->after('name');
            $table->dropColumn(['days', 'calories', 'fat', 'cholesterol', 'sodium', 'carbohydrates', 'protein']);
        });
    }
}
