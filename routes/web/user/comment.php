<?php
use Illuminate\Support\Facades\Route;


Route::prefix('comments')->group(function () {
    Route::get('', 'CommentController@index')->name('user.comment.index');
    Route::post('', 'CommentController@store')->name('user.comment.store');
});
