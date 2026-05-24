<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('modules/pharmacy')->name('modules.pharmacy.')->group(function () {
    Route::view('/', 'pharmacy::index')->name('index');
});
