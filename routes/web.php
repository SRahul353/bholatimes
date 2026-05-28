<?php

use App\Http\Controllers\NewspaperController;
use Illuminate\Support\Facades\Route;

Route::get('/', [NewspaperController::class, 'index'])->name('home');
Route::get('/epaper', [NewspaperController::class, 'epaper'])->name('epaper');
Route::get('/post/{slug}', [NewspaperController::class, 'show'])->name('post');
Route::get('/category/{slug}', [NewspaperController::class, 'category'])->name('category');
Route::get('/search', [NewspaperController::class, 'search'])->name('search');

// Admin Panel Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Unprotected Auth Routes
    Route::get('/login', [App\Http\Controllers\Admin\AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Admin\AdminLoginController::class, 'login'])->name('login.submit');

    // Protected Admin Panel Routes
    Route::middleware(['auth'])->group(function () {
        Route::post('/logout', [App\Http\Controllers\Admin\AdminLoginController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Post CRUD Resource
        Route::resource('posts', App\Http\Controllers\Admin\AdminPostController::class)->except(['show']);
        
        // Category CRUD Resource
        Route::resource('categories', App\Http\Controllers\Admin\AdminCategoryController::class)->only(['index', 'store', 'destroy']);

        // User CRUD Resource (Super Admin only)
        Route::resource('users', App\Http\Controllers\Admin\AdminUserController::class)->except(['show', 'create', 'edit']);

        // Theme Settings (Super Admin only)
        Route::get('/theme/settings', [App\Http\Controllers\Admin\AdminThemeSettingsController::class, 'index'])->name('theme.settings');
        Route::post('/theme/settings', [App\Http\Controllers\Admin\AdminThemeSettingsController::class, 'update'])->name('theme.settings.update');

        // E-Paper Layout Builder Routes
        Route::get('/epaper', [App\Http\Controllers\Admin\AdminEPaperController::class, 'index'])->name('epaper.index');
        Route::get('/epaper/load', [App\Http\Controllers\Admin\AdminEPaperController::class, 'loadDateData'])->name('epaper.load');
        Route::post('/epaper/save', [App\Http\Controllers\Admin\AdminEPaperController::class, 'store'])->name('epaper.save');
    });
});

