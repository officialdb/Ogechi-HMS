<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('modules/settings')->name('modules.settings.')->group(function () {
    Route::view('/', 'settings::index')->name('index');
});
