<?php
use App\Http\Controllers\Frontend\FoodController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\OrderController;


use App\Http\Controllers\Backend\OrderController as BackendOrderController;
use App\Http\Controllers\Backend\FoodController as BackendFoodController;
use App\Http\Controllers\Backend\VariantController as BackendVariantController;
use App\Http\Controllers\Backend\UserController as BackendUserController;
use App\Http\Controllers\Backend\DashboardController;

use App\Http\Controllers\Driver\DriverOrderController;



Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Foods Routes
    Route::resource('foods', BackendFoodController::class);

    // Variants Routes
    Route::resource('variants', BackendVariantController::class);

    // Variant Values Routes

    // Orders Routes
    Route::resource('orders', BackendOrderController::class);

    Route::get('/orders/{id}', [BackendOrderController::class, 'show'])->name('orders.show');

    // web.php
Route::put('/orders/{id}/status', [BackendOrderController::class, 'updateStatus'])->name('orders.updateStatus');


    
    // Users Routes
    Route::resource('users', BackendUserController::class);


    // Additional route for assigning drivers
    Route::post('orders/{order}/assign-driver', [BackendOrderController::class, 'assignDriver'])->name('orders.assignDriver');
});



// Home route
Route::get('/', [FoodController::class, 'index'])->name('home');

// Food routes
Route::get('/foods', [FoodController::class, 'index'])->name('foods.index');
Route::get('/foods/{food}', [FoodController::class, 'show'])->name('foods.show');

// Cart routes
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{item}', [CartController::class, 'destroy'])->name('cart.destroy');
     Route::Delete('/cart/remove/{item}', [CartController::class, 'destroy'])->name('cart.destroy');
     Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');

    Route::post('/order', [OrderController::class, 'store'])->name('orders.store');

    // web.php

Route::get('/order/confirmation/{order}', [OrderController::class, 'confirmation'])->name('order.confirmation');

});




Route::middleware(['auth'])->prefix('driver')->group(function () {
    Route::get('/orders', [DriverOrderController::class, 'index'])->name('driver.orders.index');
    // web.php
Route::get('/orders/{id}', [DriverOrderController::class, 'show'])->name('driver.orders.show');

    Route::put('orders/{order}/status', [DriverOrderController::class, 'updateStatus'])->name('driver.orders.updateStatus');

Route::post('/notifications/mark-as-read', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return response()->json(['success' => true]);
})->name('driver.notifications.markAsRead');



});

// Authentication routes
Auth::routes();



