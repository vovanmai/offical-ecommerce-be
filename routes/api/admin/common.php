<?php

use App\Http\Controllers\Api\Admin\CommonController;
use Illuminate\Support\Facades\Route;

Route::prefix('common')->group(function () {
    Route::post('uploads', [CommonController::class, 'upload']);
});