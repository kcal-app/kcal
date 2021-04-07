<?php

namespace Database\Seeders;

use App\Models\Food;
use App\Models\Goal;
use App\Models\JournalEntry;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'username' => 'kcal',
            'password' => Hash::make('kcal'),
            'name' => 'Admin',
            'remember_token' => Str::random(10),
        ]);
        // @todo Make this more fine tuned for different macros.
        Goal::factory()->for($user)->count(5)->create();
        Food::factory()->count(100)->create();
        // @todo Create with media.
        Recipe::factory()
            ->hasIngredientAmounts(rand(2, 20))
            ->hasSteps(rand(5, 20))
            ->hasIngredientSeparators(rand(0, 5))
            ->count(50)
            ->create();
        JournalEntry::factory()->for($user)->count(100)->create();
    }
}
