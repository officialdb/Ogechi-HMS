<?php

use Illuminate\Support\Facades\Route;
use Modules\Patients\Http\Controllers\PatientVitalsController;
use Modules\Patients\Http\Controllers\PatientVisitsController;
use Modules\Patients\Http\Controllers\PatientsController;

Route::prefix('dashboard/patients')->name('patients.')->group(function () {
    Route::get('/', [PatientsController::class, 'index'])
        ->middleware(['auth', 'permission:patients.view'])
        ->name('index');
    Route::get('/create', [PatientsController::class, 'create'])
        ->middleware(['auth', 'permission:patients.create'])
        ->name('create');
    Route::post('/', [PatientsController::class, 'store'])
        ->middleware(['auth', 'permission:patients.create'])
        ->name('store');
    Route::get('/{patient}', [PatientsController::class, 'show'])
        ->middleware(['auth', 'permission:patients.view'])
        ->name('show');
    Route::get('/{patient}/edit', [PatientsController::class, 'edit'])
        ->middleware(['auth', 'permission:patients.update'])
        ->name('edit');
    Route::match(['put', 'patch'], '/{patient}', [PatientsController::class, 'update'])
        ->middleware(['auth', 'permission:patients.update'])
        ->name('update');
    Route::post('/{patient}/vitals', [PatientVitalsController::class, 'store'])
        ->middleware(['auth', 'permission:patients.update'])
        ->name('vitals.store');
    Route::post('/{patient}/visits', [PatientVisitsController::class, 'store'])
        ->middleware(['auth', 'permission:patients.update'])
        ->name('visits.store');
    Route::delete('/{patient}', [PatientsController::class, 'destroy'])
        ->middleware(['auth', 'permission:patients.delete'])
        ->name('destroy');
});
