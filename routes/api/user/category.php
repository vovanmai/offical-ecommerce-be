<?php

use App\Http\Controllers\Api\User\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('categories')->group(function () {
    Route::get('', [CategoryController::class, 'index']);
});
