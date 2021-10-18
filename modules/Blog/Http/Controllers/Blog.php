<?php

namespace Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Blog\Models\Post;

class Blog extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $posts = Post::where('id', '!=', 0)->orderBy('id', 'DESC')->get();

        return view('blog::blog.index', ['posts' => $posts]);
    }

    public function post($slug)
    {
        $post = Post::where('slug', '=', $slug)->first();

        if (!$post) {
            return redirect()
                ->route('store.404');
        }

        $posts = Post::where('id', '!=', $post->id)->orderBy('id', 'DESC')->get();

        return view('blog::blog.post', [
            'post' => $post,
            'posts' => $posts,
        ]);
    }
}
