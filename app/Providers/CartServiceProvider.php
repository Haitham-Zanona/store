<?php

namespace App\Providers;

use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(CartRepository::class, function(){
            return new CartModelRepository();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        //
    }
}
