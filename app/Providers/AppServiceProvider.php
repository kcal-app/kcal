<?php

namespace App\Providers;

use App\Search\Ingredient;
use CloudCreativity\LaravelJsonApi\LaravelJsonApi;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        LaravelJsonApi::defaultApi('v1');

        if (config('scout.driver') === 'algolia') {
            Ingredient::bootSearchable();
        }
    }
}
