<?php
namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user
        $adminUser = User::where('role', 'admin')->first();

        if (! $adminUser) {
            throw new \Exception('Admin user not found. Make sure UserSeeder runs before TagSeeder.');
        }

        // Create specific tags
        $tags = [
            'PHP', 'Laravel', 'JavaScript', 'React', 'Vue.js', 'Node.js',
            'CSS', 'HTML', 'Bootstrap', 'Tailwind CSS', 'MySQL', 'PostgreSQL',
            'API', 'REST API', 'GraphQL', 'Docker', 'Git', 'GitHub',
            'Frontend', 'Backend', 'Full-stack', 'Mobile', 'Web Development',
            'UI Design', 'UX Design', 'Responsive Design', 'SEO', 'Marketing',
            'E-commerce', 'Tutorial', 'Tips & Tricks', 'Guide', 'Best Practices',
            'Code Review', 'Performance', 'Security', 'Testing', 'Deployment',
        ];

        foreach ($tags as $tagName) {
            Tag::factory()->create([
                'name'    => $tagName,
                'slug'    => Str::slug($tagName),
                'status'  => true,
                'user_id' => $adminUser->id,
            ]);
        }

        // Create additional random tags using factory
        Tag::factory(10)->create([
            'user_id' => $adminUser->id,
        ]);
    }
}
