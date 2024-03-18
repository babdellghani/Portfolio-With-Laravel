<?php

namespace App\Http\Controllers\Home;

use App\Models\HomeSlide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class HomeSlideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $homeSlide = HomeSlide::latest()->firstOrFail();
        return view('admin.home.slide', compact('homeSlide'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'short_title' => 'nullable',
            'home_slide' => 'nullable|mimes:png,jpg,jpeg|image|max:2048',
            'video_url' => 'nullable|file|mimetypes:video/mp4,video/x-m4v,video/*|max:10000',
        ]);
        $homeSlide = HomeSlide::latest()->firstOrFail();
        $homeSlide->title = $request->title;
        $homeSlide->short_title = $request->short_title;
        if ($request->has('home_slide')) {
            Storage::delete('public/' . $homeSlide->home_slide);

            // Create Directory if not exist
            if (!Storage::exists('public/home_slide')) {
                Storage::makeDirectory('public/home_slide');
            }

            // Rename Image
            $slide = $request->file('home_slide');
            $filename = time() . '.' . $slide->getClientOriginalExtension();

            // Create Image
            $imageManager = new ImageManager(new Driver());
            $image = $imageManager->read($slide);
            
            // Resize image
            $image->resize(636, 852, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('storage/home_slide/' . $filename));
            
            // Save image
            $homeSlide->home_slide = 'home_slide/' . $filename;
        }
        if ($request->has('video_url')) {
            Storage::delete('public/' . $homeSlide->video_url);
            $file = $request->file('video_url')->store('home_slide', 'public');
            $homeSlide->video_url = $file;
        }
        $homeSlide->save();
        return redirect()->back()->with(['message'=> 'Home Slide Updated Successfully', 'alert-type'=> 'success']);
    }
}
