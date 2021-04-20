<?php

use App\Http\Controllers\FoodController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\IngredientPickerController;
use App\Http\Controllers\JournalEntryController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\UserController;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (): RedirectResponse {
    return new RedirectResponse(RouteServiceProvider::HOME);
});

// Foods.
Route::resource('foods', FoodController::class)->middleware(['auth']);
Route::get('/foods/{food}/delete', [FoodController::class, 'delete'])->middleware(['auth'])->name('foods.delete');

// Goals.
Route::resource('goals', GoalController::class)->middleware(['auth']);
Route::get('/goals/{goal}/delete', [GoalController::class, 'delete'])->middleware(['auth'])->name('goals.delete');

// Ingredient picker.
Route::get('/ingredient-picker/search', [IngredientPickerController::class, 'search'])->middleware(['auth'])->name('ingredient-picker.search');

// Journal entries.
Route::get('/journal-entries/create/from-nutrients', [JournalEntryController::class, 'createFromNutrients'])->middleware(['auth'])->name('journal-entries.create.from-nutrients');
Route::post('/journal-entries/create/from-nutrients', [JournalEntryController::class, 'storeFromNutrients'])->middleware(['auth'])->name('journal-entries.store.from-nutrients');
Route::resource('journal-entries', JournalEntryController::class)->middleware(['auth']);
Route::get('/journal-entries/{journal_entry}/delete', [JournalEntryController::class, 'delete'])->middleware(['auth'])->name('journal-entries.delete');

// Recipes.
Route::resource('recipes', RecipeController::class)->middleware(['auth']);
Route::get('/recipes/{recipe}/delete', [RecipeController::class, 'delete'])->middleware(['auth'])->name('recipes.delete');

// Users.
Route::resource('users', UserController::class)->middleware(['auth']);
Route::get('/users/{user}/delete', [UserController::class, 'delete'])->middleware(['auth'])->name('users.delete');

require __DIR__.'/auth.php';
