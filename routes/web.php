<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;


require __DIR__ . '/auth.php';

Route::get('/', [FrontController::class, 'getHome'])->name('home');

Route::resource('products', ProductController::class);
Route::get('/products', [ProductController::class, 'index'])->name('product.products');
Route::get('/products/{id}/show', [ProductController::class, 'show'])->name('product.show');

Route::get('/ajaxProduct', [ProductController::class, 'ajaxCheckForProducts']);


Route::get('/faq', [FrontController::class, 'getFaq'])->name('faq');
Route::post('/faq/send', [ContactController::class, 'send'])->name('contact.send');



Route::middleware(['auth', 'isRegisteredUser'])->group(function () {


    Route::resource('cart', CartController::class);
    Route::get('/payment', [CartController::class, 'index'])->name('payment');
    Route::post('/cart/store', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/card/{id}', [CartController::class, 'destroy'])->name('card.deleteItem');


    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/{id}/show', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/payment/checkout', [OrderController::class, 'store'])->name('orders.checkout');

});


