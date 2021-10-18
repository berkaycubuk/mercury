<?php

namespace App\Services;

use Core\Models\Product\Product;
use Core\Models\Product\ProductCategory;
use Core\Models\Product\Subcategory;

class Menu
{
    public function categories()
    {
        return ProductCategory::all();
    }
}
