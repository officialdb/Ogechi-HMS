<?php

use Illuminate\Support\Facades\Route;
use Modules\Notifications\Http\Controllers\NotificationsController;

Route::middleware(['auth'])->prefix('dashboard/notifications')->name('modules.notifications.')->group(function () {
    Route::get('/', [NotificationsController::class, 'index'])->name('index');
    Route::patch('/{id}/read', [NotificationsController::class, 'markAsRead'])->name('read');
    Route::post('/read-all', [NotificationsController::class, 'markAllAsRead'])->name('readAll');
    Route::delete('/{id}', [NotificationsController::class, 'destroy'])->name('destroy');
    
    // Testing route
    Route::post('/test', [NotificationsController::class, 'sendTest'])->name('test');
});
