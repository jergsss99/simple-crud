<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Post;
use \Cache;

class PostController extends Controller
{
    public function index()
    {

        $currentPage = request()->get('page',1);
        $post = Cache::remember('post-'.$currentPage, now()->addMinutes(15), function()
        {
            return Post::where('id', '!=', '1')->latest()->paginate(6);
        });

        return Inertia::render('Posts', [

            'post' => $post,

            ]);
    }

    public function create()
    {
         return Inertia::render('PostsCreate');

    }

    public function edit($id)
    {   $post = Post::findOrFail($id);
        return Inertia::render('PostsEdit')->with('data',$post);
    }

}
