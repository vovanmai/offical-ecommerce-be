<?php

use App\Http\Controllers\Api\User\PageController;
use Illuminate\Support\Facades\Route;

Route::prefix('pages')->group(function () {
    Route::get('', [PageController::class, 'index']);
});
