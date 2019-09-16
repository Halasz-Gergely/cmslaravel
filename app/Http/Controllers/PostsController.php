<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\Posts\CreatePostsRequest;
use App\Http\Requests\Posts\UpdatePostsRequest;
use App\Post;
use App\Tag;


class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('verifyCategoriesCount')->only(['create', 'store']);
    }

    public function index()
    {
        return view ('posts.index')->with('posts', Post::all());
    }

    public function create()
    {
        return view('posts.create')->with('categories', Category::all())->with('tags', Tag::all());
    }

    public function store(CreatePostsRequest $request)
    {
        //upload image
        $image = $request->image->store('posts');
        //create the post
        $post = Post::create([
            'title'         => $request->title,
            'description'   => $request->description,
            'content'       => $request->content,
            'image'         => $image
        ]);

        if($request->tags)
        {
            $post->tags()->attach($request->tags);
        }

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
        return view('posts.create')->with('post', $post)->with('categories', Category::all())->with('tags', Tag::all());
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
            $post->deleteImage();
            //add image to container value
            $data['image'] = $image;
        }
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
            $post->deleteImage();
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

    /* Restores trashed post */

    public function restore($id)
    {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();
        $post->restore();
        session()->flash('success', 'Post restored successfully');
        return redirect()->back();
    }
}
