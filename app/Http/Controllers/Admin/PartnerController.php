<?php
namespace App\Http\Controllers\Admin;

use App\Models\Partner;
use Illuminate\Http\Request;
use Database\Seeders\PartnerSeeder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource (Admin only)
     */
    public function index()
    {
        $this->requireAdmin();

        $partners = Partner::ordered()->get();

        if ($partners->count() === 0) {
            (new PartnerSeeder())->run();
            $partners = Partner::ordered()->get();
        }

        return view('admin.partner.partner', compact('partners'));
    }

    /**
     * Store a newly created resource in storage (Admin only)
     */
    public function store(Request $request)
    {
        $this->requireAdmin();
        $partner = $request->validate([
            'name'        => 'required|string|max:255',
            'light_logo'  => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'dark_logo'   => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'website_url' => 'nullable|url',
            'order'       => 'nullable|integer|min:0',
        ]);

        // Handle status checkbox
        $partner['status'] = $request->has('status') ? true : false;

        if ($request->hasFile('light_logo')) {
            $partner['light_logo'] = $request->file('light_logo')->store('partners', 'public');
        }

        if ($request->hasFile('dark_logo')) {
            $partner['dark_logo'] = $request->file('dark_logo')->store('partners', 'public');
        }

        Partner::create($partner);

        return back()->with([
            'message'    => 'Partner created successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource (Admin only)
     */
    public function edit(Partner $partner)
    {
        $this->requireAdmin();

        return view('admin.partner.partner-edit', compact('partner'));
    }

    /**
     * Update the specified resource in storage (Admin only)
     */
    public function update(Request $request, Partner $partner)
    {
        $this->requireAdmin();
        $partnerNew = $request->validate([
            'name'        => 'required|string|max:255',
            'light_logo'  => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'dark_logo'   => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'website_url' => 'nullable|url',
            'order'       => 'nullable|integer|min:0',
        ]);

        // Handle status checkbox
        $partnerNew['status'] = $request->has('status') ? true : false;

        if ($request->hasFile('light_logo')) {
            if ($partner->light_logo && ! str_starts_with($partner->light_logo, 'defaults_images/')) {
                Storage::delete('public/' . $partner->light_logo);
            }
            $partnerNew['light_logo'] = $request->file('light_logo')->store('partners', 'public');
        }

        if ($request->hasFile('dark_logo')) {
            if ($partner->dark_logo && ! str_starts_with($partner->dark_logo, 'defaults_images/')) {
                Storage::delete('public/' . $partner->dark_logo);
            }
            $partnerNew['dark_logo'] = $request->file('dark_logo')->store('partners', 'public');
        }

        $partner->update($partnerNew);

        return redirect()->route('partner')->with([
            'message'    => 'Partner updated successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage (Admin only)
     */
    public function destroy(Partner $partner)
    {
        $this->requireAdmin();

        if ($partner->light_logo && ! str_starts_with($partner->light_logo, 'defaults_images/')) {
            Storage::delete('public/' . $partner->light_logo);
        }

        if ($partner->dark_logo && ! str_starts_with($partner->dark_logo, 'defaults_images/')) {
            Storage::delete('public/' . $partner->dark_logo);
        }

        $partner->delete();

        return back()->with([
            'message'    => 'Partner deleted successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Toggle partner status (Admin only)
     */
    public function status(Partner $partner)
    {
        $this->requireAdmin();

        $partner->status = ! $partner->status;
        $partner->save();

        return back()->with([
            'message'    => 'Partner status updated successfully',
            'alert-type' => 'success',
        ]);
    }
}