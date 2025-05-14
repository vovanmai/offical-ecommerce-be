<?php

use App\Http\Controllers\Api\User\CategoryController;
use App\Http\Controllers\Api\User\PostController;
use App\Http\Controllers\Api\User\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('categories')->group(function () {
    Route::get('', [CategoryController::class, 'index']);
    Route::get('{slug}/posts', [PostController::class, 'getByCategory']);
    Route::get('{slug}/products', [ProductController::class, 'getByCategory']);
});
