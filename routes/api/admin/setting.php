<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\SettingController;

Route::prefix('settings')->group(function () {
    Route::get('', [SettingController::class, 'index']);
    Route::post('', [SettingController::class, 'store']);
});
