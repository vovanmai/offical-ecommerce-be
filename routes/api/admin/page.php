<?php
use Illuminate\Support\Facades\Route;

Route::prefix('pages')->group(function () {
    Route::get('', 'PageController@index')->name('admin.page.list');
    Route::get('create', 'PageController@create')->name('admin.page.create');
    Route::post('', 'PageController@store')->name('admin.page.store');
    Route::get('{id}/edit', 'PageController@edit')->name('admin.page.edit');
    Route::post('{id}', 'PageController@update')->name('admin.page.update');
    Route::post('{id}/active', 'PageController@changeActive')->name('admin.page.active');
    Route::delete('{id}', 'PageController@destroy')->name('admin.page.destroy');
});
