<?php
namespace App\Http\Controllers\About;

use App\Models\Blog;
use App\Models\About;
use App\Models\Award;
use App\Models\Skill;
use App\Models\Service;
use App\Models\Education;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Database\Seeders\About\AboutSeeder;
use Database\Seeders\About\AwardSeeder;
use Database\Seeders\About\SkillSeeder;
use Illuminate\Support\Facades\Storage;
use Database\Seeders\About\EducationSeeder;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource (Admin only)
     */
    public function index()
    {
        $this->requireAdmin();

        $about = About::latest()->first();

        if (! $about) {
            (new AboutSeeder())->run();
            $about = About::latest()->first();
        }

        return view('admin.about.about', compact('about'));
    }

    /**
     * Show the form for frontend (Public)
     */
    public function home()
    {
        $about     = About::latest()->first();
        $award     = Award::latest()->get();
        $education = Education::latest()->get();
        $skills    = Skill::latest()->get();

        $service = Service::latest()->take(8)->get();

        $testimonials = Testimonial::where('status', true)->latest()->get();

        $blogs = Blog::where('status', 'published')->with('categories')->latest()->take(3)->get();

        if (! $about) {
            (new AboutSeeder())->run();
            $about = About::latest()->first();
        }
        if ($award->count() === 0) {
            (new AwardSeeder())->run();
            $award = Award::latest()->get();
        }
        if ($education->count() === 0) {
            (new EducationSeeder())->run();
            $education = Education::latest()->get();
        }
        if ($skills->count() === 0) {
            (new SkillSeeder())->run();
            $skills = Skill::latest()->get();
        }

        return view('frontend.pages.about', compact('about', 'award', 'education', 'skills', 'service', 'testimonials', 'blogs'));
    }

    /**
     * Store a newly created resource in storage (Admin only)
     */
    public function store(Request $request)
    {
        $this->requireAdmin();
        $request->validate([
            'title'             => 'required',
            'short_title'       => 'required|max:255',
            'short_description' => 'required|string',
            'long_description'  => 'required|string',
            'about_image'       => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'cv_file'           => 'nullable|file|mimetypes:application/pdf|max:10000',
        ]);

        $about = About::latest()->firstOrFail();
        if (! $about) {
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

        $about->title             = $request->title;
        $about->short_title       = $request->short_title;
        $about->short_description = $request->short_description;
        $about->long_description  = $request->long_description;

        $about->save();

        return back()->with([
            'message'    => 'About created successfully',
            'alert-type' => 'success',
        ]);
    }
}