<?php
use Illuminate\Support\Facades\Route;

Route::get('not-found', function () {
    return view('admin.error.not_found');
})->name('admin.error.not_found');

Route::get('error', function () {
    return view('admin.error.error');
})->name('admin.error.error');

Route::get('permission', function () {
    return view('admin.error.permission');
})->name('admin.error.forbidden');
