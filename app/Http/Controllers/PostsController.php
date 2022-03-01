<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        $page = Page::forHook('blog')->firstOrFail();
        $posts = Post::where('published', 1)->get()->sortBy('created_at');

        return view('posts', [
            'page' => $page,
            'posts' => $posts
        ]);
    }

    public function show($slug){
        $post = Post::forSlug($slug)->where('published', 1)->first();

        if($post === null)
        {
            $post = Post::forInactiveSlug($slug)->where('published', 1)->firstOrFail();
            $active_slug = $post->slugs->filter(function ($value, $key) {
                return $value->active == 1;
            })->first();

            if($active_slug === null){
                return abort(404);
            }

            return redirect()->action(
                'PostsController@show', ['slug' => $active_slug->slug], 301
            );
        }

        return view('post-template', [
            'post' => $post
        ]);
    }
}
