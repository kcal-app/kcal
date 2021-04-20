<?php

use App\Http\Controllers\FoodController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\IngredientPickerController;
use App\Http\Controllers\JournalEntryController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authorized User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    // Foods.
    Route::resource('foods', FoodController::class);
    Route::get('/foods/{food}/delete', [FoodController::class, 'delete'])->name('foods.delete');

    // Goals.
    Route::resource('goals', GoalController::class);
    Route::get('/goals/{goal}/delete', [GoalController::class, 'delete'])->name('goals.delete');

    // Ingredient picker.
    Route::get('/ingredient-picker/search', [IngredientPickerController::class, 'search'])->name('ingredient-picker.search');

    // Journal entries.
    Route::get('/journal-entries/create/from-nutrients', [JournalEntryController::class, 'createFromNutrients'])->name('journal-entries.create.from-nutrients');
    Route::post('/journal-entries/create/from-nutrients', [JournalEntryController::class, 'storeFromNutrients'])->name('journal-entries.store.from-nutrients');
    Route::resource('journal-entries', JournalEntryController::class);
    Route::get('/journal-entries/{journal_entry}/delete', [JournalEntryController::class, 'delete'])->name('journal-entries.delete');

    // Recipes.
    Route::resource('recipes', RecipeController::class);
    Route::get('/recipes/{recipe}/delete', [RecipeController::class, 'delete'])->name('recipes.delete');
});
