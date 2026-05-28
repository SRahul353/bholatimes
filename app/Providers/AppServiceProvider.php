<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Super Admin ONLY (User Accounts CRUD, Design and Core Role Definitions)
        Gate::define('super-admin-only', function ($user) {
            return $user->role === 'super_admin';
        });

        // 2. Admin or Super Admin (Categories, E-papers, Social Cards)
        Gate::define('admin-or-super', function ($user) {
            return in_array($user->role, ['admin', 'super_admin']);
        });

        // 3. All Admin Users (Dashboard, Post CRUD - Editor, Admin, Super Admin)
        Gate::define('all-admin-users', function ($user) {
            return in_array($user->role, ['editor', 'admin', 'super_admin']);
        });
    }
}
