<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TagController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::get('/products', [ProductController::class, 'index'])->name('api.products.index');

    // Category
    // Route::get('/category', [CategoryController::class, 'index']);
    // Route::post('/category', [CategoryController::class, 'store']);
    // Route::delete('/category/{category}', [CategoryController::class, 'destroy']);
    // Route::get('/category/{category}', [CategoryController::class, 'show']);
    // Route::put('/category/{category}', [CategoryController::class, 'update']);
    Route::apiResource('categories', CategoryController::class);

    // Tag
    Route::get('/tags', [TagController::class, 'getAllTags']);
    Route::get('/tag/{id}', [TagController::class, 'tagDetails']);

    // Product
    Route::post('/add-product', [ProductController::class, 'addProduct']);
    Route::post('/edit-product/{id}', [ProductController::class, 'editProduct']);
});


