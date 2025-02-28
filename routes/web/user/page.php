<?php
use Illuminate\Support\Facades\Route;

Route::get('{slug}.html', 'PageController@show')->name('user.page.detail');
