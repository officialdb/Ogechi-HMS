<?php

use Illuminate\Support\Facades\Route;
use Modules\Billing\Http\Controllers\BillingController;

Route::middleware(['auth'])->prefix('dashboard/billing')->name('modules.billing.')->group(function () {
    Route::get('/', [BillingController::class, 'index'])->name('index');
    Route::get('/create', [BillingController::class, 'create'])->name('create');
    Route::post('/', [BillingController::class, 'store'])->name('store');
    Route::get('/{invoice}', [BillingController::class, 'show'])->name('show');
    Route::get('/{invoice}/edit', [BillingController::class, 'edit'])->name('edit');
    Route::match(['put', 'patch'], '/{invoice}', [BillingController::class, 'update'])->name('update');
    Route::delete('/{invoice}', [BillingController::class, 'destroy'])->name('destroy');
});
