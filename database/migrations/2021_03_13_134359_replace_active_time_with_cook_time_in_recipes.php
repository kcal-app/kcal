<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReplaceActiveTimeWithCookTimeInRecipes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->integer('time_cook')->nullable()->after('time_prep');
        });
        DB::update("UPDATE `recipes` SET `time_cook` = `time_active`;");
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropColumn(['time_active']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropColumn(['time_cook']);
        });
    }
}
