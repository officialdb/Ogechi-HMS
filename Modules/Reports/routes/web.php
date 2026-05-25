<?php

use Illuminate\Support\Facades\Route;
use Modules\Reports\Http\Controllers\ReportsController;

Route::middleware(['auth'])->prefix('dashboard/reports')->name('modules.reports.')->group(function () {
    Route::get('/', [ReportsController::class, 'index'])->name('index');
});
