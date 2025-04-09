<?php

use App\Http\Controllers\Api\Admin\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guard:admin')->prefix('admin')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware(['auth:sanctum'])->group(function () {
        // Routes of admin
        require __DIR__ . '/common.php';
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
        require __DIR__ . '/category.php';
        require __DIR__ . '/post_category.php';
        require __DIR__ . '/product.php';
        require __DIR__ . '/post.php';
        require __DIR__ . '/page.php';
        require __DIR__ . '/banner.php';
        require __DIR__ . '/setting.php';
    });
});
