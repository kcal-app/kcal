<?php

use App\Models\JournalEntry;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCascadeConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Recipe steps.
        Schema::rename('recipe_steps', 'recipe_steps_old');
        Schema::create('recipe_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Recipe::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedInteger('number');
            $table->longText('step');
            $table->timestamps();
        });
        DB::insert("INSERT INTO `recipe_steps` SELECT * FROM `recipe_steps_old`;");
        Schema::dropIfExists('recipe_steps_old');
        Schema::table('recipe_steps', function (Blueprint $table) {
            $table->index('recipe_id');
            $table->index('number');
        });

        // Journal entries.
        Schema::rename('journal_entries', 'journal_entries_old');
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('date')->useCurrent();
            $table->string('summary');
            $table->unsignedFloat('calories')->default(0);
            $table->unsignedFloat('fat')->default(0);
            $table->unsignedFloat('cholesterol')->default(0);
            $table->unsignedFloat('sodium')->default(0);
            $table->unsignedFloat('carbohydrates')->default(0);
            $table->unsignedFloat('protein')->default(0);
            $table->enum('meal', ['breakfast', 'lunch', 'dinner', 'snacks']);
            $table->timestamps();
        });
        DB::insert("INSERT INTO `journal_entries` SELECT * FROM `journal_entries_old`;");
        Schema::dropIfExists('journal_entries_old');
        Schema::table('journal_entries', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('date');
        });

        // Journalables.
        Schema::rename('journalables', 'journalables_old');
        Schema::create('journalables', function (Blueprint $table) {
            $table->foreignIdFor(JournalEntry::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedInteger('journalable_id');
            $table->string('journalable_type');
        });
        DB::delete("DELETE FROM `journalables_old` WHERE `journal_entry_id` NOT IN (SELECT `id` FROM `journal_entries`);");
        DB::insert("INSERT INTO `journalables` SELECT * FROM `journalables_old`;");
        Schema::dropIfExists('journalables_old');
        Schema::table('journalables', function (Blueprint $table) {
            $table->index('journal_entry_id');
        });

        // Ingredient amounts (index only).
        Schema::table('ingredient_amounts', function (Blueprint $table) {
            $table->index('parent_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
