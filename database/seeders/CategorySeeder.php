<?php
namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user
        $adminUser = User::where('role', 'admin')->first();

        if (! $adminUser) {
            throw new \Exception('Admin user not found. Make sure UserSeeder runs before CategorySeeder.');
        }

        // Create specific categories
        $categories = [
            [
                'name'        => 'Web Development',
                'description' => 'Articles about web development, frameworks, and best practices.',
                'image'       => 'defaults_images/category/web-development.jpg',
            ],
            [
                'name'        => 'Mobile Development',
                'description' => 'Mobile app development for iOS and Android platforms.',
                'image'       => 'defaults_images/category/mobile-development.jpg',
            ],
            [
                'name'        => 'UI/UX Design',
                'description' => 'User interface and user experience design principles.',
                'image'       => 'defaults_images/category/ui-ux-design.jpg',
            ],
            [
                'name'        => 'Laravel',
                'description' => 'Laravel PHP framework tutorials and tips.',
                'image'       => 'defaults_images/category/laravel.jpg',
            ],
            [
                'name'        => 'JavaScript',
                'description' => 'JavaScript programming and modern frameworks.',
                'image'       => 'defaults_images/category/javascript.jpg',
            ],
            [
                'name'        => 'Digital Marketing',
                'description' => 'Digital marketing strategies and SEO techniques.',
                'image'       => 'defaults_images/category/digital-marketing.jpg',
            ],
            [
                'name'        => 'Technology',
                'description' => 'Latest technology trends and innovations.',
                'image'       => 'defaults_images/category/technology.jpg',
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::factory()->create([
                'name'        => $categoryData['name'],
                'slug'        => Str::slug($categoryData['name']),
                'description' => $categoryData['description'],
                'image'       => $categoryData['image'],
                'status'      => true,
                'user_id'     => $adminUser->id,
            ]);
        }

        // Create additional random categories using factory
        Category::factory(5)->create([
            'user_id' => $adminUser->id,
        ]);
    }
}
