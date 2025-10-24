<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Message;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MessageController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    /**
     * Display the admin chat interface
     */
    public function index(): View
    {
        // Auto mark unread messages from customers as read when admin opens messages page
        Message::where('is_from_admin', false)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // Also mark unread chats from customers as read
        \App\Models\Chat::where('is_from_admin', false)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('messages.admin');
    }

    /**
     * Get all inquiries with unread message counts
     */
    public function getInquiries(): JsonResponse
    {
        $inquiries = Inquiry::with(['user', 'service'])
            ->select('inquiries.*')
            ->addSelect([
                'unread_messages_count' => Message::selectRaw('COUNT(*)')
                    ->whereColumn('inquiry_id', 'inquiries.id')
                    ->where('is_from_admin', false)
                    ->where('is_read', false)
            ])
            ->orderByDesc(
                Message::select('created_at')
                    ->whereColumn('inquiry_id', 'inquiries.id')
                    ->orderByDesc('created_at')
                    ->limit(1)
            )
            ->orderByDesc('inquiries.created_at')
            ->get();
        
        return response()->json($inquiries);
    }

    /**
     * Get all projects with unread message counts
     */
    public function getProjects(): JsonResponse
    {
        $projects = Project::with(['user', 'service'])
            ->select('projects.*')
            ->addSelect([
                'unread_messages_count' => Message::selectRaw('COUNT(*)')
                    ->whereColumn('project_id', 'projects.id')
                    ->where('is_from_admin', false)
                    ->where('is_read', false)
            ])
            ->orderByDesc(
                Message::select('created_at')
                    ->whereColumn('project_id', 'projects.id')
                    ->orderByDesc('created_at')
                    ->limit(1)
            )
            ->orderByDesc('projects.created_at')
            ->get();
        
        return response()->json($projects);
    }
    
    /**
     * Get messages statistics
     */
    public function getStats(): JsonResponse
    {
        $stats = [
            'total_messages' => Message::count(),
            'unread_messages' => Message::where('is_from_admin', false)
                ->where('is_read', false)
                ->count(),
            'active_inquiries' => Inquiry::whereHas('messages')->count(),
            'active_projects' => Project::whereHas('messages')->count(),
        ];
        
        return response()->json($stats);
    }
} 