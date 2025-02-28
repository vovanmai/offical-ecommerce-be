<?php
use Illuminate\Support\Facades\Route;

Route::namespace("Admin")->middleware('guard:admin')->prefix('admin')->group(function () {
    Route::post('login', 'AuthController@login')->name('admin.login');
    Route::get('login', 'AuthController@loginView')->name('admin.login_view');
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('logout', 'AuthController@logout')->name('admin.logout');
        // Route::get('logs', 'LogController@index')->name('admin.log.index');

        // Routes of common
        // require __DIR__ . '/common.php';

        // Routes of admin
        // require __DIR__ . '/admin.php';

        // Routes of category
        require __DIR__ . '/category.php';

        // Routes of error
        require __DIR__ . '/error.php';

        // Routes of website setting
        // require __DIR__ . '/website_setting.php';

        // Routes of post
        // require __DIR__ . '/page.php';
    });
});
