<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

// ─── Public Website Routes ────────────────────────────────────────────────────
Route::get('/',          [WebsiteController::class, 'home'])->name('home');
Route::get('/about',     [WebsiteController::class, 'about'])->name('website.about');
Route::get('/services',  [WebsiteController::class, 'services'])->name('website.services');
Route::get('/doctors',   [WebsiteController::class, 'doctors'])->name('website.doctors');
Route::get('/blog',      [WebsiteController::class, 'blog'])->name('website.blog');
Route::get('/blog/{slug}', [WebsiteController::class, 'blogShow'])->name('website.blog.show');
Route::get('/contact',   [WebsiteController::class, 'contact'])->name('website.contact');
Route::post('/book-appointment', [WebsiteController::class, 'bookAppointment'])
    ->middleware('throttle:3,1')
    ->name('website.book');

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Super Admin User Management
    Route::middleware(['role:Super Admin'])->group(function () {
        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
        Route::get('/users/{user}/roles', [\App\Http\Controllers\Admin\UserController::class, 'editRoles'])->name('admin.users.roles');
        Route::put('/users/{user}/roles', [\App\Http\Controllers\Admin\UserController::class, 'updateRoles'])->name('admin.users.roles.update');
    });
});

require __DIR__.'/auth.php';
