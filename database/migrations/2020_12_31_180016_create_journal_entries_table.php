<?php

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
            $table->index(['user_id', 'date']);
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
