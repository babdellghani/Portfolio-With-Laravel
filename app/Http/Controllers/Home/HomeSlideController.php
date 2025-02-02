<?php

namespace App\Http\Controllers\Home;

use App\Models\HomeSlide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Artisan;

class HomeSlideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slide = HomeSlide::latest()->first();
        
        if (!$slide) {
            // Run the HomeSlideSeeder if no slide exists
            Artisan::call('db:seed', ['--class' => 'HomeSlideSeeder']);
            $slide = HomeSlide::latest()->first();
        }
        
        return view('admin.home.slide', compact('slide'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $slideNew = $request->validate([
            'title' => 'required',
            'short_title' => 'nullable',
            'home_slide' => 'nullable|mimes:png,jpg,jpeg|image|max:2048',
            'video_url' => 'nullable|file|mimetypes:video/mp4,video/x-m4v,video/*|max:10000',
        ]);

        $slide = HomeSlide::latest()->first();
        
        if (!$slide) {
            // Run the HomeSlideSeeder if no slide exists
            Artisan::call('db:seed', ['--class' => 'HomeSlideSeeder']);
            $slide = HomeSlide::latest()->first();
        }

        if ($request->hasFile('home_slide')) {
            Storage::delete('public/' . $slide->home_slide);

            // Create Directory if not exist
            if (!Storage::exists('public/home_slide')) {
                Storage::makeDirectory('public/home_slide');
            }

            // Rename Image
            $homeSlide = $request->file('home_slide');
            $filename = time() . '.' . $homeSlide->getClientOriginalExtension();

            try {
                // Create Image
                $imageManager = new ImageManager(new Driver());
                $image = $imageManager->read($homeSlide->path());
                
                // Resize image
                $image->resize(636, 852, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('storage/home_slide/' . $filename));
                
                // Save image
                $slideNew['home_slide'] = 'home_slide/' . $filename;
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['home_slide' => 'Error processing image: ' . $e->getMessage()]);
            }
        }

        if ($request->hasFile('video_url')) {
            Storage::delete('public/' . $slide->video_url);
            $slideNew['video_url'] = $request->file('video_url')->store('home_slide', 'public');
        }
        
        $slide->update($slideNew);

        return redirect()->back()->with(['message'=> 'Home Slide Updated Successfully', 'alert-type'=> 'success']);
    }
}
