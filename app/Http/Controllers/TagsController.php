<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Http\Requests\Tags\CreateTagRequest;
use App\Http\Requests\Tags\UpdateTagsRequest;

class TagsController extends Controller
{

    public function index()
    {
        return view('tags.index')->with('tags', Tag::all());
    }

    public function create()
    {
        return view('tags.create');
    }

    public function store(CreateTagRequest $request)
    {
        Tag::create([
            'name' => $request->name
        ]);

        session()->flash('success','Tag created successfully');

        return redirect(route('tags.index'));
    }

    public function show($id)
    {
        //
    }

    public function edit(Tag $tag)
    {
        return view('tags.create')->with('tag', $tag);
    }

    public function update(UpdateTagsRequest $request, Tag $tag)
    {
        $tag->update([
            'name' => $request->name
        ]);
        $tag->save();
        session()->flash('success', 'Tag updated successfully');
        return redirect(route('tags.index'));
    }


    public function destroy(Tag $tag)
    {
        if($tag->posts->count() > 0)
        {
            session()->flash('error','Tag cannot be deleted, because its still associated to some post');
            return redirect()->back();
        }
        $tag->delete();
        session()->flash('success','Tag deleted successfully');
        return redirect(route('tags.index'));
    }
}
