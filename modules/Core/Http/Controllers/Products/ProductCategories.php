<?php

namespace Core\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Core\Models\Product\ProductCategory;
use Core\Models\Media;
use Illuminate\Support\Str;
use App\Imports\ProductCategoriesImport;
use App\Exports\ProductCategoriesExport;
use Maatwebsite\Excel\Facades\Excel;

class ProductCategories extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories = ProductCategory::orderBy('id', 'DESC')->paginate(10);
        return view("panel::products.categories.index", [
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
        $media = Media::all();

        return view("panel::products.categories.create", compact('media'));
    }

    public function export()
    {
        return Excel::download(new ProductCategoriesExport, 'urun-kategorileri.xlsx');
    }

    public function import(Request $request)
    {
        $categories = Excel::toCollection(new ProductCategoriesImport, $request->file('import_file'));

        foreach ($categories[0] as $category) {
            if ($category['id'] != null) {
                if(!ProductCategory::where('id', $category['id'])->update([
                    'name' => $category['baslik'],
                    'slug' => $category['slug']
                ])) {
                    if (!count(ProductCategory::where('slug', $category['slug'])->get())) {
                        ProductCategory::create([
                            'name' => $category['baslik'],
                            'slug' => $category['slug']
                        ]);
                    }
                }
            } else {
                if (!count(ProductCategory::where('slug', $category['slug'])->get())) {
                    ProductCategory::create([
                        'name' => $category['baslik'],
                        'slug' => $category['slug']
                    ]);
                }
            }
        }

        return redirect()
            ->route('panel.products.categories.index');
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
        $meta = [];

        if ($request->input('image') != null) {
            $meta['image'] = $request->input('image');
        } else {
            $meta['image'] = null;
        }

        $productCategory = ProductCategory::create([
            "name" => $request->input('name'),
            "slug" => Str::slug($request->input("name"), '-'),
            "meta" => $meta
        ]);

        if (!$productCategory) {
            return redirect()
                ->route("panel.products.categories.create")
                ->with("form_error", trans("general.error"));
        }

        return redirect()
            ->route("panel.products.categories.index")
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
        $productCategory = ProductCategory::where("id", "=", $id)->first();
        $media = Media::all();


        if (!$productCategory) {
            return redirect()
                ->route("panel.products.categories.index")
                ->with(
                    "message_error",
                    trans("general.not_found", [
                        "type" => trans_choice("general.categories", 1),
                    ])
                );
        }

        return view("panel::products.categories.edit", [
            "category" => $productCategory,
            "media" => $media
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
        $productCategory = ProductCategory::where(
            "id",
            "=",
            $request->input("id")
        )->first();

        if (!$productCategory) {
            return redirect()
                ->route("panel.products.categories.index")
                ->with(
                    "message_error",
                    trans("general.not_found", [
                        "type" => trans_choice("general.categories", 1),
                    ])
                );
        }

        $productCategory->name = $request->input('name');
        $productCategory->slug = $request->input('slug');

        $meta = [];

        if ($request->input('image') != null) {
            $meta['image'] = $request->input('image');
        } else {
            $meta['image'] = null;
        }

        $productCategory->meta = $meta;

        $productCategory->save();

        return redirect()
            ->route("panel.products.categories.edit", [
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

        $productCategory = ProductCategory::where("id", $id)->first();

        if (!$productCategory) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Category not found'
                ], 400);
        }

        $productCategory->delete();

        return response()
            ->json([
                'success' => true,
                'message' => 'Category successfully deleted'
            ], 200);
    }
}
