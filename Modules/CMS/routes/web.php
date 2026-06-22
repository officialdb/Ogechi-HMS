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
    
    // Approval Workflow Routes
    Route::post('/{post}/submit', [CMSController::class, 'submitForReview'])->name('submit')->middleware('permission:cms.submit');
    Route::post('/{post}/approve', [CMSController::class, 'approve'])->name('approve')->middleware('permission:cms.approve');
    Route::post('/{post}/reject', [CMSController::class, 'reject'])->name('reject')->middleware('permission:cms.approve');
    Route::post('/{post}/resend-notification', [CMSController::class, 'resendNotification'])->name('resend-notification');
});
