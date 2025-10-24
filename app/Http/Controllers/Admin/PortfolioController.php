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
     * Display a listing of the resource.
     */
    public function index()
    {
        $portfolios = Portfolio::with([])
            ->orderBy('ordering', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.portfolios.index', compact('portfolios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Portfolio::getCategories();
        return view('admin.portfolios.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'client_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'completion_date' => 'nullable|date',
            'project_value' => 'nullable|numeric|min:0|max:9999999999999',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120', // 5MB max
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'ordering' => 'nullable|integer|min:0',
        ], [
            'project_value.max' => 'Nilai proyek tidak boleh melebihi Rp 9.999.999.999.999 (9,9 Triliun)',
            'project_value.numeric' => 'Nilai proyek harus berupa angka',
            'project_value.min' => 'Nilai proyek tidak boleh kurang dari 0',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('portfolios', $imageName, 'public');
            $validated['image_path'] = $imagePath;
        }

        // Set default values
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active') ? true : true; // Default to active
        $validated['ordering'] = $validated['ordering'] ?? 0;

        Portfolio::create($validated);

        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Portfolio berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Portfolio $portfolio)
    {
        return view('admin.portfolios.show', compact('portfolio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Portfolio $portfolio)
    {
        $categories = Portfolio::getCategories();
        return view('admin.portfolios.edit', compact('portfolio', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Portfolio $portfolio)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'client_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'completion_date' => 'nullable|date',
            'project_value' => 'nullable|numeric|min:0|max:9999999999999',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120', // 5MB max
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'ordering' => 'nullable|integer|min:0',
        ], [
            'project_value.max' => 'Nilai proyek tidak boleh melebihi Rp 9.999.999.999.999 (9,9 Triliun)',
            'project_value.numeric' => 'Nilai proyek harus berupa angka',
            'project_value.min' => 'Nilai proyek tidak boleh kurang dari 0',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($portfolio->image_path && Storage::disk('public')->exists($portfolio->image_path)) {
                Storage::disk('public')->delete($portfolio->image_path);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('portfolios', $imageName, 'public');
            $validated['image_path'] = $imagePath;
        }

        // Set boolean values
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active') ? true : true;
        $validated['ordering'] = $validated['ordering'] ?? $portfolio->ordering;

        $portfolio->update($validated);

        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Portfolio berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Portfolio $portfolio)
    {
        try {
            // Delete image if exists
            if ($portfolio->image_path && Storage::disk('public')->exists($portfolio->image_path)) {
                Storage::disk('public')->delete($portfolio->image_path);
            }

            $portfolio->delete();

            return redirect()->route('admin.portfolios.index')
                ->with('success', 'Portfolio berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.portfolios.index')
                ->with('error', 'Gagal menghapus portfolio: ' . $e->getMessage());
        }
    }
}
