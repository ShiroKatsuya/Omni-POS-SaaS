<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::get('/checkout/result', [CheckoutController::class, 'result'])->name('checkout.result');
