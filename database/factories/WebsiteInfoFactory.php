<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WebsiteInfo>
 */
class WebsiteInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'site_name'        => 'Ab. Dev Portfolio',
            'site_title'       => 'Full Stack Developer & UI/UX Designer',
            'site_description' => 'Professional web developer with expertise in Laravel, React, and modern web technologies. Creating digital solutions that make a difference.',
            'logo_black'       => 'defaults_images/logo_black.png',
            'logo_white'       => 'defaults_images/logo_white.png',
            'favicon'          => 'defaults_images/favicon.ico',
            'phone'            => '+1 (555) 123-4567',
            'email'            => 'hello@abdev.com',
            'address'          => '123 Tech Street, Innovation District',
            'country'          => 'United States',
            'city'             => 'San Francisco, CA 94105',
            'facebook_url'     => 'https://facebook.com/abdev',
            'twitter_url'      => 'https://twitter.com/abdev',
            'instagram_url'    => 'https://instagram.com/abdev',
            'linkedin_url'     => 'https://linkedin.com/in/abdev',
            'youtube_url'      => 'https://youtube.com/@abdev',
            'behance_url'      => 'https://behance.net/abdev',
            'pinterest_url'    => 'https://pinterest.com/abdev',
            'footer_text'      => 'Passionate about creating innovative web solutions and helping businesses grow through technology.',
            'copyright_text'   => 'Copyright © Ab. Dev 2025 All rights reserved',
        ];
    }
}