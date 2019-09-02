<?php

namespace App\Http\Controllers;

use App\Http\Requests\Posts\CreatePostsRequest;
use App\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{

    public function index()
    {
        return view ('posts.index')->with('posts', Post::all());
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(CreatePostsRequest $request)
    {
        //upload image
        $image = $request->image->store('posts');

        //create the post
        Post::create([
            'title'         => $request->title,
            'description'   => $request->description,
            'content'       => $request->content,
            'image'         => $image
        ]);

        //flash session
        session()->flash('success', 'Post Created Successfully');

        //redirect user
        return redirect(route('posts.index'));
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();
        if($post->trashed()){
            $post->forceDelete();
        }else{
            $post->delete();
        }
        $post->delete();
        session()->flash('success', 'Post deleted successfully');
        return redirect(route('posts.index'));
    }


    /* Display a list of all trashed posts */

    public function trashed()
    {
        $trashed = Post::withTrashed()->get();
        return view('posts.index')->withPosts($trashed);
    }
}
