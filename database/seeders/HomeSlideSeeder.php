<?php

namespace Database\Seeders;

use App\Models\HomeSlide;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomeSlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HomeSlide::create([
            'title' => 'I will give you Best Product in the shortest time.',
            'short_title' => 'I\'m a Rasalina based product design & visual designer focused on crafting clean & user‑friendly experiences',
            'home_slide' => 'defaults_images/banner_img.png',
            'video_url' => 'https://youtu.be/dgpN8J0qE90?si=0CHYdqqpFHMKwoIq',
        ]);
    }
}
