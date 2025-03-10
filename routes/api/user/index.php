<?php
use Illuminate\Support\Facades\Route;


Route::namespace("User")->middleware(['request.log'])->group(function () {
    Route::get('search.html', 'SearchController@search')->name('user.search');

    // Routes of error
    require __DIR__ . '/error.php';

    require __DIR__ . '/page.php';

    Route::get('khoa-hoc-ke-toan', 'CourseController@getAll')->name('user.course.list_all');

    require __DIR__ . '/course.php';

    // Route index
    Route::get('', 'IndexController@index')->name('user.index');

    Route::post('support-and-consultation', 'SupportAndConsultationController@store');

    require __DIR__ . '/category.php';

    require __DIR__ . '/post.php';
});
