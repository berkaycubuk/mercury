<?php

namespace Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Blog\Models\Post;
use Blog\Models\PostCategory;
use Core\Models\Media;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Posts extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'DESC')->paginate(10);
        return view("blog::panel.blog.posts.index", ["posts" => $posts]);
    }

    /**
     * Display a form to create new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view("blog::panel.blog.posts.create", [
            "postCategories" => PostCategory::all(),
            "media" => Media::all()
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
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        try {
            $post = Post::create(
                array_merge($request->all(), [
                    "slug" => Str::slug($request->input("title"), '-'),
                    "author" => Auth::user()->id,
                ])
            );
        } catch (QueryException $e) {
            return redirect()
                ->route("panel.blog.posts.create")
                ->with("form_error", trans("general.error"));
        }

        return redirect()
            ->route("panel.blog.posts.index")
            ->with(
                "message_success",
                trans("general.successfully_created", [
                    "type" => trans_choice("general.posts", 1),
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
        $post = Post::where("id", "=", $id)
            ->where("deleted_at", "=", null)
            ->first();

        $postCategories = PostCategory::all();

        if (!$post) {
            return redirect()
                ->route("panel.blog.posts.index")
                ->with(
                    "message_error",
                    trans("general.not_found", [
                        "type" => trans_choice("general.posts", 1),
                    ])
                );
        }

        $media = Media::all();

        return view("blog::panel.blog.posts.edit", [
            "post" => $post,
            "postCategories" => $postCategories,
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
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255',
            'content' => 'required',
        ]);

        $post = Post::where("id", "=", $request->input("id"))->first();

        if (!$post) {
            return redirect()
                ->route("panel.blog.posts.index")
                ->with(
                    "message_error",
                    trans("general.not_found", [
                        "type" => trans_choice("general.posts", 1),
                    ])
                );
        }

        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->content = $request->input('content');
        $post->thumbnail = $request->input('thumbnail');

        $post->save();

        return redirect()
            ->route("panel.blog.posts.edit", ["id" => $post->id])
            ->with(
                "form_success",
                trans("general.successfully_updated", [
                    "type" => trans_choice("general.posts", 1),
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

        $post = Post::where("id", "=", $id)->first();

        if (!$post) {
            return response()
                ->json([
                        'success' => false,
                        'message' => 'Post not found'
                    ], 400);
        }

        $post->delete();

        return response()
            ->json([
                'success' => true,
                'message' => 'Post successfully deleted'
            ], 200);
    }
}
