<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConvertCholesterolAndSodiumToMg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::update("UPDATE `foods` SET `cholesterol` = `cholesterol` * 1000;");
        DB::update("UPDATE `foods` SET `sodium` = `sodium` * 1000;");
        DB::update("UPDATE `journal_entries` SET `cholesterol` = `cholesterol` * 1000;");
        DB::update("UPDATE `journal_entries` SET `sodium` = `sodium` * 1000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::update("UPDATE `foods` SET `cholesterol` = `cholesterol`/1000;");
        DB::update("UPDATE `foods` SET `sodium` = `sodium`/1000;");
        DB::update("UPDATE `journal_entries` SET `cholesterol` = `cholesterol`/1000;");
        DB::update("UPDATE `journal_entries` SET `sodium` = `sodium`/1000;");
    }
}
