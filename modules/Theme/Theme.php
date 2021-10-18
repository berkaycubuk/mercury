<?php

namespace Theme;

class Theme
{
    public $code;
    public $name;
    public $viewsPath;
    public $assetsPath;

    public function __construct($code, $name = null, $assetsPath = null, $viewsPath = null)
    {
        $this->code = $code;
        $this->name = $name;
        $this->assetsPath = $assetsPath === null ? $code : $assetsPath;
        $this->viewsPath = $viewsPath === null ? $code : $viewsPath;
    }
}
