<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('modules/doctors')->name('modules.doctors.')->group(function () {
    Route::view('/', 'doctors::index')->name('index');
});
