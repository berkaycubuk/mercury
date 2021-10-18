<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Panel access
        Gate::define('access-panel', function() {
            $user_role = Auth::user()->role;
            return $user_role == 'admin' || $user_role == 'writer';
        });

        // Posts
        Gate::define('create-post', function() {
            $user_role = Auth::user()->role;
            return $user_role == 'admin' || $user_role == 'writer';
        });

        Gate::define('update-post', function() {
            $user_role = Auth::user()->role;
            return $user_role == 'admin' || $user_role == 'writer';
        });

        Gate::define('read-post', function() {
            $user_role = Auth::user()->role;
            return $user_role == 'admin' || $user_role == 'writer';
        });

        Gate::define('delete-post', function() {
            $user_role = Auth::user()->role;
            return $user_role == 'admin' || $user_role == 'writer';
        });

        // Orders
        Gate::define('create-order', function() {
            return Auth::user()->role == 'admin';
        });

        Gate::define('update-order', function() {
            $roles = [
                'admin',
                'order-tracker'
            ];

            return in_array(Auth::user()->role, $roles);
        });

        Gate::define('read-order', function() {
            return Auth::user()->role == 'admin';
        });

        Gate::define('delete-order', function() {
            return Auth::user()->role == 'admin';
        });

        // Products
        Gate::define('create-product', function() {
            return Auth::user()->role == 'admin';
        });

        Gate::define('update-product', function() {
            return Auth::user()->role == 'admin';
        });

        Gate::define('read-product', function() {
            return Auth::user()->role == 'admin';
        });

        Gate::define('delete-product', function() {
            return Auth::user()->role == 'admin';
        });

        // Pages
        Gate::define('create-page', function() {
            return Auth::user()->role == 'admin';
        });

        Gate::define('update-page', function() {
            return Auth::user()->role == 'admin';
        });

        Gate::define('read-page', function() {
            return Auth::user()->role == 'admin';
        });

        Gate::define('delete-page', function() {
            return Auth::user()->role == 'admin';
        });

        // Media
        Gate::define('create-media', function() {
            return Auth::user()->role == 'admin';
        });

        Gate::define('update-media', function() {
            return Auth::user()->role == 'admin';
        });

        Gate::define('read-media', function() {
            return Auth::user()->role == 'admin';
        });

        Gate::define('delete-media', function() {
            return Auth::user()->role == 'admin';
        });

        // Settings
        Gate::define('update-settings', function() {
            return Auth::user()->role == 'admin';
        });

        Gate::define('read-settings', function() {
            return Auth::user()->role == 'admin';
        });
    }
}
