<?php

use Illuminate\Support\Facades\Route;
use Modules\Laboratory\Http\Controllers\LaboratoryController;

Route::middleware(['auth'])->prefix('dashboard/laboratory')->name('modules.laboratory.')->group(function () {
    Route::get('/',              [LaboratoryController::class, 'index'])->name('index');
    Route::get('/create',        [LaboratoryController::class, 'create'])->name('create');
    Route::post('/',             [LaboratoryController::class, 'store'])->name('store');
    Route::get('/{laboratory}/edit',   [LaboratoryController::class, 'edit'])->name('edit');
    Route::match(['put','patch'], '/{laboratory}', [LaboratoryController::class, 'update'])->name('update');
    Route::delete('/{laboratory}',     [LaboratoryController::class, 'destroy'])->name('destroy');
});
