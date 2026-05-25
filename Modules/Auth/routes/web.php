<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('dashboard/auth')->name('modules.auth.')->group(function () {
    Route::view('/', 'auth::index')->name('index');
});
