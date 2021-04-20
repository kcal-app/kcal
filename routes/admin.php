<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'can:administer'])->group(function () {
    Route::resource('users', UserController::class);
    Route::get('/users/{user}/delete', [UserController::class, 'delete'])->name('users.delete');
});
