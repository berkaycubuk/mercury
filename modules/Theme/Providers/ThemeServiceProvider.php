<?php

namespace Theme\Providers;

use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        include __DIR__ . '/../Themes.php';
    }
}
