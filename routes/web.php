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
        Route::get('/posts/{id}/social-card', [App\Http\Controllers\Admin\AdminPostController::class, 'socialCard'])->name('posts.social-card');
        Route::get('/social-card', [App\Http\Controllers\Admin\AdminPostController::class, 'socialCardIndex'])->name('social-card');
        
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
        Route::get('/epaper/wp-posts', [App\Http\Controllers\Admin\AdminEPaperController::class, 'proxyWPPosts'])->name('epaper.wp_posts');
        Route::get('/epaper/proxy-image', [App\Http\Controllers\Admin\AdminEPaperController::class, 'proxyImage'])->name('epaper.proxy_image');
        
        // Secure Live Deployment Helper Routes
        Route::get('/epaper/migrate', function () {
            try {
                \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
                return response()->json([
                    'success' => true,
                    'message' => 'Database migrated successfully.',
                    'output' => \Illuminate\Support\Facades\Artisan::output()
                ]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        })->name('epaper.migrate');

        Route::get('/epaper/clear-cache', function () {
            try {
                \Illuminate\Support\Facades\Artisan::call('view:clear');
                \Illuminate\Support\Facades\Artisan::call('cache:clear');
                \Illuminate\Support\Facades\Artisan::call('config:clear');
                return response()->json([
                    'success' => true,
                    'message' => 'Cache, view, and config cleared successfully.'
                ]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        })->name('epaper.clear_cache');
    });
});

