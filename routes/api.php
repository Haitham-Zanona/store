<?php

use App\Http\Controllers\Api\AccessTokensController;
use App\Http\Controllers\Api\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    // return $request->user();
    // return Auth::user();
    return Auth::guard('sanctum')->user();
});

Route::apiResource('products', ProductsController::class);

Route::post('auth/access-tokens', [AccessTokensController::class, 'store'])
    ->middleware('guest:sanctum');
Route::delete('auth/access-tokens/{token?}', [AccessTokensController::class, 'destroy'])
    ->middleware('auth:sanctum');
