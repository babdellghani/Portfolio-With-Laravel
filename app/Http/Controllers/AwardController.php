<?php

namespace App\Http\Controllers;

use App\Models\Award;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Colors\Rgb\Channels\Red;

class AwardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $awards = Award::latest()->get();;

        return view('admin.about.award', compact('awards'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'year' => 'required|min:1900|max:' . date('Y') . '|numeric',
            'description' => 'required|max:255|string',
        ]);

        Award::create($request->all());

        return back()->with([
            'message' => 'Award created successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Award $award)
    {
        return view('admin.about.award-edit', compact('award'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Award $award)
    {
        $request->validate([
            'title' => 'required',
            'year' => 'required|min:1900|max:' . date('Y') . '|numeric',
            'description' => 'required|max:255|string',
        ]);

        $award->update($request->all());

        $award->save();

        return redirect()->route('award')->with([
            'message' => 'Award updated successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Award $award)
    {
        $award->delete();

        return back()->with([
            'message' => 'Award deleted successfully',
            'alert-type' => 'success',
        ]);
    }
}
