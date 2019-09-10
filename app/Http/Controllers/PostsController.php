<?php

namespace App\Http\Controllers;

use App\Http\Requests\Posts\CreatePostsRequest;
use App\Http\Requests\Posts\UpdatePostsRequest;
use App\Post;
use Illuminate\Support\Facades\Storage;

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


    public function edit(POST $post)
    {
        return view('posts.create')->with('post', $post);
    }


    public function update(UpdatePostsRequest $request, POST $post)
    {
        //store all values from request in a variable except image
        $data = $request->only(['title','description','postContent','published_at']);
        //check if new image
        if($request->hasFile('image')){
            //upload it
            $image = $request->image->store('posts');
            //delete old one
            Storage::delete($post->image);
        }
        //add image to container value
        $data['image'] = $image;
        //update attributes
        $post->update($data);
        //flash message
        session()->flash('success','Post updated successfully');
        //redirect user
        return redirect(route('posts.index'));
    }


    public function destroy($id)
    {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();
        if($post->trashed()){
            Storage::delete($post->image);
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
        $trashed = Post::onlyTrashed()->get();
        return view('posts.index')->withPosts($trashed);
    }
}
