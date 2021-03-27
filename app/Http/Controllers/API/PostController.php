<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PostResource;
use \Cache;


class PostController extends Controller
{

    public function show($id)
    {
        $role = Post::findOrFail($id);
        return (new PostResource($role))->response();
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title' => ['required'],
            'body' => ['required'],
        ])->validate();

        $post = new Post;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();
        Cache::flush();

    }


    public function update(Request $request, Post $post)
    {
        Validator::make($request->only('title', 'body'), [
            'title' => ['required'],
            'body' => ['required'],
        ])->validate();

        if ($request->has('id')) {
            Post::find($request->input('id'))->update($request->all());
        }
        Cache::flush();
    }

    public function destroy($id)
    {
        Post::find($id)->delete();
        Cache::flush();

    }

}


