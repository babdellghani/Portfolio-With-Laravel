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
            'contact_map'      => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d96811.54759587669!2d-74.01263924803828!3d40.6880494567041!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25bae694479a3%3A0xb9949385da52e69e!2sBarclays%20Center!5e0!3m2!1sen!2sbd!4v1636195194646" allowfullscreen loading="lazy"></iframe>',
            'footer_text'      => 'Passionate about creating innovative web solutions and helping businesses grow through technology.',
            'copyright_text'   => 'Copyright © Ab. Dev 2025 All rights reserved',
        ];
    }
}