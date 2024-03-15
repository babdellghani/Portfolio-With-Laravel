<?php

namespace App\Http\Controllers\About;

use App\Models\Skill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills = Skill::latest()->get();

        return view('admin.about.skill', compact('skills'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'value' => 'required|min:0|max:100|numeric',
        ]);

        Skill::create($request->all());

        return back()->with([
            'message' => 'Skill created successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill)
    {
        return view('admin.about.skill-edit', compact('skill'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skill $skill)
    {
        $request->validate([
            'name' => 'required',
            'value' => 'required|min:0|max:100|numeric',
        ]);

        $skill->update($request->all());

        return redirect()->route('skill')->with([
            'message' => 'Skill updated successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        $skill->delete();

        return back()->with([
            'message' => 'Skill deleted successfully',
            'alert-type' => 'success',
        ]);
    }
}
