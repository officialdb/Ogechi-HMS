<?php

use Illuminate\Support\Facades\Route;
use Modules\Doctors\Http\Controllers\DoctorsController;
use Modules\Doctors\Http\Controllers\DoctorInviteController;

Route::middleware(['web'])->group(function () {
    Route::get('/doctor/invite/{token}', [DoctorInviteController::class, 'show'])->name('doctor.invite.show');
    Route::post('/doctor/invite/{token}', [DoctorInviteController::class, 'store'])->name('doctor.invite.store');
});

Route::middleware(['auth'])->prefix('dashboard/doctors')->name('modules.doctors.')->group(function () {
    Route::get('/', [DoctorsController::class, 'index'])->name('index');
    Route::get('/create', [DoctorsController::class, 'create'])->name('create');
    Route::post('/', [DoctorsController::class, 'store'])->name('store');
    Route::get('/{doctor}', [DoctorsController::class, 'show'])->name('show');
    Route::get('/{doctor}/edit', [DoctorsController::class, 'edit'])->name('edit');
    Route::match(['put', 'patch'], '/{doctor}', [DoctorsController::class, 'update'])->name('update');
    Route::delete('/{doctor}', [DoctorsController::class, 'destroy'])->name('destroy');
});
