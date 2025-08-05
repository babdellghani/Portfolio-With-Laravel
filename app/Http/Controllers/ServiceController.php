<?php
namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource Admin (Admin only)
     */
    public function index()
    {
        $this->requireAdmin();

        $services = Service::latest()->get();

        return view('admin.service.index', compact('services'));
    }

    /**
     * Display a listing of the resource (Public)
     */
    public function home()
    {
        $services = Service::latest()->paginate(10);
        return view('frontend.pages.services', compact('services'));
    }

    /**
     * Store a newly created resource in storage (Admin only)
     */
    public function store(Request $request)
    {
        $this->requireAdmin();
        $service = $request->validate([
            'title'             => 'required',
            'slug'              => 'required|unique:services',
            'icon'              => 'required',
            'image'             => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'short_description' => 'required|max:255|string',
            'description'       => 'required|string',
        ]);

        $service['slug'] = Str::slug($service['slug']);

        if ($request->hasFile('image')) {
            $service['image'] = $request->file('image')->store('services', 'public');
        }

        if ($request->hasFile('icon')) {
            $service['icon'] = $request->file('icon')->store('services', 'public');
        }

        Service::create($service);

        return back()->with([
            'message'    => 'Service created successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource (Admin only)
     */
    public function edit(Service $service)
    {
        $this->requireAdmin();

        return view('admin.service.edit', compact('service'));
    }

    /**
     * Display the specified resource details (Public)
     */
    public function details($slug)
    {
        $service = Service::where('slug', $slug)->firstOrFail();
        return view('frontend.pages.services_details', compact('service'));
    }

    /**
     * Update the specified resource in storage (Admin only)
     */
    public function update(Request $request, Service $service)
    {
        $this->requireAdmin();
        $serviceNew = $request->validate([
            'title'             => 'required',
            'slug'              => 'required|unique:services,slug,' . $service->id,
            'icon'              => 'required',
            'image'             => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'short_description' => 'required|max:255|string',
            'description'       => 'required|string',
        ]);

        $serviceNew['slug'] = Str::slug($serviceNew['slug']);

        if ($request->hasFile('image')) {
            Storage::delete('public/' . $service->image);
            $serviceNew['image'] = $request->file('image')->store('services', 'public');
        }

        if ($request->hasFile('icon')) {
            Storage::delete('public/' . $service->icon);
            $serviceNew['icon'] = $request->file('icon')->store('services', 'public');
        }

        $service->update($serviceNew);

        return redirect()->route('service')->with([
            'message'    => 'Service updated successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage (Admin only)
     */
    public function destroy(Service $service)
    {
        $this->requireAdmin();

        Storage::delete('public/' . $service->image);
        $service->delete();

        return back()->with([
            'message'    => 'Service deleted successfully',
            'alert-type' => 'success',
        ]);
    }
}
