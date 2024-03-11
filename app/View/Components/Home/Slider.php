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
        return view('frontend.components.home.slider', ['homeSlide' => HomeSlide::latest()->firstOrFail()]);
    }
}
