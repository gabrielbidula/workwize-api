<?php

use App\Http\Controllers\Api\Auth\CustomerSignupController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\SupplierSignupController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CartProductController;
use App\Http\Controllers\Api\ProductController;
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

// Public routes
Route::name('api.')->group(function () {
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('suppliers/signup', [SupplierSignupController::class, 'signup'])->name('suppliers.signup');
        Route::post('customers/signup', [CustomerSignupController::class, 'signup'])->name('customers.signup');
        Route::post('login', [LoginController::class, 'login'])->name('login');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('products', ProductController::class);
        Route::apiResource('carts', CartController::class)->except(['index', 'update']);
        Route::put('carts/{cart}/clear-cart', [CartController::class, 'clearCart'])->name('carts.clear-cart');
        Route::post('carts/{cart}/add-product', [CartProductController::class, 'addProductToCart'])->name('carts.products.add-product');
        Route::delete('carts/{cart}/remove-product/{product}', [CartProductController::class, 'removeProductFromCart'])->name('carts.products.remove-product');
    });
});
