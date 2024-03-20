<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $portfolios = Portfolio::latest()->get();

        return view('admin.portfolio.index', compact('portfolios'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $portfolio = $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:portfolios',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'short_description' => 'required|max:255|string',
            'description' => 'required|string',
            'status' => 'required|in:0,1|bool',
            'category' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $portfolio['image'] = $request->file('image')->store('portfolio', 'public');
        }

        Portfolio::create($portfolio);

        return redirect()->back()->with('success', 'Portfolio created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Portfolio $portfolio)
    {
        return view('admin.portfolio.edit', compact('portfolio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Portfolio $portfolio)
    {
        $portfolioNew = $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:portfolios,slug,' . $portfolio->id,
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'short_description' => 'required|max:255|string',
            'description' => 'required|string',
            'status' => 'required|in:0,1|bool',
            'category' => 'required',
        ]);

        if ($request->hasFile('image')) {
            Storage::delete('public/' . $portfolio->image);
            $portfolioNew['image'] = $request->file('image')->store('portfolio', 'public');
        }

        $portfolio->update($portfolioNew);

        return redirect()->route('portfolio')->with('success', 'Portfolio updated successfully');
    }

    /**
     * Update the status of the specified resource in storage.
     */
    public function status(Request $request, Portfolio $portfolio)
    {
        $request->validate([
            'status' => 'required|in:0,1|bool',
        ]);
        $portfolio->update(['status' => $request->input('status')]);

        return redirect()->back()->with('success', 'Portfolio status updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Portfolio $portfolio)
    {
        Storage::delete('public/' . $portfolio->image);
        $portfolio->delete();

        return redirect()->back()->with('success', 'Portfolio deleted successfully');
    }
}
