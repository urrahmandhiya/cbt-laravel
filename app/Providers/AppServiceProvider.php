<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Post;
use App\Models\User;
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
        Gate::define('allow-akses-data', function (User $user) {
            return in_array($user->role_id,[1,2]);
        });
        Gate::define('allow-akses-data', function (User $user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('allow-akses-config-exam', function (User $user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('allow-delete-data', function (User $user) {
            return $user->role_id == 1;
        });
        Gate::define('allow-edit-data', function (User $user) {
            return $user->role_id == 1;
        });
    }
}
