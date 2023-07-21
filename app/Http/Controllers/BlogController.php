<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    //
    function index()
    {
        $posts = Post::query()->where('published_at', '<=', Carbon::now())
            ->orderBy('published_at', 'desc')
            ->paginate(config('blog.posts_per_page'));
//        dd(compact('post'));
        return view('blog.index', compact('posts'));
    }

    function showPost($slug)
    {
        $post = Post::query()->where('slug', $slug)->firstOrFail();
        return view('blog.post', ['post' => $post]);
    }
}
