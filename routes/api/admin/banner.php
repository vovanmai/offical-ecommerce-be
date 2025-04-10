<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\BannerController;

Route::prefix('banners')->group(function () {
    Route::get('', [BannerController::class, 'index']);
    Route::post('', [BannerController::class, 'store']);
    Route::get('{id}', [BannerController::class, 'show']);
    Route::put('{id}', [BannerController::class, 'update']);
    Route::delete('{id}', [BannerController::class, 'destroy']);
});
