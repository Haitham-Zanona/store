<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        JsonResource::withoutWrapping();

        Validator::extend('filter', function($attribute, $value, $params){
            return ! in_array(strtolower($value), $params);
        }, 'The value is prohibited!');

        Paginator::useBootstrapFour();
        // Paginator::defaultView('pagination.custom');

    }
}
