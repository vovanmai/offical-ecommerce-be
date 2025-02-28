<?php
use Illuminate\Support\Facades\Route;

Route::prefix('admins')->group(function () {
    Route::get('', 'AdminController@index')->name('admin.admins.list');
    Route::delete('{id}', 'AdminController@destroy')->name('admin.admin.destroy');

    Route::get('create', 'AdminController@create')->name('admin.admin.create');
    Route::post('', 'AdminController@store')->name('admin.admins.store');
    Route::post('{id}/active', 'AdminController@changeActive')->name('admin.admin.active');

    Route::get('{id}/edit', 'AdminController@edit')->name('admin.admin.edit');
    Route::post('{id}', 'AdminController@update')->name('admin.admins.update');
});
