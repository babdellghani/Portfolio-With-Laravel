<?php
namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create specific partners using factory with custom data
        $partners = [
            ['name' => 'Google', 'light' => 'partner_light01.png', 'dark' => 'partner_01.png', 'order' => 1],
            ['name' => 'Microsoft', 'light' => 'partner_light02.png', 'dark' => 'partner_02.png', 'order' => 2],
            ['name' => 'Amazon', 'light' => 'partner_light03.png', 'dark' => 'partner_03.png', 'order' => 3],
            ['name' => 'Apple', 'light' => 'partner_light04.png', 'dark' => 'partner_04.png', 'order' => 4],
            ['name' => 'Meta', 'light' => 'partner_light05.png', 'dark' => 'partner_05.png', 'order' => 5],
            ['name' => 'Netflix', 'light' => 'partner_light06.png', 'dark' => 'partner_06.png', 'order' => 6],
        ];

        foreach ($partners as $partner) {
            Partner::factory()->create([
                'name'        => $partner['name'],
                'light_logo'  => 'defaults_images/icons/' . $partner['light'],
                'dark_logo'   => 'defaults_images/icons/' . $partner['dark'],
                'website_url' => 'https://www.' . strtolower($partner['name']) . '.com',
                'status'      => true,
                'order'       => $partner['order'],
            ]);
        }

        // Create additional random partners using factory
        Partner::factory(4)->create();
    }
}
