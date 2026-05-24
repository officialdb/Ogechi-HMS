<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('modules/core')->name('modules.core.')->group(function () {
    Route::view('/', 'core::index')->name('index');
});
