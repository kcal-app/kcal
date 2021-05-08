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
            $table->unsignedTinyInteger('days')->default(127)->after('name');
            $table->unsignedFloat('calories')->nullable()->after('days');
            $table->unsignedFloat('fat')->nullable()->after('calories');
            $table->unsignedFloat('cholesterol')->nullable()->after('fat');
            $table->unsignedFloat('sodium')->nullable()->after('cholesterol');
            $table->unsignedFloat('carbohydrates')->nullable()->after('sodium');
            $table->unsignedFloat('protein')->nullable()->after('carbohydrates');
            $table->dropColumn(['frequency', 'from', 'goal', 'to']);
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
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->string('frequency')->nullable();
            $table->unsignedFloat('goal')->nullable();
            $table->dropColumn(['days', 'calories', 'fat', 'cholesterol', 'sodium', 'carbohydrates', 'protein']);
        });
    }
}
