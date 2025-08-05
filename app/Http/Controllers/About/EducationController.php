<?php
namespace App\Http\Controllers\About;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->requireAdmin();

        $educations = Education::latest()->get();

        return view('admin.about.education', compact('educations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->requireAdmin();

        $request->validate([
            'name'        => 'required',
            'description' => 'required|max:255|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date',
        ]);

        Education::create($request->all());

        return back()->with([
            'message'    => 'Education created successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Education $education)
    {
        $this->requireAdmin();

        return view('admin.about.education-edit', compact('education'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Education $education)
    {
        $this->requireAdmin();

        $request->validate([
            'name'        => 'required',
            'description' => 'required|max:255|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date',
        ]);

        $education->update($request->all());

        $education->save();

        return redirect()->route('education')->with([
            'message'    => 'Education updated successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Education $education)
    {
        $this->requireAdmin();

        $education->delete();

        return back()->with([
            'message'    => 'Education deleted successfully',
            'alert-type' => 'success',
        ]);
    }
}
