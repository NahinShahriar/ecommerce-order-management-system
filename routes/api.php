<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;

Route::get('/products', [ProductController::class,'index']);
Route::middleware('auth:sanctum')->group(function () {
    //Route::get('/cart/count', [CartController::class, 'cartCount']);
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::post('/cart/remove', [CartController::class, 'remove']);
    Route::post('/cart/update', [CartController::class, 'update']);
    Route::post('/cart/checkout', [CartController::class, 'checkout']);
    
});

