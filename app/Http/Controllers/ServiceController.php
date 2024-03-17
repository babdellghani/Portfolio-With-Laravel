<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::latest()->get();

        return view('admin.service.index', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $service = $request->validate([
            'title' => 'required',
            'slug' => 'required',
            'icon' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'short_description' => 'required|max:255|string',
            'description' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $service['image'] = $request->file('image')->store('services', 'public');
        }

        Service::create($service);

        return back()->with([
            'message' => 'Service created successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('admin.service.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $serviceNew = $request->validate([
            'title' => 'required',
            'slug' => 'required',
            'icon' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'short_description' => 'required|max:255|string',
            'description' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            Storage::delete('public/' . $service->image);
            $serviceNew['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($serviceNew);

        return back()->with([
            'message' => 'Service updated successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        Storage::delete('public/' . $service->image);
        $service->delete();

        return back()->with([
            'message' => 'Service deleted successfully',
            'alert-type' => 'success',
        ]);
    }
}
