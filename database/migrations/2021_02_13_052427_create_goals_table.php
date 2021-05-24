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
            $table->unsignedFloat('calories')->nullable();
            $table->unsignedFloat('fat')->nullable();
            $table->unsignedFloat('cholesterol')->nullable();
            $table->unsignedFloat('sodium')->nullable();
            $table->unsignedFloat('carbohydrates')->nullable();
            $table->unsignedFloat('protein')->nullable();
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
