<?php

use App\Http\Controllers\Api\Admin\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guard:admin')->prefix('admin')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
        require __DIR__ . '/category.php';
    });
});
