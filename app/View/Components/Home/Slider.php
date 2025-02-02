<?php

namespace App\View\Components\Home;

use Closure;
use App\Models\HomeSlide;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Slider extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $homeSlide = HomeSlide::latest()->first();
        
        if (!$homeSlide) {
            \Artisan::call('db:seed', ['--class' => 'HomeSlideSeeder']);
            $homeSlide = HomeSlide::latest()->firstOrFail();
        }
        
        return view('frontend.components.home.slider', ['homeSlide' => $homeSlide]);
    }
}
