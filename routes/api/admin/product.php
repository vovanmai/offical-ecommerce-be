<?php
use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function () {
    Route::get('', 'ProductController@index')->name('admin.product.list');

    Route::get('create', 'ProductController@create')->name('admin.product.create');
    Route::post('', 'ProductController@store')->name('admin.product.store');

    Route::get('{id}/edit', 'ProductController@edit')->name('admin.product.edit');
    Route::put('{id}', 'ProductController@update')->name('admin.product.update');

    Route::delete('{id}', 'ProductController@destroy')->name('admin.product.destroy');
});
