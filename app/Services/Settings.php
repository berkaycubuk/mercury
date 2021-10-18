<?php

namespace App\Services;

class Settings
{
    public function getSetting($key)
    {
        return get_settings($key);
    }

    public function getMenu($key)
    {
        return get_settings('menu')->$key;
    }
}
