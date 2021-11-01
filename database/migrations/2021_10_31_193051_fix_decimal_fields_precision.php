<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixDecimalFieldsPrecision extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('foods', function (Blueprint $table) {
            $table->decimal('serving_size', 14, 8)->unsigned()->change();
        });
        Schema::table('recipes', function (Blueprint $table) {
            $table->decimal('volume', 14, 8)->unsigned()->nullable()->change();
        });
        Schema::table('ingredient_amounts', function (Blueprint $table) {
            $table->decimal('amount', 14, 8)->unsigned()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('foods', function (Blueprint $table) {
            $table->decimal('serving_size', 10, 8)->unsigned()->change();
        });
        Schema::table('recipes', function (Blueprint $table) {
            $table->decimal('volume', 10, 8)->unsigned()->nullable()->change();
        });
        Schema::table('ingredient_amounts', function (Blueprint $table) {
            $table->decimal('amount', 10, 8)->unsigned()->change();
        });
    }
}
