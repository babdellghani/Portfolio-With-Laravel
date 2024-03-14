<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skill = Skill::latest()->first();

        return view('admin.about.skill', compact('skill'));
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skill $skill)
    {
        $request->validate([
            'name' => 'required',
            'value' => 'required|min:0|max:100|numeric',
        ]);

        $skill->update($request->all());

        return back()->with([
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
