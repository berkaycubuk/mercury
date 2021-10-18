<?php

namespace Core\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Core\Models\Product\ProductCategory;
use Core\Models\Product\Subcategory;
use Core\Models\Product\Product;

class Menu extends Controller
{
    public function index()
    {
        return view('core::menu.index');
    }

    public function branchMenu($slug)
    {
        $branches = get_settings('branches');

        $branchData = null;

        foreach ($branches as $branch) {
            if ($branch->slug == $slug) {
                $branchData = $branch;
                break;
            }
        }

        $products = Product::all();
        $categories = ProductCategory::all();
        $subcategories = Subcategory::all();

        if (!$branchData) {
            return redirect()
                ->route('store.404');
        }

        return view('core::menu.branch-menu', [
            'branch' => $branchData,
            'categories' => $categories,
            'subcategories' => $subcategories
        ]);
    }
}
