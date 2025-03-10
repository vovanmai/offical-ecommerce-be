<?php
use Illuminate\Support\Facades\Route;


Route::prefix('lien-he')->group(function () {
    Route::get('', 'ContactController@index')->name('user.contact');

    Route::post('', 'ContactController@store')->name('user.contact.store');
});

// Routes of error
require __DIR__ . '/error.php';
