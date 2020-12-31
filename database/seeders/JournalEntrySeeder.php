<?php

namespace Database\Seeders;

use App\Models\Food;
use App\Models\JournalEntry;
use App\Models\Recipe;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class JournalEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var \App\Models\User $user */
        $user = User::all()->first;
        $default_entries = [
            [
                'user_id' => $user->id,
                'food_id' => Food::where('name', 'milk')->first()->id,
                'date' => Carbon::now()->toDateString(),
                'amount' => 2,
                'unit' => 'cup',
                'meal' => 'breakfast',
            ],
            [
                'user_id' => $user->id,
                'food_id' => Food::where('name', 'egg')->first()->id,
                'date' => Carbon::now()->toDateString(),
                'amount' => 3,
                'meal' => 'breakfast',
            ],
            [
                'user_id' => $user->id,
                'recipe_id' => Recipe::all()->first(),
                'date' => Carbon::now()->toDateString(),
                'amount' => 1,
                'unit' => 'serving',
                'meal' => 'lunch',
            ],
            [
                'user_id' => $user->id,
                'recipe_id' => Recipe::all()->first(),
                'date' => Carbon::now()->toDateString(),
                'amount' => 1.5,
                'unit' => 'serving',
                'meal' => 'dinner',
            ],
            [
                'user_id' => $user->id,
                'food_id' => Food::where('name', 'peanut butter')->first()->id,
                'date' => Carbon::now()->toDateString(),
                'amount' => 2,
                'unit' => 'tbsp',
                'meal' => 'snacks',
            ],
        ];
        JournalEntry::factory()->createMany($default_entries);
    }
}
