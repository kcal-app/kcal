<?php

use App\Http\Controllers\FoodController;
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

Route::resource('foods', FoodController::class)->middleware(['auth']);
Route::get('/foods/{food}/delete', [FoodController::class, 'delete'])
    ->middleware(['auth'])
    ->name('foods.delete');
Route::resource('recipes', RecipeController::class)->middleware(['auth']);
Route::resource('journal-entries', JournalEntryController::class)->middleware(['auth']);
Route::get('/journal-entries/{journalEntry}/delete', [JournalEntryController::class, 'delete'])
    ->middleware(['auth'])
    ->name('journal-entries.delete');

require __DIR__.'/auth.php';
