<?php

namespace App\Http\Controllers\About;

use App\Models\About;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Database\Seeders\About\AboutSeeder;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $about = About::latest()->first();

        if (!$about) {
            (new AboutSeeder())->run();
            $about = About::latest()->first();
        }

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
            'cv_file' => 'nullable|file|mimetypes:application/pdf|max:10000',
        ]);

        $about = About::latest()->firstOrFail();
        if (!$about) {
            (new AboutSeeder())->run();
            $about = About::latest()->first();
        }
        
        if ($request->hasFile('about_image')) {
            Storage::delete('public/' . $about->about_image);
            $about->about_image = $request->file('about_image')->store('about', 'public');
        }

        if ($request->hasFile('cv_file')) {
            Storage::delete('public/' . $about->cv_file);
            $about->cv_file = $request->file('cv_file')->store('about', 'public');
        }

        $about->title = $request->title;
        $about->short_title = $request->short_title;
        $about->short_description = $request->short_description;
        $about->long_description = $request->long_description;

        $about->save();

        return back()->with([
            'message' => 'About created successfully',
            'alert-type' => 'success',
        ]);
    }
}
