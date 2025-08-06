<?php
namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Seeder;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create specific technologies using factory with custom data
        $technologies = [
            ['name' => 'Adobe XD', 'light' => 'xd_light.png', 'dark' => 'xd.png', 'order' => 1],
            ['name' => 'Sketch', 'light' => 'skeatch_light.png', 'dark' => 'skeatch.png', 'order' => 2],
            ['name' => 'Illustrator', 'light' => 'illustrator_light.png', 'dark' => 'illustrator.png', 'order' => 3],
            ['name' => 'Hotjar', 'light' => 'hotjar_light.png', 'dark' => 'hotjar.png', 'order' => 4],
            ['name' => 'InVision', 'light' => 'invision_light.png', 'dark' => 'invision.png', 'order' => 5],
            ['name' => 'Photoshop', 'light' => 'photoshop_light.png', 'dark' => 'photoshop.png', 'order' => 6],
            ['name' => 'Figma', 'light' => 'figma_light.png', 'dark' => 'figma.png', 'order' => 7],
        ];

        foreach ($technologies as $tech) {
            Technology::factory()->create([
                'name'       => $tech['name'],
                'light_icon' => 'defaults_images/icons/' . $tech['light'],
                'dark_icon'  => 'defaults_images/icons/' . $tech['dark'],
                'status'     => true,
                'order'      => $tech['order'],
            ]);
        }

        // Create additional random technologies using factory
        Technology::factory(5)->create();
    }
}
