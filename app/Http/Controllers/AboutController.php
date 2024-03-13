<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $about = About::latest()->first();

        return view('admin.about.about', compact('about'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'short_title' => 'required|max:255',
            'short_description' => 'required|max:255|string',
            'long_description' => 'required|max:255|string',
            'about_image' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        About::create([
            'title' => $request->title,
            'short_title' => $request->short_title,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'about_image' => $request->about_image,
        ]);

        return back()->with([
            'message' => 'About created successfully',
            'alert-type' => 'success',
        ]);
    }
}
