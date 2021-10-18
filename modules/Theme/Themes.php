<?php

use Theme\Theme;

if (!function_exists('themes')) {
    function themes()
    {
        $themes = [];

        foreach (config('themes.themes', []) as $code => $data) {
            $themes[] = new Theme(
                $code,
                isset($data['name']) ? $data['name'] : '',
                isset($data['assets_path']) ? $data['assets_path'] : '',
                isset($data['views_path']) ? $data['views_path'] : '',
            );          
        }        

        return $themes;
    }
}

if (!function_exists('currentTheme')) {
    function currentTheme()
    {
        return themes()[0];
    }
}
