<?php
namespace App\Http\Controllers;

use App\Models\WebsiteInfo;
use Database\Seeders\WebsiteInfoSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebsiteInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $websiteInfo = WebsiteInfo::first();

        if (! $websiteInfo) {
            (new WebsiteInfoSeeder())->run();
            $websiteInfo = WebsiteInfo::first();
        }

        return view('admin.website-info.index', compact('websiteInfo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WebsiteInfo $websiteInfo)
    {
        $validated = $request->validate([
            'site_name'        => 'required|string|max:255',
            'site_title'       => 'nullable|string|max:255',
            'site_description' => 'nullable|string',
            'logo_black'       => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'logo_white'       => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'favicon'          => 'nullable|image|mimes:ico,png|max:1024',
            'phone'            => 'nullable|string|max:255',
            'email'            => 'nullable|email|max:255',
            'address'          => 'nullable|string',
            'country'          => 'nullable|string|max:255',
            'city'             => 'nullable|string|max:255',
            'facebook_url'     => 'nullable|url',
            'twitter_url'      => 'nullable|url',
            'instagram_url'    => 'nullable|url',
            'linkedin_url'     => 'nullable|url',
            'youtube_url'      => 'nullable|url',
            'behance_url'      => 'nullable|url',
            'pinterest_url'    => 'nullable|url',
            'footer_text'      => 'nullable|string',
            'copyright_text'   => 'nullable|string|max:255',
        ]);


        // Handle logo uploads
        if ($request->hasFile('logo_black')) {
            if ($websiteInfo->logo_black && ! str_starts_with($websiteInfo->logo_black, 'defaults_images/')) {
                Storage::delete('public/' . $websiteInfo->logo_black);
            }
            $validated['logo_black'] = $request->file('logo_black')->store('website', 'public');
        }

        if ($request->hasFile('logo_white')) {
            if ($websiteInfo->logo_white && ! str_starts_with($websiteInfo->logo_white, 'defaults_images/')) {
                Storage::delete('public/' . $websiteInfo->logo_white);
            }
            $validated['logo_white'] = $request->file('logo_white')->store('website', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($websiteInfo->favicon && ! str_starts_with($websiteInfo->favicon, 'defaults_images/')) {
                Storage::delete('public/' . $websiteInfo->favicon);
            }
            $validated['favicon'] = $request->file('favicon')->store('website', 'public');
        }

        $websiteInfo->update($validated);

        return back()->with([
            'message'    => 'Website information updated successfully',
            'alert-type' => 'success',
        ]);
    }

}