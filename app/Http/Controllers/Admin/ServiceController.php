<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of services.
     */
    public function index(): View
    {
        $services = Service::orderBy('ordering', 'asc')
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);
        
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new service.
     */
    public function create(): View
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created service.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price_range' => 'nullable|string|max:100',
            'category' => 'required|string|max:100',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'ordering' => 'nullable|integer|min:0',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('services', 'public');
            $validated['image_path'] = $imagePath;
        }

        // Set default ordering if not provided
        if (!isset($validated['ordering'])) {
            $validated['ordering'] = Service::max('ordering') + 1;
        }

        Service::create($validated);

        return redirect()->route('admin.services.index')
                        ->with('success', 'Layanan berhasil ditambahkan.');
    }

    /**
     * Display the specified service.
     */
    public function show(Service $service): View
    {
        $service->load(['inquiries', 'projects']);
        
        return view('admin.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(Service $service): View
    {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified service.
     */
    public function update(Request $request, Service $service): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price_range' => 'nullable|string|max:100',
            'category' => 'required|string|max:100',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'ordering' => 'nullable|integer|min:0',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($service->image_path) {
                Storage::disk('public')->delete($service->image_path);
            }
            
            $imagePath = $request->file('image')->store('services', 'public');
            $validated['image_path'] = $imagePath;
        }

        $service->update($validated);

        return redirect()->route('admin.services.index')
                        ->with('success', 'Layanan berhasil diperbarui.');
    }

    /**
     * Remove the specified service.
     */
    public function destroy(Service $service): RedirectResponse
    {
        // Check if service has inquiries or projects
        if ($service->inquiries()->count() > 0 || $service->projects()->count() > 0) {
            return redirect()->route('admin.services.index')
                           ->with('error', 'Layanan tidak dapat dihapus karena masih memiliki inquiry atau proyek terkait.');
        }

        // Delete image if exists
        if ($service->image_path) {
            Storage::disk('public')->delete($service->image_path);
        }

        $service->delete();

        return redirect()->route('admin.services.index')
                        ->with('success', 'Layanan berhasil dihapus.');
    }

    /**
     * Toggle service status.
     */
    public function toggleStatus(Service $service): RedirectResponse
    {
        $service->update([
            'is_active' => !$service->is_active
        ]);

        $status = $service->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->route('admin.services.index')
                        ->with('success', "Layanan berhasil {$status}.");
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(Service $service): RedirectResponse
    {
        $service->update([
            'is_featured' => !$service->is_featured
        ]);

        $status = $service->is_featured ? 'ditampilkan sebagai unggulan' : 'dihapus dari unggulan';
        
        return redirect()->route('admin.services.index')
                        ->with('success', "Layanan berhasil {$status}.");
    }

    /**
     * Bulk update ordering.
     */
    public function updateOrdering(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'services' => 'required|array',
            'services.*.id' => 'required|exists:services,id',
            'services.*.ordering' => 'required|integer|min:0',
        ]);

        foreach ($validated['services'] as $serviceData) {
            Service::where('id', $serviceData['id'])
                  ->update(['ordering' => $serviceData['ordering']]);
        }

        return redirect()->route('admin.services.index')
                        ->with('success', 'Urutan layanan berhasil diperbarui.');
    }

    /**
     * Get service analytics.
     */
    public function analytics(Service $service): View
    {
        $inquiryCount = $service->inquiries()->count();
        $projectCount = $service->projects()->count();
        $conversionRate = $inquiryCount > 0 ? round(($projectCount / $inquiryCount) * 100, 2) : 0;
        
        $monthlyInquiries = $service->inquiries()
                                  ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                                  ->whereYear('created_at', date('Y'))
                                  ->groupBy('month')
                                  ->pluck('count', 'month')
                                  ->toArray();
        
        return view('admin.services.analytics', compact(
            'service',
            'inquiryCount',
            'projectCount',
            'conversionRate',
            'monthlyInquiries'
        ));
    }
}
