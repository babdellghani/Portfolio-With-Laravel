<?php

namespace Database\Seeders\About;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Database\Factories\About\AboutFactory::new()->create();
    }
}
