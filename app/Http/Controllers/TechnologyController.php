<?php
namespace App\Http\Controllers;

use App\Models\Technology;
use Database\Seeders\TechnologySeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TechnologyController extends Controller
{
    /**
     * Display a listing of the resource (Admin only)
     */
    public function index()
    {
        $this->requireAdmin();

        $technologies = Technology::ordered()->get();

        if ($technologies->count() === 0) {
            (new TechnologySeeder())->run();
            $technologies = Technology::ordered()->get();
        }

        return view('admin.technology.technology', compact('technologies'));
    }

    /**
     * Store a newly created resource in storage (Admin only)
     */
    public function store(Request $request)
    {
        $this->requireAdmin();
        $technology = $request->validate([
            'name'       => 'required|string|max:255',
            'light_icon' => 'required|image|mimes:png,jpg,jpeg,svg|max:2048',
            'dark_icon'  => 'required|image|mimes:png,jpg,jpeg,svg|max:2048',
            'type'       => 'required|in:language,framework,tool',
            'order'      => 'nullable|integer|min:0',
        ]);

        // Handle status checkbox
        $technology['status'] = $request->has('status') ? true : false;

        if ($request->hasFile('light_icon')) {
            $technology['light_icon'] = $request->file('light_icon')->store('technologies', 'public');
        }

        if ($request->hasFile('dark_icon')) {
            $technology['dark_icon'] = $request->file('dark_icon')->store('technologies', 'public');
        }

        Technology::create($technology);

        return back()->with([
            'message'    => 'Technology created successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource (Admin only)
     */
    public function edit(Technology $technology)
    {
        $this->requireAdmin();

        return view('admin.technology.technology-edit', compact('technology'));
    }

    /**
     * Update the specified resource in storage (Admin only)
     */
    public function update(Request $request, Technology $technology)
    {
        $this->requireAdmin();
        $technologyNew = $request->validate([
            'name'       => 'required|string|max:255',
            'light_icon' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'dark_icon'  => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'type'       => 'required|in:language,framework,tool',
            'order'      => 'nullable|integer|min:0',
        ]);

        // Handle status checkbox
        $technologyNew['status'] = $request->has('status') ? true : false;

        if ($request->hasFile('light_icon')) {
            if ($technology->light_icon && ! str_starts_with($technology->light_icon, 'defaults_images/')) {
                Storage::delete('public/' . $technology->light_icon);
            }
            $technologyNew['light_icon'] = $request->file('light_icon')->store('technologies', 'public');
        }

        if ($request->hasFile('dark_icon')) {
            if ($technology->dark_icon && ! str_starts_with($technology->dark_icon, 'defaults_images/')) {
                Storage::delete('public/' . $technology->dark_icon);
            }
            $technologyNew['dark_icon'] = $request->file('dark_icon')->store('technologies', 'public');
        }

        $technology->update($technologyNew);

        return redirect()->route('technology')->with([
            'message'    => 'Technology updated successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage (Admin only)
     */
    public function destroy(Technology $technology)
    {
        $this->requireAdmin();

        if ($technology->light_icon && ! str_starts_with($technology->light_icon, 'defaults_images/')) {
            Storage::delete('public/' . $technology->light_icon);
        }

        if ($technology->dark_icon && ! str_starts_with($technology->dark_icon, 'defaults_images/')) {
            Storage::delete('public/' . $technology->dark_icon);
        }

        $technology->delete();

        return back()->with([
            'message'    => 'Technology deleted successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Toggle technology status (Admin only)
     */
    public function status(Technology $technology)
    {
        $this->requireAdmin();

        $technology->status = ! $technology->status;
        $technology->save();

        return back()->with([
            'message'    => 'Technology status updated successfully',
            'alert-type' => 'success',
        ]);
    }
}
