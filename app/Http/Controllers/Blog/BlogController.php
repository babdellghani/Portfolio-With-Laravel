<?php

namespace App\Http\Controllers\Blog;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::latest()->get();

        return view('admin.blog.blog.index', compact('blogs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $blog = $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:blogs',
            'short_description' => 'required|max:255|string',
            'description' => 'required|string',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'status' => 'required',
            'category' => 'required|array',
            'category.*' => 'exists:categories,id',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
        ]);

        if ($request->hasFile('image')) {
            $blog['image'] = $request->file('image')->store('blog', 'public');
        }

        $blog['slug'] = Str::slug($blog['slug']);
        $blog['status'] = $request->input('status', 0);
        $blog['user_id'] = auth()->user()->id;

        $blog = Blog::create($blog);

        $blog->category()->sync($request->input('category', []));
        $blog->tag()->sync($request->input('tags', []));

        return back()->with([
            'message' => 'Blog created successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('admin.blog.blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $blogNew = $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:blogs,slug,' . $blog->id,
            'short_description' => 'required|max:255|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'status' => 'required',
            'category' => 'required|array',
            'category.*' => 'exists:categories,id',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
        ]);

        if ($request->hasFile('image')) {
            Storage::delete('public/' . $blog->image);
            $blogNew['image'] = $request->file('image')->store('blog', 'public');
        }

        $blogNew['slug'] = Str::slug($blogNew['slug']);
        $blogNew['status'] = $request->input('status', 0);
        $blogNew['user_id'] = auth()->user()->id;

        $blog->update($blogNew);

        $blog->category()->sync($request->input('category', []));
        $blog->tag()->sync($request->input('tags', []));

        return back()->with([
            'message' => 'Blog updated successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        Storage::delete('public/' . $blog->image);
        $blog->delete();

        return back()->with([
            'message' => 'Blog deleted successfully',
            'alert-type' => 'success',
        ]);
    }
}
