<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\HomeSlide;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $homeSlide = HomeSlide::latest()->first();
        if (! $homeSlide) {
            // Run the HomeSlideSeeder if no slide exists
            Artisan::call('db:seed', ['--class' => 'HomeSlideSeeder']);
            $homeSlide = HomeSlide::latest()->first();
        }

        $about = About::latest()->first();
        if (! $about) {
            // Run the AboutSeeder if no about exists
            Artisan::call('db:seed', ['--class' => 'AboutSeeder']);
            $about = About::latest()->first();
        }

        $services = Service::latest()->get();

        $portfolio = Portfolio::where('status', true)->latest()->get();

        $testimonials = Testimonial::where('status', true)->latest()->get();

        return view('frontend.pages.home', compact('homeSlide', 'about', 'services', 'portfolio', 'testimonials'));
    }
}