<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('modules/reports')->name('modules.reports.')->group(function () {
    Route::view('/', 'reports::index')->name('index');
});
