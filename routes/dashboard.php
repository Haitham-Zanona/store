<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\CategoriesController;

Route::group([
    'middleware' => ['auth', 'verified'],
    // 'as' => 'dashboard.',
    'prefix' => 'dashboard'
], function () {

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    /* Route::get('/categories/{category}', [CategoriesController::class, 'show'])
        ->name('categories.show')
        ->where('category', '\d+'); */

    Route::get('/categories/trash', [CategoriesController::class, 'trash'])
        ->name('categories.trash');

    Route::put('/categories/{category}/restore', [CategoriesController::class, 'restore'])
        ->name('categories.restore');

    Route::delete('/categories/{category}/force-delete', [CategoriesController::class, 'forceDelete'])
        ->name('categories.force-delete');

    Route::resource('/categories', CategoriesController::class);

    Route::resource('/products', ProductsController::class);
});


/* Route::middleware('auth')->as('dashboard.')->prefix('dashboard')->group(function(){
    // categories routes here...
}); */
