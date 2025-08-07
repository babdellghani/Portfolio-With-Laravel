<?php
namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\About\AboutSeeder;
use Database\Seeders\About\AwardSeeder;
use Database\Seeders\About\EducationSeeder;
use Database\Seeders\About\SkillSeeder;
use Database\Seeders\ContactSeeder;
use Database\Seeders\HomeSlideSeeder;
use Database\Seeders\PartnerSeeder;
use Database\Seeders\PortfolioSeeder;
use Database\Seeders\ServiceSeeder;
use Database\Seeders\TechnologySeeder;
use Database\Seeders\TestimonialSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\WebsiteInfoSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UserSeeder::class,
            AboutSeeder::class,
            AwardSeeder::class,
            EducationSeeder::class,
            SkillSeeder::class,
            HomeSlideSeeder::class,
            PartnerSeeder::class,
            TechnologySeeder::class,
            PortfolioSeeder::class,
            ServiceSeeder::class,
            TestimonialSeeder::class,
            WebsiteInfoSeeder::class,
            ContactSeeder::class,
            // Blog system seeders
            CategorySeeder::class,
            TagSeeder::class,
            BlogSeeder::class,
        ]);
    }
}
