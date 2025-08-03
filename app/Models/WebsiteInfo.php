<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'site_title',
        'site_description',
        'logo_black',
        'logo_white',
        'favicon',
        'phone',
        'email',
        'address',
        'country',
        'city',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
        'youtube_url',
        'behance_url',
        'pinterest_url',
        'footer_text',
        'copyright_text',
    ];

    /**
     * Get social media links as array
     */
    public function getSocialLinksAttribute()
    {
        return [
            'facebook'  => $this->facebook_url,
            'twitter'   => $this->twitter_url,
            'instagram' => $this->instagram_url,
            'linkedin'  => $this->linkedin_url,
            'youtube'   => $this->youtube_url,
            'behance'   => $this->behance_url,
            'pinterest' => $this->pinterest_url,
        ];
    }
}