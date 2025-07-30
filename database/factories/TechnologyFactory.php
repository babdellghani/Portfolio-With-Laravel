<?php
namespace Database\Factories;

use App\Models\Technology;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Technology>
 */
class TechnologyFactory extends Factory
{
    protected $model = Technology::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $technologies = [
            ['name' => 'Adobe XD', 'light' => 'xd_light.png', 'dark' => 'xd.png'],
            ['name' => 'Sketch', 'light' => 'skeatch_light.png', 'dark' => 'skeatch.png'],
            ['name' => 'Illustrator', 'light' => 'illustrator_light.png', 'dark' => 'illustrator.png'],
            ['name' => 'Hotjar', 'light' => 'hotjar_light.png', 'dark' => 'hotjar.png'],
            ['name' => 'InVision', 'light' => 'invision_light.png', 'dark' => 'invision.png'],
            ['name' => 'Photoshop', 'light' => 'photoshop_light.png', 'dark' => 'photoshop.png'],
            ['name' => 'Figma', 'light' => 'figma_light.png', 'dark' => 'figma.png'],
        ];

        $tech = $this->faker->randomElement($technologies);

        return [
            'name'       => $tech['name'],
            'light_icon' => 'defaults_images/icons/' . $tech['light'],
            'dark_icon'  => 'defaults_images/icons/' . $tech['dark'],
            'status'     => true,
            'order'      => $this->faker->numberBetween(1, 10),
        ];
    }
}
