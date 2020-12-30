<?php

use CloudCreativity\LaravelJsonApi\Facades\JsonApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

JsonApi::register('default')->routes(function ($api) {
    $api->resource('food-amounts')->relationships(function ($relations) {
        $relations->hasOne('food');
        $relations->hasOne('recipe');
    });
    $api->resource('foods');
    $api->resource('recipes')->relationships(function ($relations) {
        $relations->hasMany('food-amounts');
        $relations->hasOne('steps');
    });
    $api->resource('recipe-steps')->relationships(function ($relations) {
        $relations->hasOne('recipe');
    });
});
