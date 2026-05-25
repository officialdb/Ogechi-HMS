<?php

use Illuminate\Support\Facades\Route;
use Modules\Appointments\Http\Controllers\AppointmentsController;

Route::middleware(['auth'])->prefix('dashboard/appointments')->name('modules.appointments.')->group(function () {
    Route::get('/', [AppointmentsController::class, 'index'])->name('index');
    Route::get('/create', [AppointmentsController::class, 'create'])->name('create');
    Route::post('/', [AppointmentsController::class, 'store'])->name('store');
    Route::get('/{appointment}', [AppointmentsController::class, 'show'])->name('show');
    Route::get('/{appointment}/edit', [AppointmentsController::class, 'edit'])->name('edit');
    Route::match(['put', 'patch'], '/{appointment}', [AppointmentsController::class, 'update'])->name('update');
    Route::delete('/{appointment}', [AppointmentsController::class, 'destroy'])->name('destroy');
});
