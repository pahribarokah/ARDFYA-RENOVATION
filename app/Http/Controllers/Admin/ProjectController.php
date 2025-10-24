<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects
     */
    public function index(Request $request): View
    {
        $query = Project::with(['service', 'user']);
        
        // Filter by status if provided
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        
        // Filter by service if provided
        if ($request->has('service_id') && $request->service_id != 'all') {
            $query->where('service_id', $request->service_id);
        }
        
        $projects = $query->orderBy('start_date', 'desc')->paginate(10);
        $services = Service::where('is_active', true)->get();
        
        return view('admin.projects.index', compact('projects', 'services'));
    }

    /**
     * Show the form for creating a new project
     */
    public function create(Request $request): View
    {
        $inquiryId = $request->inquiry_id;
        $inquiry = null;
        
        if ($inquiryId) {
            $inquiry = Inquiry::findOrFail($inquiryId);
        }
        
        $services = Service::where('is_active', true)->get();
        $customers = User::where('role', 'customer')->get();
        $inquiries = Inquiry::whereNotNull('user_id')->get();
        
        return view('admin.projects.create', compact('services', 'customers', 'inquiries', 'inquiry'));
    }

    /**
     * Store a newly created project
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'inquiry_id' => 'nullable|exists:inquiries,id',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'expected_end_date' => 'nullable|date|after_or_equal:start_date',
            'budget' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $validated['status'] = 'planning';
        $validated['progress_percentage'] = 0;

        $project = Project::create($validated);

        // Broadcast project created event
        broadcast(new \App\Events\ProjectUpdated($project, 'new_project'))->toOthers();

        // Update inquiry status if exists
        if ($request->has('inquiry_id') && $request->inquiry_id) {
            $inquiry = Inquiry::find($request->inquiry_id);
            if ($inquiry) {
                $inquiry->status = 'in_progress';
                $inquiry->save();
            }
        }

        return redirect()->route('admin.projects.show', $project)
            ->with('success', 'Proyek berhasil dibuat.');
    }

    /**
     * Display the specified project
     */
    public function show(Project $project): View
    {
        $project->load(['service', 'user', 'inquiry', 'messages']);
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified project
     */
    public function edit(Project $project): View
    {
        $services = Service::where('is_active', true)->get();
        $customers = User::where('role', 'customer')->get();
        $inquiries = Inquiry::whereNotNull('user_id')->get();

        // Load the related inquiry if exists
        $inquiry = $project->inquiry;

        return view('admin.projects.edit', compact('project', 'services', 'customers', 'inquiries', 'inquiry'));
    }

    /**
     * Update the specified project
     */
    public function update(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'inquiry_id' => 'nullable|exists:inquiries,id',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'expected_end_date' => 'nullable|date|after_or_equal:start_date',
            'actual_end_date' => 'nullable|date',
            'status' => 'required|in:planning,in_progress,on_hold,completed,cancelled',
            'budget' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'progress_percentage' => 'required|integer|min:0|max:100',
        ]);

        $oldStatus = $project->status;
        $oldProgress = $project->progress_percentage;

        $project->update($validated);

        // Determine update type and broadcast event
        $updateType = 'general_update';
        if ($oldStatus !== $validated['status']) {
            $updateType = 'status_change';
        } elseif ($oldProgress !== $validated['progress_percentage']) {
            $updateType = 'progress_update';
        }

        // Broadcast project updated event
        broadcast(new \App\Events\ProjectUpdated($project, $updateType))->toOthers();

        return redirect()->route('admin.projects.show', $project)
            ->with('success', 'Proyek berhasil diperbarui.');
    }

    /**
     * Remove the specified project
     */
    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Proyek berhasil dihapus.');
    }
}
