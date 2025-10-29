<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\Superadmin\AdminOutletController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::middleware(['auth','role:outlet_incharge'])->group(function(){
    Route::get('/outlet/orders', [OutletController::class, 'orders'])->name('outlet.orders');
    Route::post('/outlet/orders/accepting', [OutletController::class, 'acceptOrder']);
    Route::post('/outlet/orders/transfering', [OutletController::class, 'transferOrder']);
    Route::post('/cancel/ordering', [OutletController::class, 'cancelOrder']);
     
});
Route::middleware(['auth','role:super_admin,admin'])->group(function(){
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/outlet/orders/accept', [AdminOutletController::class, 'acceptOrder']);
    Route::post('/outlet/orders/transfer', [AdminOutletController::class, 'transferOrder']);
    Route::post('/cancel/order', [AdminOutletController::class, 'cancelOrder']);

});
Route::middleware(['auth','role:super_admin'])->group(function(){
   Route::get('/users', [UserController::class, 'index'])->name('users.index');
   Route::get('/outlets', [UserController::class, 'outlets'])->name('outlets');
   Route::get('/products', [ProductController::class, 'index'])->name('products.index');
   

});


Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
