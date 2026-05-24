<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('modules/appointments')->name('modules.appointments.')->group(function () {
    Route::view('/', 'appointments::index')->name('index');
});
