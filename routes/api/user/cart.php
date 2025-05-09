<?php

use App\Http\Controllers\Api\User\CartController;
use Illuminate\Support\Facades\Route;

Route::prefix('carts')->group(function () {
    Route::get('', [CartController::class, 'index']);
    Route::post('', [CartController::class, 'store']);
    Route::put('{id}', [CartController::class, 'update']);
    Route::delete('{id}', [CartController::class, 'destroy']);
    Route::delete('', [CartController::class, 'clear']);
});
