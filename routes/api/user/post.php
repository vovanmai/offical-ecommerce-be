<?php

use App\Http\Controllers\Api\User\PostController;
use Illuminate\Support\Facades\Route;

Route::prefix('posts')->group(function () {
    Route::get('', [PostController::class, 'index']);
    Route::get('{slug}', [PostController::class, 'show']);
});
