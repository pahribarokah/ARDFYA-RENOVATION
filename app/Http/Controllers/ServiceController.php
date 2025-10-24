<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ServiceController extends Controller
{
    // index() method removed - services now shown on homepage only

    /**
     * Display the specified service
     */
    public function show(Service $service): View
    {
        // Get projects related to this service
        $relatedProjects = Project::where('service_id', $service->id)
                            ->where('status', 'completed')
                            ->take(3)
                            ->get();
                            
        return view('services.show', compact('service', 'relatedProjects'));
    }

    /**
     * Show inquiry form for a specific service
     */
    public function inquire(Service $service): View
    {
        return view('services.inquire', compact('service'));
    }

    /**
     * Get all services for AJAX request
     */
    public function getAllServices(): JsonResponse
    {
        try {
            $services = Service::where('is_active', true)
                             ->orderBy('name')
                             ->get(['id', 'name', 'description', 'icon']);

            return response()->json([
                'success' => true,
                'services' => $services
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load services'
            ], 500);
        }
    }
}
