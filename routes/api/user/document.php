<?php
use Illuminate\Support\Facades\Route;


Route::prefix('document')->group(function () {
    Route::get('{slug}.html', 'DocumentController@show')->name('user.document.detail');
    Route::get('{id}/download', 'DocumentController@download')->name('user.document.download');
    Route::get('{id}/payment', 'DocumentController@payment')->name('user.document.payment');
});
