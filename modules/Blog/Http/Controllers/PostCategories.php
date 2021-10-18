<?php

namespace Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Core\Models\PostCategory;
use Illuminate\Support\Str;

class PostCategories extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories = PostCategory::orderBy('id', 'DESC')->paginate(10);
        return view("blog::panel.blog.categories.index", [
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
        return view("blog::panel.blog.categories.create");
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
        $productCategory = PostCategory::create(
            array_merge($request->all(), [
                "slug" => Str::slug($request->input("name"), '-'),
            ])
        );

        if (!$productCategory) {
            return redirect()
                ->route("panel.blog.categories.create")
                ->with("form_error", trans("general.error"));
        }

        return redirect()
            ->route("panel.blog.categories.index")
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
        $productCategory = PostCategory::where("id", "=", $id)->first();

        if (!$productCategory) {
            return redirect()
                ->route("panel.blog.categories.index")
                ->with(
                    "message_error",
                    trans("general.not_found", [
                        "type" => trans_choice("general.categories", 1),
                    ])
                );
        }

        return view("blog::panel.blog.categories.edit", [
            "category" => $productCategory,
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
        $productCategory = PostCategory::where(
            "id",
            "=",
            $request->input("id")
        )->first();

        if (!$productCategory) {
            return redirect()
                ->route("panel.blog.categories.index")
                ->with(
                    "message_error",
                    trans("general.not_found", [
                        "type" => trans_choice("general.categories", 1),
                    ])
                );
        }

        $productCategory->update($request->all());

        return redirect()
            ->route("panel.blog.categories.edit", [
                "id" => $productCategory->id,
            ])
            ->with(
                "form_success",
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
    public function delete($id)
    {
        $productCategory = PostCategory::where("id", "=", $id)->first();

        if (!$productCategory) {
            return redirect()
                ->route("panel.blog.categories.index")
                ->with(
                    "message_error",
                    trans("general.not_found", [
                        "type" => trans_choice("general.categories", 1),
                    ])
                );
        }

        $productCategory->delete();

        return redirect()
            ->route("panel.blog.categories.index")
            ->with(
                "form_success",
                trans("general.successfully_deleted", [
                    "type" => trans_choice("general.categories", 1),
                ])
            );
    }
}
