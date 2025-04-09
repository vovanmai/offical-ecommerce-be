<?php

use App\Http\Controllers\Api\Admin\PostCategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('post-categories')->group(function () {
    Route::get('', [PostCategoryController::class, 'index']);
    Route::post('', [PostCategoryController::class, 'store']);
    Route::post('update-order', [PostCategoryController::class, 'updateOrder']);
    Route::get('{id}', [PostCategoryController::class, 'show']);
    Route::put('{id}', [PostCategoryController::class, 'update']);
});
