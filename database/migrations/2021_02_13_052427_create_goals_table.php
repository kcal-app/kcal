<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name');
            $table->unsignedTinyInteger('days')->nullable();
            $table->float('calories')->unsigned()->nullable();
            $table->float('fat')->unsigned()->nullable();
            $table->float('cholesterol')->unsigned()->nullable();
            $table->float('sodium')->unsigned()->nullable();
            $table->float('carbohydrates')->unsigned()->nullable();
            $table->float('protein')->unsigned()->nullable();
            $table->timestamps();
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goals');
    }
}
