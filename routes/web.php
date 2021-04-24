<?php

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

require __DIR__.'/guest.php';
require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
