<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminMiddleware;
use App\Models\Contract;
use App\Models\Inquiry;
use App\Models\Message;
use App\Models\Project;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(AdminMiddleware::class);
    }
    
    /**
     * Show the admin dashboard
     */
    public function index(): View
    {
        try {
            // Get counts
            $customerCount = User::where('role', 'customer')->count();
            $inquiryCount = Inquiry::count();
            $projectCount = Project::count();
            $contractCount = Contract::count();
            
            // Get recent inquiries
            $recentInquiries = Inquiry::with(['service', 'user'])
                ->latest()
                ->take(5)
                ->get();
            
            // Get inquiries by status
            $inquiriesByStatus = Inquiry::select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get()
                ->pluck('count', 'status')
                ->toArray();
            
            // Get ongoing projects
            $ongoingProjects = Project::with(['service', 'user'])
                ->where('status', 'in_progress')
                ->latest()
                ->take(5)
                ->get();
            
            // Get projects by status
            $projectsByStatus = Project::select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get()
                ->pluck('count', 'status')
                ->toArray();
            
            // Get contracts by contract status (payment status removed)
            $contractsByStatus = Contract::select('contract_status', DB::raw('count(*) as count'))
                ->groupBy('contract_status')
                ->get()
                ->pluck('count', 'contract_status')
                ->toArray();
            
            // Get recent messages
            $recentMessages = Message::with(['user', 'inquiry'])
                ->latest()
                ->take(5)
                ->get();
            
            // Check for orphaned inquiries
            $orphanedInquiriesCount = Inquiry::whereNull('user_id')->count();
            
            return view('admin.dashboard', compact(
                'customerCount',
                'inquiryCount',
                'projectCount',
                'contractCount',
                'recentInquiries',
                'inquiriesByStatus',
                'ongoingProjects',
                'projectsByStatus',
                'contractsByStatus',
                'recentMessages',
                'orphanedInquiriesCount'
            ));
        } catch (Exception $e) {
            Log::error('Error saat menampilkan dashboard admin', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return view('admin.dashboard', [
                'error' => 'Terjadi kesalahan saat memuat data dashboard: ' . $e->getMessage(),
                'customerCount' => 0,
                'inquiryCount' => 0,
                'projectCount' => 0,
                'contractCount' => 0,
                'recentInquiries' => collect(),
                'inquiriesByStatus' => [],
                'ongoingProjects' => collect(),
                'projectsByStatus' => [],
                'contractsByStatus' => [],
                'recentMessages' => collect(),
                'orphanedInquiriesCount' => 0
            ]);
        }
    }
    
    /**
     * Fix orphaned inquiries
     */
    public function fixOrphanedInquiries()
    {
        try {
            $count = app(\App\Http\Controllers\Admin\InquiryController::class)->fixOrphanedInquiries();
            return redirect()->route('admin.dashboard')->with('success', "Berhasil memperbaiki {$count} permintaan.");
        } catch (Exception $e) {
            Log::error('Error saat memperbaiki permintaan', [
                'error' => $e->getMessage()
            ]);
            
            return redirect()->route('admin.dashboard')->with('error', 'Gagal memperbaiki permintaan: ' . $e->getMessage());
        }
    }
}
