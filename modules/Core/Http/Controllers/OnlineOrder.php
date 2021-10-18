<?php

namespace Core\Http\Controllers;

use Illuminate\Http\Request;
use Core\Models\Product\Product;
use Core\Models\Product\ProductCategory;

class OnlineOrder extends Controller
{
    public function index()
    {
        $product_categories = ProductCategory::all();
        $products = Product::where('id', '!=', 0)->orderBy('id', 'DESC')->get();
        $popularProducts = Product::where('id', '!=', 0)->orderBy('id', 'DESC')->get()->take(6);
        $newProducts = Product::where('id', '!=', 0)->orderBy('id', 'DESC')->get()->take(6);

        return view("core::online-order", [
            'settings' => get_settings('site'),
            'popular_products' => $popularProducts,
            'product_categories' => $product_categories,
            'new_products' => $newProducts
        ]);
    }
}
