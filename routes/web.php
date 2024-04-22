<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Front\Auth\TwoFactorAuthenticationController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\front\HomeController;
use App\Http\Controllers\front\ProductController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\currencyConverterController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
], function () {

    Route::get('/', [HomeController::class, 'index'])
        ->name('home');

    Route::get('/product', [ProductController::class, 'index'])
        ->name('product.index');

    Route::get('/products/{product:slug}', [ProductController::class, 'show'])
        ->name('product.show');

    Route::resource('cart', CartController::class);

    Route::get('checkout', [CheckoutController::class, 'create'])->name('checkout');
    Route::post('checkout', [CheckoutController::class, 'store']);

    Route::get('auth/user/2fa', [TwoFactorAuthenticationController::class, 'index'])
        ->name('front.2fa');

    Route::post('currency', [CurrencyConverterController::class, 'store'])
        ->name('currency.store');

    Route::post('checkout/create-payment', [PaymentsController::class, 'store'])
        ->name('checkout.payment');
    Route::get('/test', function () {
        return view('test');
    });
});

//at Laravel -v  7 or less
// Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index');





// require __DIR__.'/auth.php';

require __DIR__ . '/dashboard.php';
