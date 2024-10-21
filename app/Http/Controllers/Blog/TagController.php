<?php

namespace App\Http\Controllers\Blog;

use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::latest()->get();

        return view('admin.blog.tags.index', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tag = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:tags',
            'status' => 'required',            
        ]);

        $tag['slug'] = Str::slug($tag['slug']);
        $tag['status'] = $request->input('status', 0);
        $tag['user_id'] = auth()->user()->id;

        Tag::create($tag);

        return back()->with([
            'message' => 'Tag created successfully',
            'alert-type' => 'success',
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return view('admin.blog.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $tagNew = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:tags,slug,' . $tag->id,
            'status' => 'required',            
        ]);

        $tagNew['slug'] = Str::slug($tagNew['slug']);
        $tagNew['status'] = $request->input('status', 0);
        $tagNew['user_id'] = auth()->user()->id;

        $tag->update($tagNew);

        return redirect()->route('tag')->with([
            'message' => 'Tag updated successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return back()->with([
            'message' => 'Tag deleted successfully',
            'alert-type' => 'success',
        ]);
    }
}
