<?php

namespace Core\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Core\Models\Page;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

class Pages extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('id', 'DESC')->paginate(10);
        return view('panel::pages.index', ['pages' => $pages]);
    }

    /**
     * Display a form to create new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view("panel::pages.create");
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
        try {
            $post = Page::create(
                array_merge($request->all(), [
                    "slug" => Str::slug($request->input("title"), '-'),
                ])
            );
        } catch (QueryException $e) {
            return redirect()
                ->route("panel.pages.create")
                ->with("form_error", trans("general.error"));
        }

        return redirect()
            ->route("panel.pages.index")
            ->with(
                "message_success",
                trans("general.successfully_created", [
                    "type" => trans_choice("general.pages", 1),
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
        $page = Page::where("id", "=", $id)
            ->where("deleted_at", "=", null)
            ->first();

        if (!$page) {
            return redirect()
                ->route("panel.pages.index")
                ->with(
                    "message_error",
                    trans("general.not_found", [
                        "type" => trans_choice("general.pages", 1),
                    ])
                );
        }

        return view("panel::pages.edit", [
            "page" => $page,
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
        $page = Page::where("id", "=", $request->input("id"))->first();

        if (!$page) {
            return redirect()
                ->route("panel.pages.index")
                ->with(
                    "message_error",
                    trans("general.not_found", [
                        "type" => trans_choice("general.pages", 1),
                    ])
                );
        }

        $page->update($request->all());

        return redirect()
            ->route("panel.pages.edit", ["id" => $page->id])
            ->with(
                "form_success",
                trans("general.successfully_updated", [
                    "type" => trans_choice("general.pages", 1),
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

        $page = Page::where("id", "=", $id)->first();

        if (!$page) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Page not found'
                ], 400);
        }

        $page->delete();

        return response()
            ->json([
                'success' => true,
                'message' => 'Page successfully deleted'
            ], 200);
    }
}
