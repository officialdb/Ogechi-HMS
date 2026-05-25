<?php

use Illuminate\Support\Facades\Route;
use Modules\Departments\Http\Controllers\DepartmentsController;

Route::middleware(['auth'])->prefix('dashboard/departments')->name('modules.departments.')->group(function () {
    Route::get('/',              [DepartmentsController::class, 'index'])->name('index');
    Route::get('/create',        [DepartmentsController::class, 'create'])->name('create');
    Route::post('/',             [DepartmentsController::class, 'store'])->name('store');
    Route::get('/{dept}/edit',   [DepartmentsController::class, 'edit'])->name('edit');
    Route::match(['put','patch'],'/{dept}', [DepartmentsController::class, 'update'])->name('update');
    Route::delete('/{dept}',     [DepartmentsController::class, 'destroy'])->name('destroy');
});
