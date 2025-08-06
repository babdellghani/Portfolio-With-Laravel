<?php
namespace Database\Factories;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Partner>
 */
class PartnerFactory extends Factory
{
    protected $model = Partner::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $additionalPartners
        = [
            ['name' => 'Google', 'light' => 'partner_light01.png', 'dark' => 'partner_01.png'],
            ['name' => 'Microsoft', 'light' => 'partner_light02.png', 'dark' => 'partner_02.png'],
            ['name' => 'Amazon', 'light' => 'partner_light03.png', 'dark' => 'partner_03.png'],
            ['name' => 'Apple', 'light' => 'partner_light04.png', 'dark' => 'partner_04.png'],
            ['name' => 'Meta', 'light' => 'partner_light05.png', 'dark' => 'partner_05.png'],
            ['name' => 'Netflix', 'light' => 'partner_light06.png', 'dark' => 'partner_06.png'],
        ];

        $partner = $this->faker->randomElement($additionalPartners);

        return [
            'name'        => $partner['name'] . ' Corp',
            'light_logo'  => 'defaults_images/icons/' . $partner['light'],
            'dark_logo'   => 'defaults_images/icons/' . $partner['dark'],
            'website_url' => 'https://www.' . strtolower($partner['name']) . '-corp.com',
            'status'      => $this->faker->boolean(85), // 85% chance of being active
            'order'       => $this->faker->numberBetween(7, 20),
        ];
    }
}
