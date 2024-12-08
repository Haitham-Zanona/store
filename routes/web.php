<?php

use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\Front\Auth\TwoFactorAuthenticationController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\currencyConverterController;
use App\Http\Controllers\front\HomeController;
use App\Http\Controllers\Front\OrdersController;
use App\Http\Controllers\Front\PaymentsController;
use App\Http\Controllers\front\ProductController;
use App\Http\Controllers\SocialController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

    Route::get('/get-products', function (Request $request) {
        $category = $request->query('category');
        $products = $category === 'all'
        ? Product::all()
        : Product::where('category', $category)->get();

        return response()->json(['products' => $products]);
    });

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

Route::get('auth/{provider}/redirect', [SocialLoginController::class, 'redirect'])
    ->name('auth.socialite.redirect');
Route::get('auth/{provider}/callback', [SocialLoginController::class, 'callback'])
    ->name('auth.socialite.callback');

Route::get('auth/{provider}/user', [SocialController::class, 'index']);

Route::get('orders/{order}/pay', [PaymentsController::class, 'create'])
    ->name('orders.payments.create');

Route::get('/orders/{order}', [OrdersController::class, 'show'])
    ->name('orders.show');

Route::post('orders/{order}/stripe/payment-intent', [PaymentsController::class, 'createStripePaymentIntent'])
    ->name('stripe.paymentIntent.create');

Route::get('orders/{order}/pay/stripe/callback', [PaymentsController::class, 'confirm'])
    ->name('stripe.return');

// Route::any('stripe/webhook', [StripeWebhooksController::class, 'handle']);

//at Laravel -v  7 or less
// Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index');

// require __DIR__.'/auth.php';

require __DIR__ . '/dashboard.php';