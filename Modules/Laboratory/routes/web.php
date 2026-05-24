<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('modules/laboratory')->name('modules.laboratory.')->group(function () {
    Route::view('/', 'laboratory::index')->name('index');
});
