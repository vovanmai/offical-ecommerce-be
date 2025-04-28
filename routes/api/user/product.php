<?php

use App\Http\Controllers\Api\User\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function () {
    Route::get('', [ProductController::class, 'index']);
    Route::get('{slug}', [ProductController::class, 'show']);
});
