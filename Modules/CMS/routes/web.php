<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('modules/cms')->name('modules.cms.')->group(function () {
    Route::view('/', 'cms::index')->name('index');
});
