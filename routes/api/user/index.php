<?php

use App\Http\Controllers\Api\User\AuthController;
use App\Http\Controllers\Api\User\ForgotPasswordController;
use Illuminate\Support\Facades\Route;

Route::get('health', function () {
    return response()->json(['status' => 'ok']);
})->name('user.health');

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::get('verify-email/{token}', [AuthController::class, 'verify']);
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);

Route::middleware(['guard:user', 'auth:sanctum'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
    require __DIR__ . '/cart.php';
    require __DIR__ . '/order.php';
});

require __DIR__ . '/product.php';

require __DIR__ . '/page.php';

require __DIR__ . '/category.php';

require __DIR__ . '/banner.php';

require __DIR__ . '/post.php';
