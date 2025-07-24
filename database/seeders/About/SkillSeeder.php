<?php

namespace Database\Seeders\About;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Database\Factories\About\SkillFactory::new()->count(8)->create();
    }
}
