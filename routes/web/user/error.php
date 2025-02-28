<?php
use Illuminate\Support\Facades\Route;

Route::get('page-not-found.html', function () {
    return view('user.error.not_found');
})->name('user.error.not_found');

Route::get('error.html', function () {
    return view('user.error.error');
})->name('user.error.error');

Route::get('permission.html', function () {
    return view('user.error.permission');
})->name('user.error.forbidden');
