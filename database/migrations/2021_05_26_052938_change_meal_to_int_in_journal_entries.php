<?php

use App\Models\JournalEntry;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeMealToIntInJournalEntries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journal_entries', function (Blueprint $table) {
            $table->integer('meal_int')->unsigned()->nullable()->after('protein');
        });
        DB::update('UPDATE `journal_entries` SET meal_int =
        IF(meal = "breakfast", 0,
            IF(meal = "lunch", 1,
                IF(meal = "dinner", 2, 3)
            )
        )');
        Schema::table('journal_entries', function (Blueprint $table) {
            $table->dropColumn('meal');
            $table->renameColumn('meal_int', 'meal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('journal_entries', function (Blueprint $table) {
            $table->renameColumn('meal', 'meal_int');
        });
        Schema::table('journal_entries', function (Blueprint $table) {
            $table->enum('meal', JournalEntry::meals()->pluck('value')->toArray())->after('protein');
        });
        DB::update('UPDATE `journal_entries` SET meal =
        IF(meal_int = 0, "breakfast",
            IF(meal_int = 1, "lunch",
                IF(meal_int = 2, "dinner", "snacks")
            )
        )');
        Schema::table('journal_entries', function (Blueprint $table) {
            $table->dropColumn('meal_int');
        });
    }
}
