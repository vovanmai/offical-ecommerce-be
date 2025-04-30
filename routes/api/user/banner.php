<?php

use App\Http\Controllers\Api\User\BannerController;
use Illuminate\Support\Facades\Route;

Route::prefix('banners')->group(function () {
    Route::get('', [BannerController::class, 'index']);
});
