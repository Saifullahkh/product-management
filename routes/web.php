<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;


// GUEST ROUTES 
Route::view('login', 'auth.login')->name('login');
Route::view('signup', 'auth.signup')->name('signup');

// Form submissions
Route::post('add-user', [UserController::class, 'addUser'])->name('users-store');
Route::post('login-save', [UserController::class, 'loginUser'])->name('users-login'); 
Route::get('logout', [UserController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {
    
    Route::get('/', [WelcomeController::class, 'totalProduct'])->name('welcome');
    Route::get('pricing', [PricingController::class, 'index'])->name('pricing');
    Route::get('checkout/{name}', [CheckoutController::class, 'checkout'])->name('checkout');

    Route::get('product', [ProductController::class, 'getProduct'])->name('products');
    Route::get('category', [CategoryController::class, 'getCategory'])->name('categories');

    // Pro Business + Enterprise
    Route::middleware('role:Pro Business User|Enterprise User')->group(function () {
       
        Route::post('add-product', [ProductController::class, 'addProduct'])->name('products-store');
        Route::get('deleteProduct/{id}', [ProductController::class, 'deleteProduct'])->name('products-delete');
        Route::put('edit-product/{id}', [ProductController::class, 'updateProduct'])->name('products-update');

       
        Route::post('add-category', [CategoryController::class, 'addCategory'])->name('categories-store');
        Route::get('delete/{id}', [CategoryController::class, 'deleteCategory'])->name('categories-delete');
        Route::put('edit-category/{id}', [CategoryController::class, 'editCategory'])->name('categories-update');
    });

    // Enterprise only
    Route::middleware('role:Enterprise User')->group(function () {
        Route::get('permission', [PermissionController::class, 'index'])->name('permissions-index');
        Route::post('permission/store', [PermissionController::class, 'store'])->name('permissions-store');
        Route::put('permission/edit/{id}', [PermissionController::class, 'update'])->name('permissions-edit');
        Route::get('permission/delete/{id}', [PermissionController::class, 'destroy'])->name('permissions-delete');

        Route::get('role', [RoleController::class, 'index'])->name('roles-index');
        Route::post('role/store', [RoleController::class, 'store'])->name('roles-store');
        Route::put('role/edit/{id}', [RoleController::class, 'update'])->name('roles-edit');
        Route::get('role/delete/{id}', [RoleController::class, 'destroy'])->name('roles-delete');
        Route::get('role/{id}/permissions', [RoleController::class, 'getPermissions'])->name('roles-permissions');

        Route::get('users', [UserController::class, 'showUser'])->name('users');
        Route::get('users/delete/{id}', [UserController::class, 'deleteUser'])->name('users-delete');
        Route::put('users/edit/{id}', [UserController::class, 'update'])->name('users-edit');
    });

});

// Stripe Webhook
Route::post('stripe/webhook', [\Laravel\Cashier\Http\Controllers\WebhookController::class, 'handleWebhook']);
