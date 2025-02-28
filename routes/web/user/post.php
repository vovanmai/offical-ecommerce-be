<?php
use Illuminate\Support\Facades\Route;

Route::get('{category}/{slug}.html', 'PostController@show')->name('user.post.detail');
