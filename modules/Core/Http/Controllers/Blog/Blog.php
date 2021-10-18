<?php

namespace Core\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Core\Models\Blog\Post;

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

        return view('core::blog.index', ['posts' => $posts]);
    }

    public function post($slug)
    {
        $post = Post::where('slug', '=', $slug)->first();

        if (!$post) {
            return redirect()
                ->route('store.404');
        }

        $posts = Post::where('id', '!=', $post->id)->orderBy('id', 'DESC')->get();

        return view('core::blog.post', [
            'post' => $post,
            'posts' => $posts,
        ]);
    }
}
