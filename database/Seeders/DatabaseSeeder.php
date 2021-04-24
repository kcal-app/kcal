<?php

namespace Database\Seeders;

use App\Models\Food;
use App\Models\Goal;
use App\Models\IngredientAmount;
use App\Models\JournalEntry;
use App\Models\Recipe;
use App\Models\User;
use App\Support\Nutrients;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->admin()->create([
            'username' => 'kcal',
            'password' => Hash::make('kcal'),
            'name' => 'Admin',
            'remember_token' => Str::random(10),
        ]);

        $goals = [];
        foreach (Nutrients::all() as $nutrient) {
            $goals[] = [
                'frequency' => 'daily',
                'name' => $nutrient['value'],
                'goal' => $nutrient['rdi'],
            ];
        }
        Goal::factory()->for($user)->createMany($goals);

        $foods = Food::factory()->count(100)->create();
        $recipes = Recipe::factory()
            ->hasSteps(rand(5, 20))
            ->count(25)
            ->create();

        /** @var \App\Models\Recipe $recipe */
        foreach ($recipes as $recipe) {
            $ingredients = [];
            for ($i = 0; $i < rand(1, 20); $i++) {
                $ingredients[] = IngredientAmount::factory()
                    ->for($recipe, 'parent')
                    ->for($foods->random(), 'ingredient')
                    ->create([
                        'weight' => $i,
                    ]);
            }
            $recipe->ingredientAmounts()->saveMany($ingredients);
        }

        for ($i = 0; $i <= 31; $i++) {
            JournalEntry::factory()
                ->for($user)
                ->count(rand(5, 12))
                ->create(['date' => Carbon::now()->sub('day', $i)]);
        }


    }
}
