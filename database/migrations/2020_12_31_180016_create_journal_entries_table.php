<?php

use App\Models\JournalEntry;
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
            $table->foreignIdFor(User::class)->index()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('date')->index()->useCurrent();
            $table->string('summary');
            $table->float('calories')->unsigned()->default(0);
            $table->float('fat')->unsigned()->default(0);
            $table->float('cholesterol')->unsigned()->default(0);
            $table->float('sodium')->unsigned()->default(0);
            $table->float('carbohydrates')->unsigned()->default(0);
            $table->float('protein')->unsigned()->default(0);
            $table->unsignedInteger('meal');
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
