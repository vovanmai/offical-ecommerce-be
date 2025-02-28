<?php
use Illuminate\Support\Facades\Route;

Route::get('{slug}', 'PostController@index')->name('user.post.index');
