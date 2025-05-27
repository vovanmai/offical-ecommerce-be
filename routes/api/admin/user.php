<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\UserController;

Route::prefix('users')->group(function () {
    Route::get('', [UserController::class, 'index']);
    Route::get('{id}', [UserController::class, 'show']);
});
