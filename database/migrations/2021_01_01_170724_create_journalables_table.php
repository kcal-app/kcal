<?php

use App\Models\JournalEntry;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journalables', function (Blueprint $table) {
            $table->foreignIdFor(JournalEntry::class)->index()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedInteger('journalable_id');
            $table->string('journalable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journalables');
    }
}
