<?php

namespace App\Providers;

use App\Search\Ingredient;
use CloudCreativity\LaravelJsonApi\LaravelJsonApi;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        if (strpos(env('APP_URL', ''), 'https') !== false) {
            URL::forceScheme('https');
        }
        LaravelJsonApi::defaultApi('v1');

        if (config('scout.driver') === 'algolia') {
            Ingredient::bootSearchable();
        }
    }
}
