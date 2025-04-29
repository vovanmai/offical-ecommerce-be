<?php

use App\Http\Controllers\Api\User\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

require __DIR__ . '/product.php';

require __DIR__ . '/page.php';

require __DIR__ . '/category.php';

