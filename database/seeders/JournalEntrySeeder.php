<?php

namespace Database\Seeders;

use App\Models\Food;
use App\Models\JournalEntry;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class JournalEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var \App\Models\Food[] $foods */
        foreach (['peanut butter', 'milk', 'egg', 'raisins'] as $name) {
            $foods[$name] = Food::where('name', $name)->first();
        }

        /** @var \App\Models\Recipe $recipe */
        $recipe = Recipe::all()->first();

        /** @var \App\Models\User $user */
        $user = User::all()->first;

        $default_entries = [
            [
                'user_id' => $user->id,
                'date' => Carbon::now()->toDateString(),
                'summary' => '2 egg, 1 serving milk',
                'calories' => $foods['egg']->calories * 2 + $foods['milk']->calories,
                'fat' => $foods['egg']->fat * 2 + $foods['milk']->fat,
                'cholesterol' => $foods['egg']->cholesterol * 2 + $foods['milk']->cholesterol,
                'sodium' => $foods['egg']->sodium * 2 + $foods['milk']->sodium,
                'carbohydrates' => $foods['egg']->carbohydrates * 2 + $foods['milk']->carbohydrates,
                'protein' => $foods['egg']->protein * 2 + $foods['milk']->protein,
                'meal' => 'breakfast',
            ],
            [
                'user_id' => $user->id,
                'date' => Carbon::now()->toDateString(),
                'summary' => '1 serving pancakes',
                'calories' => $recipe->caloriesPerServing(),
                'fat' => $recipe->fatPerServing(),
                'cholesterol' => $recipe->cholesterolPerServing(),
                'sodium' => $recipe->sodiumPerServing(),
                'carbohydrates' => $recipe->carbohydratesPerServing(),
                'protein' => $recipe->proteinPerServing(),
                'meal' => 'lunch',
            ],
            [
                'user_id' => $user->id,
                'date' => Carbon::now()->toDateString(),
                'summary' => '1 serving pancakes',
                'calories' => $recipe->caloriesPerServing(),
                'fat' => $recipe->fatPerServing(),
                'cholesterol' => $recipe->cholesterolPerServing(),
                'sodium' => $recipe->sodiumPerServing(),
                'carbohydrates' => $recipe->carbohydratesPerServing(),
                'protein' => $recipe->proteinPerServing(),
                'meal' => 'dinner',
            ],
            [
                'user_id' => $user->id,
                'date' => Carbon::now()->toDateString(),
                'summary' => '1 serving peanut butter',
                'calories' => $foods['peanut butter']->calories,
                'fat' => $foods['peanut butter']->fat,
                'cholesterol' => $foods['peanut butter']->cholesterol,
                'sodium' => $foods['peanut butter']->sodium,
                'carbohydrates' => $foods['peanut butter']->carbohydrates,
                'protein' => $foods['peanut butter']->protein,
                'meal' => 'snacks',
            ],
            [
                'user_id' => $user->id,
                'date' => Carbon::now()->toDateString(),
                'summary' => '2 servings raisins',
                'calories' => $foods['raisins']->calories * 2,
                'fat' => $foods['raisins']->fat * 2,
                'cholesterol' => $foods['raisins']->cholesterol * 2,
                'sodium' => $foods['raisins']->sodium * 2,
                'carbohydrates' => $foods['raisins']->carbohydrates * 2,
                'protein' => $foods['raisins']->protein * 2,
                'meal' => 'snacks',
            ],
        ];
        JournalEntry::factory()->createMany($default_entries);

        DB::table('journalables')->insert([
            'journal_entry_id' => 1,
            'journalable_id' => $foods['egg']->id,
            'journalable_type' => Food::class,
        ]);
        DB::table('journalables')->insert([
            'journal_entry_id' => 1,
            'journalable_id' => $foods['milk']->id,
            'journalable_type' => Food::class,
        ]);
        DB::table('journalables')->insert([
            'journal_entry_id' => 2,
            'journalable_id' => $recipe->id,
            'journalable_type' => Recipe::class,
        ]);
        DB::table('journalables')->insert([
            'journal_entry_id' => 3,
            'journalable_id' => $recipe->id,
            'journalable_type' => Recipe::class,
        ]);
        DB::table('journalables')->insert([
            'journal_entry_id' => 4,
            'journalable_id' => $foods['peanut butter']->id,
            'journalable_type' => Food::class,
        ]);
        DB::table('journalables')->insert([
            'journal_entry_id' => 5,
            'journalable_id' => $foods['raisins']->id,
            'journalable_type' => Food::class,
        ]);
    }
}
