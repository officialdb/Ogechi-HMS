<?php

use Illuminate\Support\Facades\Route;
use Modules\Pharmacy\Http\Controllers\PharmacyController;

Route::middleware(['auth'])->prefix('dashboard/pharmacy')->name('modules.pharmacy.')->group(function () {
    Route::get('/', [PharmacyController::class, 'index'])->name('index');
    Route::get('/create', [PharmacyController::class, 'create'])->name('create');
    Route::post('/', [PharmacyController::class, 'store'])->name('store');
    Route::get('/{medication}/edit', [PharmacyController::class, 'edit'])->name('edit');
    Route::match(['put', 'patch'], '/{medication}', [PharmacyController::class, 'update'])->name('update');
    Route::delete('/{medication}', [PharmacyController::class, 'destroy'])->name('destroy');
});
