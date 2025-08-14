<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource (Admin only)
     */
    public function index()
    {
        $this->requireAdmin();

        $portfolios = Portfolio::latest()->get();
        return view('admin.portfolio.index', compact('portfolios'));
    }

    /**
     * Show the form for creating a new resource (Public)
     */
    public function home()
    {
        $portfolios = Portfolio::latest()->where('status', 1)->get();
        return view('frontend.pages.portfolio', compact('portfolios'));
    }

    /**
     * Display portfolio details (Public)
     */
    public function details($slug)
    {
        $portfolio = Portfolio::where('slug', $slug)->firstOrFail();
        return view('frontend.pages.portfolio_details', compact('portfolio'));
    }

    /**
     * Store a newly created resource in storage (Admin only)
     */
    public function store(Request $request)
    {
        $this->requireAdmin();
        $portfolio = $request->validate([
            'title'             => 'required',
            'slug'              => 'required|unique:portfolios',
            'image'             => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'short_description' => 'required|max:255|string',
            'description'       => 'required|string',
            'status'            => 'nullable|in:0,1|bool',
            'category'          => 'required|string',
            'date'              => 'nullable|date',
            'location'          => 'nullable|string',
            'client'            => 'nullable|string',
            'link'              => 'nullable|string|url',
        ]);

        $portfolio['status'] = $request->input('status', 0);
        $portfolio['slug']   = Str::slug($portfolio['slug']);

        // Convert comma-separated category string to array
        if ($request->has('category')) {
            $categories            = array_map('trim', explode(',', $request->category));
            $portfolio['category'] = array_filter($categories); // Remove empty values
        }

        if ($request->hasFile('image')) {
            $portfolio['image'] = $request->file('image')->store('portfolio', 'public');
        }

        Portfolio::create($portfolio);

        return redirect()->back()->with([
            'message'    => 'Portfolio created successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource (Admin only)
     */
    public function edit(Portfolio $portfolio)
    {
        $this->requireAdmin();

        return view('admin.portfolio.edit', compact('portfolio'));
    }

    /**
     * Update the specified resource in storage (Admin only)
     */
    public function update(Request $request, Portfolio $portfolio)
    {
        $this->requireAdmin();
        $portfolioNew = $request->validate([
            'title'             => 'required',
            'slug'              => 'required|unique:portfolios,slug,' . $portfolio->id,
            'image'             => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'short_description' => 'required|max:255|string',
            'description'       => 'required|string',
            'status'            => 'nullable|in:0,1|bool',
            'category'          => 'required|string',
            'date'              => 'nullable|date',
            'location'          => 'nullable|string',
            'client'            => 'nullable|string',
            'link'              => 'nullable|string|url',
        ]);

        $portfolioNew['status'] = $request->input('status', 0);
        $portfolioNew['slug']   = Str::slug($portfolioNew['slug']);

        // Convert comma-separated category string to array
        if ($request->has('category')) {
            $categories               = array_map('trim', explode(',', $request->category));
            $portfolioNew['category'] = array_filter($categories); // Remove empty values
        }

        if ($request->hasFile('image')) {
            Storage::delete('public/' . $portfolio->image);
            $portfolioNew['image'] = $request->file('image')->store('portfolio', 'public');
        }

        $portfolio->update($portfolioNew);

        return redirect()->route('portfolio')->with(['message' => 'Portfolio updated successfully', 'alert-type' => 'success']);
    }

    /**
     * Update the status of the specified resource in storage (Admin only)
     */
    public function status(Request $request, Portfolio $portfolio)
    {
        $this->requireAdmin();

        $request->validate([
            'status' => 'nullable|in:0,1|bool',
        ]);

        if ($portfolio->status == 1) {
            $portfolio->update(['status' => 0]);
        } else {
            $portfolio->update(['status' => 1]);
        }

        return redirect()->back()->with([
            'message'    => 'Portfolio status updated successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage (Admin only)
     */
    public function destroy(Portfolio $portfolio)
    {
        $this->requireAdmin();

        Storage::delete('public/' . $portfolio->image);
        $portfolio->delete();

        return redirect()->back()->with([
            'message'    => 'Portfolio deleted successfully',
            'alert-type' => 'success',
        ]);
    }
}