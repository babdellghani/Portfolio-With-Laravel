<?php
namespace App\View\Components\Pages;

use Closure;
use App\Models\Technology;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Breadcrumb extends Component
{
    public $technologies
;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->technologies = Technology::where('status', true)
            ->orderBy('order', 'asc')
            ->orderBy('name', 'asc')
            ->get();

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View | Closure | string
    {
        return view('components.pages.breadcrumb');
    }
}