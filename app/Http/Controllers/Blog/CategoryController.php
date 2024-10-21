<?php

namespace App\Http\Controllers\Blog;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->get();

        return view('admin.blog.categories.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories',
            'status' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'description' => 'required|string',          
        ]);

        if ($request->hasFile('image')) {
            $category['image'] = $request->file('image')->store('category', 'public');
        }

        $category['slug'] = Str::slug($category['slug']);
        $category['status'] = $request->input('status', 0);
        $category['user_id'] = auth()->user()->id;

        Category::create($category);

        return back()->with([
            'message' => 'Category created successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.blog.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $categoryNew = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,' . $category->id,
            'status' => 'required',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',          
        ]);

        if ($request->hasFile('image')) {
            Storage::delete('public/' . $category->image);
            $categoryNew['image'] = $request->file('image')->store('category', 'public');
        }

        $categoryNew['slug'] = Str::slug($categoryNew['slug']);
        $categoryNew['status'] = $request->input('status', 0);
        $categoryNew['user_id'] = auth()->user()->id;

        $category->update($categoryNew);

        return redirect()->route('category')->with([
            'message' => 'Category updated successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        Storage::delete('public/' . $category->image);
        $category->delete();

        return back()->with([
            'message' => 'Category deleted successfully',
            'alert-type' => 'success',
        ]);
    }
}
