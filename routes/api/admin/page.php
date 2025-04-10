<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\PageController;

Route::prefix('pages')->group(function () {
    Route::get('', [PageController::class, 'index']);
    Route::post('', [PageController::class, 'store']);
    Route::get('{id}', [PageController::class, 'show']);
    Route::put('{id}', [PageController::class, 'update']);
    Route::delete('{id}', [PageController::class, 'destroy']);
});
