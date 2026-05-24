<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('modules/notifications')->name('modules.notifications.')->group(function () {
    Route::view('/', 'notifications::index')->name('index');
});
