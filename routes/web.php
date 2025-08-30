<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;


require __DIR__ . '/auth.php';




Route::middleware(['auth'])->group(function () {
    Route::middleware(['isRegisteredUser'])->group(function () {

        Route::middleware(['cartNotEmpty'])->group(function () {
            Route::get('/payment', [CartController::class, 'index'])->name('payment');
        });
        
        Route::post('/cart/store', [CartController::class, 'store'])->name('cart.store');
        Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.removeOne');
        Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.deleteItem');




        Route::post('/payment/checkout', [OrderController::class, 'store'])->name('orders.checkout');

    });


    Route::middleware(['isAdmin'])->group(function () {

        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::get('/products/create', [ProductController::class, 'create'])->name('product.create');
        Route::put('/products/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::post('/products', [ProductController::class, 'store'])->name('product.store');

    });


    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
});


Route::get('/', [FrontController::class, 'getHome'])->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('product.products');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');

Route::get('/ajaxProduct', [ProductController::class, 'ajaxCheckForProducts']);


Route::get('/faq', [FrontController::class, 'getFaq'])->name('faq');
Route::post('/faq/send', [ContactController::class, 'send'])->name('contact.send');