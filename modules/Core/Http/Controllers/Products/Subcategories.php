<?php

namespace Core\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Core\Models\Product\ProductCategory;
use Core\Models\Product\Subcategory;
use Illuminate\Support\Str;
use App\Imports\ProductSubcategoriesImport;
use App\Exports\ProductSubcategoriesExport;
use Maatwebsite\Excel\Facades\Excel;
use Core\Models\Media;

class Subcategories extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories = Subcategory::orderBy('id', 'DESC')->paginate(10);
        return view("panel::products.subcategories.index", [
            "categories" => $categories,
        ]);
    }

    /**
     * Display a form to create new resource.
     *
     * @return Response
     */
    public function create()
    {
        $productCategories = ProductCategory::all();

        return view("panel::products.subcategories.create", compact('productCategories'));
    }

    public function export()
    {
        $subcategories = Subcategory::all();

        $arrayData = [];

        foreach ($subcategories as $subcategory) {
            array_push($arrayData, [
                $subcategory->id,
                $subcategory->name,
                $subcategory->product_category->name
            ]);
        }

        $export = new ProductSubcategoriesExport($arrayData);

        return Excel::download($export, 'urun-altkategorileri.xlsx');
    }

    public function import(Request $request)
    {
        $subcategories = Excel::toCollection(new ProductSubcategoriesImport, $request->file('import_file'));

        foreach ($subcategories[0] as $subcategory) {
            $category = ProductCategory::where('name', $subcategory['ust_kategori'])->first();

            if (!$category) {
                $category = new ProductCategory;
                $category->name = $subcategory['ust_kategori'];
                $category->slug = Str::slug($subcategory['ust_kategori'], '-');
                $category->save();
            }

            if ($subcategory['id'] != null) {
                if(!Subcategory::where('id', $subcategory['id'])->update([
                    'name' => $subcategory['baslik'],
                    'slug' => Str::slug($subcategory['baslik'], '-'),
                    'product_category_id' => $category->id
                ])) {
                    if (!count(Subcategory::where('name', $subcategory['baslik'])->get())) {
                        Subcategory::create([
                            'name' => $subcategory['baslik'],
                            'slug' => Str::slug($subcategory['baslik'], '-'),
                            'product_category_id' => $category->id
                        ]);
                    }
                }
            } else {
                if (!count(Subcategory::where('name', $subcategory['baslik'])->get())) {
                    Subcategory::create([
                        'name' => $subcategory['baslik'],
                        'slug' => Str::slug($subcategory['baslik'], '-'),
                        'product_category_id' => $category->id
                    ]);
                }
            }
        }

        return redirect()
            ->route('panel.products.subcategories.index');
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
        $productCategory = Subcategory::create(
            array_merge($request->all(), [
                "slug" => Str::slug($request->input("name"), '-'),
                "product_category_id" => $request->input("parent-category")
            ])
        );

        if (!$productCategory) {
            return redirect()
                ->route("panel.products.subcategories.create")
                ->with("form_error", trans("general.error"));
        }

        return redirect()
            ->route("panel.products.subcategories.index")
            ->with(
                "message_success",
                trans("general.successfully_created", [
                    "type" => trans_choice("general.categories", 1),
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
        $productCategory = Subcategory::where("id", "=", $id)->first();

        $productCategories = ProductCategory::all();

        $media = Media::all();

        if (!$productCategory) {
            return redirect()
                ->route("panel.products.subcategories.index")
                ->with(
                    "message_error",
                    trans("general.not_found", [
                        "type" => trans_choice("general.categories", 1),
                    ])
                );
        }

        return view("panel::products.subcategories.edit", [
            "category" => $productCategory,
            "productCategories" => $productCategories,
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
        $productCategory = Subcategory::where(
            "id",
            "=",
            $request->input("id")
        )->first();

        if (!$productCategory) {
            return redirect()
                ->route("panel.products.subcategories.index")
                ->with(
                    "message_error",
                    trans("general.not_found", [
                        "type" => trans_choice("general.categories", 1),
                    ])
                );
        }

        $productCategory->name = $request->input('name');
        $productCategory->slug = $request->input('slug');
        $productCategory->product_category_id = $request->input('parent-category');

        $meta = [];

        if ($request->input('image') != null) {
            $meta['image'] = $request->input('image');
        } else {
            $meta['image'] = null;
        }

        $productCategory->meta = $meta;

        $productCategory->save();

        return redirect()
            ->route("panel.products.subcategories.edit", [
                "id" => $productCategory->id,
            ])
            ->with(
                "message_success",
                trans("general.successfully_updated", [
                    "type" => trans_choice("general.categories", 1),
                ])
            );
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
        $id = $request->input('id');

        $productCategory = Subcategory::where("id", "=", $id)->first();

        if (!$productCategory) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Subcategory not found'
                ], 400);
        }

        $productCategory->delete();

        return response()
            ->json([
                'success' => true,
                'message' => 'Subcategory successfully deleted'
            ], 200);
    }
}
