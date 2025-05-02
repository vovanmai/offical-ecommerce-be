<?php

use App\Http\Controllers\Api\User\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware(['guard:user', 'auth:sanctum'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
    require __DIR__ . '/cart.php';
});

require __DIR__ . '/product.php';

require __DIR__ . '/page.php';

require __DIR__ . '/category.php';

require __DIR__ . '/banner.php';



