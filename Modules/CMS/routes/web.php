<?php

use Illuminate\Support\Facades\Route;
use Modules\CMS\Http\Controllers\CMSController;

Route::middleware(['auth'])->prefix('dashboard/cms')->name('modules.cms.')->group(function () {
    Route::get('/', [CMSController::class, 'index'])->name('index');
    Route::get('/create', [CMSController::class, 'create'])->name('create');
    Route::post('/', [CMSController::class, 'store'])->name('store');
    Route::get('/{post}/edit', [CMSController::class, 'edit'])->name('edit');
    Route::match(['put', 'patch'], '/{post}', [CMSController::class, 'update'])->name('update');
    Route::delete('/{post}', [CMSController::class, 'destroy'])->name('destroy');
});
