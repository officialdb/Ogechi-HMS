<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('modules/billing')->name('modules.billing.')->group(function () {
    Route::view('/', 'billing::index')->name('index');
});
