<?php

namespace Core\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class CoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        // $this->loadRoutesFrom(__DIR__ . '/../Routes/routes.php');
    }

    public function boot()
    {
        // load views from the theme directory
        $this->loadViewsFrom(__DIR__ . '/../../../' . currentTheme()->viewsPath, 'core');
        $this->loadViewsFrom(__DIR__ . '/../../../resources/views/panel', 'panel');
        // $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'core');
    }
}
