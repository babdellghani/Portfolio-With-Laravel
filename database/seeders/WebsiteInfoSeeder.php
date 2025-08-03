<?php
namespace Database\Seeders;

use App\Models\WebsiteInfo;
use Illuminate\Database\Seeder;

class WebsiteInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create website info if it doesn't exist
        if (WebsiteInfo::count() === 0) {
            WebsiteInfo::factory()->create();
        }
    }
}
