<?php
namespace App\Http\Controllers\About;

use App\Http\Controllers\Controller;
use App\Models\Award;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AwardController extends Controller
{
    /**
     * Display a listing of the resource (Admin only)
     */
    public function index()
    {
        $this->requireAdmin();

        $awards = Award::latest()->get();

        return view('admin.about.award', compact('awards'));
    }

    /**
     * Store a newly created resource in storage (Admin only)
     */
    public function store(Request $request)
    {
        $this->requireAdmin();
        $award = $request->validate([
            'title'       => 'required',
            'year'        => 'required|min:1900|max:' . date('Y') . '|numeric',
            'description' => 'required|max:255|string',
            'image'       => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $award['image'] = $request->file('image')->store('award', 'public');
        }

        Award::create($award);

        return back()->with([
            'message'    => 'Award created successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource (Admin only)
     */
    public function edit(Award $award)
    {
        $this->requireAdmin();

        return view('admin.about.award-edit', compact('award'));
    }

    /**
     * Update the specified resource in storage (Admin only)
     */
    public function update(Request $request, Award $award)
    {
        $this->requireAdmin();

        $awardNew = $request->validate([
            'title'       => 'required',
            'year'        => 'required|min:1900|max:' . date('Y') . '|numeric',
            'description' => 'required|max:255|string',
            'image'       => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            Storage::delete('public/' . $award->image);
            $awardNew['image'] = $request->file('image')->store('award', 'public');
        }

        $award->update($awardNew);

        $award->save();

        return redirect()->route('award')->with([
            'message'    => 'Award updated successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage (Admin only)
     */
    public function destroy(Award $award)
    {
        $this->requireAdmin();

        Storage::delete('public/' . $award->image);
        $award->delete();

        return back()->with([
            'message'    => 'Award deleted successfully',
            'alert-type' => 'success',
        ]);
    }
}
