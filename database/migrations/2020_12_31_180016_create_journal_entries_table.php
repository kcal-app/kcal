<?php

use App\Models\Food;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Food::class)->nullable();
            $table->foreignIdFor(Recipe::class)->nullable();
            $table->date('date')->useCurrent();
            $table->unsignedFloat('amount');
            $table->enum('unit', ['tsp', 'tbsp', 'cup', 'grams', 'serving'])->nullable();
            $table->enum('meal', ['breakfast', 'lunch', 'dinner', 'snacks']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journal_entries');
    }
}
