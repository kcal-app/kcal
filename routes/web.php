<?php

use App\Http\Controllers\FoodController;
use App\Http\Controllers\IngredientPickerController;
use App\Http\Controllers\JournalEntryController;
use App\Http\Controllers\RecipeController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Foods.
Route::resource('foods', FoodController::class)->middleware(['auth']);
Route::get('/foods/{food}/delete', [FoodController::class, 'delete'])->middleware(['auth'])->name('foods.delete');

// Recipes.
Route::resource('recipes', RecipeController::class)->middleware(['auth']);

// Journal entries.
Route::get('/journal-entries/create-from-nutrients', [JournalEntryController::class, 'createFromNutrients'])->middleware(['auth'])->name('journal-entries.create.from-nutrients');
Route::post('/journal-entries/create-from-nutrients', [JournalEntryController::class, 'storeFromNutrients'])->middleware(['auth'])->name('journal-entries.store.from-nutrients');
Route::resource('journal-entries', JournalEntryController::class)->middleware(['auth']);
Route::get('/journal-entries/{journalEntry}/delete', [JournalEntryController::class, 'delete'])->middleware(['auth'])->name('journal-entries.delete');

// Custom.
// TODO: Change this to a custom JSON API endpoint.
Route::get('/ingredient-picker/search', [IngredientPickerController::class, 'search'])->middleware(['auth'])->name('ingredient-picker.search');

require __DIR__.'/auth.php';
