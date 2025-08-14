<?php
namespace App\Http\Controllers\Admin;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Database\Seeders\TestimonialSeeder;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource (Admin only)
     */
    public function index()
    {
        $this->requireAdmin();

        $testimonials = Testimonial::latest()->get();

        if ($testimonials->count() === 0) {
            (new TestimonialSeeder())->run();
            $testimonials = Testimonial::latest()->get();
        }

        return view('admin.testimonial.testimonial', compact('testimonials'));
    }

    /**
     * Store a newly created resource in storage (Admin only)
     */
    public function store(Request $request)
    {
        $this->requireAdmin();
        $testimonial = $request->validate([
            'name'    => 'required|string|max:255',
            'title'   => 'nullable|string|max:255',
            'message' => 'required|string',
            'image'   => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'rating'  => 'required|integer|min:1|max:5',
        ]);

        // Handle status checkbox - default to true if not provided
        $testimonial['status'] = $request->has('status') ? true : false;

        if ($request->hasFile('image')) {
            $testimonial['image'] = $request->file('image')->store('testimonials', 'public');
        }

        Testimonial::create($testimonial);

        return back()->with([
            'message'    => 'Testimonial created successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource (Admin only)
     */
    public function edit(Testimonial $testimonial)
    {
        $this->requireAdmin();

        return view('admin.testimonial.testimonial-edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage (Admin only)
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $this->requireAdmin();
        $testimonialNew = $request->validate([
            'name'    => 'required|string|max:255',
            'title'   => 'nullable|string|max:255',
            'message' => 'required|string',
            'image'   => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'rating'  => 'required|integer|min:1|max:5',
        ]);

        // Handle status checkbox - default to false if not provided
        $testimonialNew['status'] = $request->has('status') ? true : false;

        if ($request->hasFile('image')) {
            if ($testimonial->image && ! str_starts_with($testimonial->image, 'defaults_images/')) {
                Storage::delete('public/' . $testimonial->image);
            }
            $testimonialNew['image'] = $request->file('image')->store('testimonials', 'public');
        }

        $testimonial->update($testimonialNew);

        return redirect()->route('testimonial')->with([
            'message'    => 'Testimonial updated successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage (Admin only)
     */
    public function destroy(Testimonial $testimonial)
    {
        $this->requireAdmin();

        if ($testimonial->image && ! str_starts_with($testimonial->image, 'defaults_images/')) {
            Storage::delete('public/' . $testimonial->image);
        }

        $testimonial->delete();

        return back()->with([
            'message'    => 'Testimonial deleted successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Toggle testimonial status (Admin only)
     */
    public function status(Testimonial $testimonial)
    {
        $this->requireAdmin();

        $testimonial->status = ! $testimonial->status;
        $testimonial->save();

        return back()->with([
            'message'    => 'Testimonial status updated successfully',
            'alert-type' => 'success',
        ]);
    }
}