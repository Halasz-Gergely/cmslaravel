<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\Categories\CreateCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoriesRequest;

class CategoriesController extends Controller
{

    public function index()
    {
        return view('categories.index')->with('categories', Category::all());
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(CreateCategoryRequest $request)
    {
        Category::create([
            'name' => $request->name
        ]);

        session()->flash('success','Category created successfully');

        return redirect(route('categories.index'));
    }

    public function show($id)
    {
        //
    }

    public function edit(Category $category)
    {
        return view('categories.create')->with('category', $category);
    }

    public function update(UpdateCategoriesRequest $request, Category $category)
    {
        $category->update([
            'name' => $request->name
        ]);
        $category->save();
        session()->flash('success', 'Category updated successfully');
        return redirect(route('categories.index'));
    }


    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('success','Category deleted successfully');
        return redirect(route('categories.index'));
    }
}
