<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard\CategoriesController;

Route::group([
    'middleware' => ['auth', 'verified'],
    'as' => 'dashboard.',
    'prefix' => 'dashboard'
], function(){
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('/categories', CategoriesController::class);
});


/* Route::middleware('auth')->as('dashboard.')->prefix('dashboard')->group(function(){
    // categories routes here...
}); */





