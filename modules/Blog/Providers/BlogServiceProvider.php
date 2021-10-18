<?php

namespace Blog\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class BlogServiceProvider extends ServiceProvider
{
    public function register()
    {
        // $this->loadRoutesFrom(__DIR__ . '/../Routes/routes.php');
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'blog');
    }
}
