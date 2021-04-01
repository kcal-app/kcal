<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| See: https://laravel-json-api.readthedocs.io/en/latest/
|
| TODO: Get auth middleware working...
|
*/

JsonApi::register('v1')->routes(function ($api) {
    $api->resource('foods')->relationships(function ($relations) {
        $relations->hasMany('tags')->readOnly();
    })->readOnly();
    $api->resource('ingredient-amounts')->relationships(function ($relations) {
        $relations->hasOne('ingredient')->readOnly();
        $relations->hasOne('parent')->readOnly();
    })->readOnly();
    $api->resource('journal-entries')->relationships(function ($relations) {
        $relations->hasMany('foods')->readOnly();
        $relations->hasMany('recipes')->readOnly();
        $relations->hasOne('user')->readOnly();
    })->readOnly();
    $api->resource('media')->relationships(function ($relations) {
        $relations->hasOne('owner')->readOnly();
    })->readOnly();
    $api->resource('recipes')->relationships(function ($relations) {
        $relations->hasMany('ingredient-amounts')->readOnly();
        $relations->hasMany('media')->readOnly();
        $relations->hasMany('separators')->readOnly();
        $relations->hasMany('steps')->readOnly();
        $relations->hasMany('tags')->readOnly();
    })->readOnly();
    $api->resource('recipe-separators')->relationships(function ($relations) {
        $relations->hasOne('recipe')->readOnly();
    })->readOnly();
    $api->resource('recipe-steps')->relationships(function ($relations) {
        $relations->hasOne('recipe')->readOnly();
    })->readOnly();
    $api->resource('tags')->readOnly();
//    $api->resource('users')->relationships(function ($relations) {
//        $relations->hasMany('journal-entries')->readOnly();
//    })->readOnly();
});
