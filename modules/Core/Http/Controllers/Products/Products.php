<?php

namespace Core\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Core\Models\Product\Product;
use Core\Models\Media;
use Core\Models\Product\ProductAttribute;
use Core\Models\Product\ProductCategory;
use Core\Models\Product\Subcategory;
use Illuminate\Database\QueryException;
use Core\Models\Settings\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;

class Products extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $products = Product::orderBy('id', 'DESC')->paginate(10);
        return view("panel::products.products.index", ["products" => $products]);
    }

    public function export()
    {
        $products = Product::all();

        $arrayData = [];

        foreach ($products as $product) {
            array_push($arrayData, [
                $product->id,
                $product->title,
                $product->short_description,
                $product->description,
                $product->product_category ? $product->product_category->name : '',
                $product->subcategory ? $product->subcategory->name : '',
                $product->price,
                isset($product->meta['tax']) ? $product->meta['tax'] : "",
                isset($product->meta['online_orderable']) ? $product->meta['online_orderable'] : "",
                isset($product->meta['show_on_menu']) ? $product->meta['show_on_menu'] : ""
            ]);
        }

        $export = new ProductsExport($arrayData);

        return Excel::download($export, 'urunler.xlsx');
    }

    public function import(Request $request)
    {
        $products = Excel::toCollection(new ProductsImport, $request->file('import_file'));

        foreach ($products[0] as $product) {
            $category = ProductCategory::where('name', $product['kategori'])->first();

            if (!$category) {
                $category = new ProductCategory;
                $category->name = $product['kategori'];
                $category->slug = Str::slug($product['kategori'], '-');
                $category->save();
            }
            
            $subcategory = Subcategory::where('name', $product['alt_kategori'])->first();

            if (!$subcategory) {
                $subcategory = new Subcategory;
                $subcategory->name = $product['alt_kategori'];
                $subcategory->slug = Str::slug($product['alt_kategori'], '-');
                $subcategory->product_category_id = $category->id;
                $subcategory->save();
            }

            $meta = [];

            if ($product['kdv'] == null) {
                $meta['kdv'] = 0;
            } else {
                $meta['kdv'] = $product['kdv'];
            }

            if ($product['online_siparis_edilebilir'] == null) {
                $meta['online_orderable'] = false;
            } else {
                $meta['online_orderable'] = true;
            }

            if ($product['yemek_menusunde_goster'] == null) {
                $meta['show_on_menu'] = false;
            } else {
                $meta['show_on_menu'] = true;
            }

            if ($product['id'] != null) {
                if(!($productObj = Product::where('id', $product['id'])->first())) {
                    if (!count(Product::where('title', $product['baslik'])->get())) {
                        Product::create([
                            'title' => $product['baslik'],
                            'slug' => Str::slug($product['baslik'], '-'),
                            'description' => $product['aciklama'],
                            'short_description' => $product['kisa_aciklama'],
                            'product_category_id' => $category->id,
                            'subcategory_id' => $subcategory->id,
                            'price' => $product['fiyat'],
                            'meta' => $meta,
                        ]);
                    }
                } else {
                    $productObj->update([
                        'title' => $product['baslik'],
                        'slug' => Str::slug($product['baslik'], '-'),
                        'description' => $product['aciklama'],
                        'short_description' => $product['kisa_aciklama'],
                        'product_category_id' => $category->id,
                        'subcategory_id' => $subcategory->id,
                        'price' => $product['fiyat'],
                        'meta' => array_merge($productObj->meta, $meta)
                    ]);
                }
            } else {
                if (!count(Product::where('title', $product['baslik'])->get())) {
                    Product::create([
                        'title' => $product['baslik'],
                        'slug' => Str::slug($product['baslik'], '-'),
                        'description' => $product['aciklama'],
                        'short_description' => $product['kisa_aciklama'],
                        'product_category_id' => $category->id,
                        'subcategory_id' => $subcategory->id,
                        'price' => $product['fiyat'],
                        'meta' => $meta,
                    ]);
                }
            }
        }

        return redirect()
            ->route('panel.products.products.index');
    }

    /**
     * Display a form to create new resource.
     *
     * @return Response
     */
    public function create()
    {
        $productCategories = ProductCategory::all();
        $productAttributes = ProductAttribute::all();
        $productSubcategories = Subcategory::all();
        $media = Media::all();

        return view("panel::products.products.create", [
            "productCategories" => $productCategories,
            "productAttributes" => $productAttributes,
            "productSubcategories" => $productSubcategories,
            "media" => $media,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|unique:products',
            'short_description' => 'string|nullable',
            'description' => 'string|nullable',
            'images' => 'nullable',
            'product_category_id' => 'nullable',
            'subcategory_id' => 'nullable',
            'price' => 'required',
            'tax' => 'nullable',
            'available-branches' => 'nullable',
            'available-shippings' => 'nullable',
            'stock_amount' => 'nullable',
            'stock_code' => 'nullable',
            'online_orderable' => 'nullable',
            'show-on-menu' => 'nullable',
            'public' => 'nullable',
            'product_attributes' => 'nullable',
        ]);

        $product = new Product;

        $this->save($product, $request);

        return redirect()
            ->route("panel.products.products.index")
            ->with(
                "message_success",
                trans("general.successfully_created", [
                    "type" => trans_choice("general.products", 1),
                ])
            );
    }

    /**
     * Display a form to edit resource.
     *
     * @return Response
     */
    public function edit($id)
    {
        $product = Product::where("id", "=", $id)->first();

        $productCategories = ProductCategory::all();
        $productAttributes = ProductAttribute::all();
        $productSubcategories = Subcategory::all();
        $media = Media::all();

        if (!$product) {
            return redirect()
                ->route("panel.products.products.index")
                ->with(
                    "message_error",
                    trans("general.not_found", [
                        "type" => trans_choice("general.products", 1),
                    ])
                );
        }

        return view("panel::products.products.edit", [
            "product" => $product,
            "productCategories" => $productCategories,
            "productAttributes" => $productAttributes,
            "productSubcategories" => $productSubcategories,
            "media" => $media,
        ]);
    }

    /**
     * Update resource.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                Rule::unique('products')->ignore($request->input('id')),
            ],
            'short_description' => 'string|nullable',
            'description' => 'string|nullable',
            'images' => 'nullable',
            'product_category_id' => 'nullable',
            'subcategory_id' => 'nullable',
            'price' => 'required',
            'tax' => 'nullable',
            'available-branches' => 'nullable',
            'available-shippings' => 'nullable',
            'stock_amount' => 'nullable',
            'stock_code' => 'nullable',
            'online_orderable' => 'nullable',
            'show-on-menu' => 'nullable',
            'product_attributes' => 'nullable',
        ]);
        
        $product = Product::where('id', $request->input('id'))->first();

        $this->save($product, $request);

        return redirect()
            ->route("panel.products.products.edit", ["id" => $request->input("id")])
            ->with(
                "message_success",
                trans("general.successfully_updated", [
                    "type" => trans_choice("general.products", 1),
                ])
            );
    }

    private function save(Product $product, Request $request)
    {
        $product->title = $request->input('title');
        $product->slug = Str::slug($request->input("title"), '-');
        $product->short_description = $request->input('short_description');
        $product->description = $request->input('description');
        $product->images = json_decode($request->input('images'));
        $product->price = $request->input('price');

        if ($request->input('category') != null && $request->input('category') != "null") {
            $product->product_category_id = $request->input('category');
        } else {
            $product->product_category_id = 0;
        }

        if ($request->input('subcategory') != null && $request->input('subcategory') != "null") {
            $product->subcategory_id = $request->input('subcategory');
        } else {
            $product->subcategory_id = 0;
        }

        $tax = $request->input('tax');
        $available_branches = $request->input('available-branches');
        $available_shippings = $request->input('available-shippings');
        $stock_amount = $request->input('stock_amount');
        $stock_code = $request->input('stock_code');
        $online_orderable = $request->input('online_orderable');
        $show_on_menu = $request->input('show-on-menu');
        $public = $request->input('public');
        $attributes = $request->input('product_attributes');

        $meta = [];

        if ($tax != null) {
            $meta['tax'] = $tax;
        } else {
            $meta['tax'] = 0;
        }

        if ($request->input('discount-price') != null) {
            $meta['discount_price'] = $request->input('discount-price');
        } else {
            $meta['discount_price'] = null;
        }

        if ($available_branches == null) {
            $meta['available_branches'] = [];
        } else {
            $meta['available_branches'] = $available_branches;
        }

        if ($available_shippings == null) {
            $meta['available_shippings'] = [];
        } else {
            $meta['available_shippings'] = $available_shippings;
        }

        if ($stock_amount != null) {
            $meta['stock_amount'] = $stock_amount;
        }

        if ($stock_code) {
            $meta['stock_code'] = $stock_code;
        }

        if ($online_orderable) {
            $meta['online_orderable'] = true;
        }

        if ($show_on_menu) {
            $meta['show_on_menu'] = true;
        } else {
            $meta['show_on_menu'] = false;
        }

        if ($public) {
            $meta['public'] = true;
        } else {
            $meta['public'] = false;
        }

        if ($attributes) {
            $meta['attributes'] = json_decode($attributes);
        }

        $product->meta = $meta;

        $product->save();
    }

    /**
     * Delete resource.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function delete(Request $request)
    {
        try {
            $id = $request->input('id');

            $product = Product::where("id", "=", $id)->first();

            if (!$product) {
                return response()
                    ->json([
                        'success' => false,
                        'message' => 'Product not found'
                    ], 400);
            }

            $product->delete();

            return response()
                ->json([
                    'success' => true,
                    'message' => 'Product successfully deleted'
                ], 200);
        } catch(QueryException $e) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Product not deleted, query exception'
                ], 400);
        }
    }
}
