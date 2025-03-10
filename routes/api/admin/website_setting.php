<?php
use Illuminate\Support\Facades\Route;

Route::prefix('website-setting')->group(function () {
    Route::get('update', 'WebsiteSettingController@create')->name('admin.website_setting.edit');
    Route::post('', 'WebsiteSettingController@store')->name('admin.website_setting.update');
});
