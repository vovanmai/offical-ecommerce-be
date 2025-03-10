<?php
use Illuminate\Support\Facades\Route;


Route::prefix('khoa-hoc-ke-toan/{category}')->group(function () {
    Route::get('', 'CourseController@index')->name('user.course.index');
    Route::get('{slug}.html', 'CourseController@show')->name('user.course.detail');
});
