<?php

namespace App\Providers;

use App\Models\User;
use Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Gate::define('review-hki', function (User $user) {
            return in_array($user->email, ['admin@kampus.ac.id', 'dosen@kampus.ac.id', '220660121093@student.unsap.ac.id']); // <-- Pastikan emailmu ada di sini
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
