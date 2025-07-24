<?php

namespace App\View\Components\About;

use Closure;
use App\Models\About as AboutModel;
use App\Models\Award;
use App\Models\Education;
use App\Models\Skill;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Database\Seeders\About\AboutSeeder;
use Database\Seeders\About\AwardSeeder;
use Database\Seeders\About\EducationSeeder;
use Database\Seeders\About\SkillSeeder;

class About extends Component
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
        $about = AboutModel::latest()->first();
        $award = Award::latest()->get();
        $education = Education::latest()->get();
        $skills = Skill::latest()->get();

        if (!$about) {
            (new AboutSeeder())->run();
            $about = AboutModel::latest()->first();
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
        
        return view('frontend.components.about.about', compact('about', 'award', 'education', 'skills'));
    }
}
