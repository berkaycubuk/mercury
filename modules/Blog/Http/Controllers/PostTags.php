<?php

namespace Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Blog\Models\PostTag;
use Illuminate\Support\Str;

class PostTags extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $tags = PostTag::orderBy('id', 'DESC')->paginate(10);
        return view("panel.blog.tags.index", ["tags" => $tags]);
    }

    /**
     * Display a form to create new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view("panel.blog.tags.create");
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
        $productTag = PostTag::create(
            array_merge($request->all(), [
                "slug" => Str::slug($request->input("name"), '-'),
            ])
        );

        if (!$productTag) {
            return redirect()
                ->route("panel.blog.tags.create")
                ->with("form_error", trans("general.error"));
        }

        return redirect()
            ->route("panel.blog.tags.index")
            ->with(
                "message_success",
                trans("general.successfully_created", [
                    "type" => trans_choice("general.tags", 1),
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
        $productTag = PostTag::where("id", "=", $id)->first();

        if (!$productTag) {
            return redirect()
                ->route("panel.blog.tags.index")
                ->with(
                    "message_error",
                    trans("general.not_found", [
                        "type" => trans_choice("general.tags", 1),
                    ])
                );
        }

        return view("panel.blog.tags.edit", ["tag" => $productTag]);
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
        $productTag = PostTag::where("id", "=", $request->input("id"))->first();

        if (!$productTag) {
            return redirect()
                ->route("panel.blog.tags.index")
                ->with(
                    "message_error",
                    trans("general.not_found", [
                        "type" => trans_choice("general.tags", 1),
                    ])
                );
        }

        $productTag->update($request->all());

        return redirect()
            ->route("panel.blog.tags.edit", ["id" => $productTag->id])
            ->with(
                "form_success",
                trans("general.successfully_updated", [
                    "type" => trans_choice("general.tags", 1),
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
        $productTag = PostTag::where("id", "=", $id)->first();

        if (!$productTag) {
            return redirect()
                ->route("panel.blog.tags.index")
                ->with(
                    "message_error",
                    trans("general.not_found", [
                        "type" => trans_choice("general.tags", 1),
                    ])
                );
        }

        $productTag->delete();

        return redirect()
            ->route("panel.blog.tags.index")
            ->with(
                "message_success",
                trans("general.successfully_deleted", [
                    "type" => trans_choice("general.tags", 1),
                ])
            );
    }
}
