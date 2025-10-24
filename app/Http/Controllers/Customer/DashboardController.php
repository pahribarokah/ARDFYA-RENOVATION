<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Inquiry;
use App\Models\Contract;
use App\Models\Message;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Check if user is customer, redirect if not.
     */
    private function checkCustomerRole()
    {
        if (Auth::user()->role !== 'customer') {
            return redirect()->route('home');
        }
        return null;
    }

    /**
     * Show the customer dashboard.
     */
    public function index(): View|RedirectResponse
    {
        // Check if user is customer
        if ($redirect = $this->checkCustomerRole()) {
            return $redirect;
        }

        $user = Auth::user();
        
        // Get customer statistics
        $totalProjects = Project::where('user_id', $user->id)->count();
        $activeProjects = Project::where('user_id', $user->id)
                                ->whereIn('status', ['planning', 'in_progress'])
                                ->count();
        $completedProjects = Project::where('user_id', $user->id)
                                   ->where('status', 'completed')
                                   ->count();
        
        $totalInquiries = Inquiry::where('user_id', $user->id)->count();
        $pendingInquiries = Inquiry::where('user_id', $user->id)
                                  ->where('status', 'pending')
                                  ->count();
        
        $totalContracts = Contract::where('user_id', $user->id)->count();
        $activeContracts = Contract::where('user_id', $user->id)
                                  ->where('contract_status', 'active')
                                  ->count();
        
        // Get recent activities
        $recentProjects = Project::where('user_id', $user->id)
                                ->with(['service'])
                                ->orderBy('updated_at', 'desc')
                                ->limit(5)
                                ->get();
        
        $recentInquiries = Inquiry::where('user_id', $user->id)
                                 ->with(['service'])
                                 ->orderBy('created_at', 'desc')
                                 ->limit(5)
                                 ->get();
        
        // Count unread messages from admin (in messages table) + unread chats
        $unreadMessagesFromAdmin = Message::where('user_id', $user->id)
                                         ->where('is_from_admin', true)
                                         ->where('is_read', false)
                                         ->count();

        $unreadChatsFromAdmin = Chat::where('customer_id', $user->id)
                                   ->where('is_from_admin', true)
                                   ->where('is_read', false)
                                   ->count();

        $unreadMessages = $unreadMessagesFromAdmin + $unreadChatsFromAdmin;
        
        return view('customer.dashboard', compact(
            'totalProjects',
            'activeProjects', 
            'completedProjects',
            'totalInquiries',
            'pendingInquiries',
            'totalContracts',
            'activeContracts',
            'recentProjects',
            'recentInquiries',
            'unreadMessages'
        ));
    }

    /**
     * Show customer projects.
     */
    public function projects(): View|RedirectResponse
    {
        // Check if user is customer
        if ($redirect = $this->checkCustomerRole()) {
            return $redirect;
        }

        $user = Auth::user();
        
        $projects = Project::where('user_id', $user->id)
                          ->with(['service', 'inquiry'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);
        
        return view('customer.projects', compact('projects'));
    }

    /**
     * Show project detail.
     */
    public function projectDetail(Project $project): View|RedirectResponse
    {
        // Check if user is customer
        if ($redirect = $this->checkCustomerRole()) {
            return $redirect;
        }

        // Ensure user can only view their own projects
        if ($project->user_id !== Auth::id()) {
            abort(403);
        }
        
        $project->load(['service', 'inquiry', 'contract']);
        
        return view('customer.project-detail', compact('project'));
    }

    /**
     * Show customer inquiries.
     */
    public function inquiries(): View|RedirectResponse
    {
        // Check if user is customer
        if ($redirect = $this->checkCustomerRole()) {
            return $redirect;
        }

        $user = Auth::user();
        
        $inquiries = Inquiry::where('user_id', $user->id)
                           ->with(['service'])
                           ->orderBy('created_at', 'desc')
                           ->paginate(10);
        
        return view('customer.inquiries', compact('inquiries'));
    }

    /**
     * Show customer contracts.
     */
    public function contracts(): View|RedirectResponse
    {
        // Check if user is customer
        if ($redirect = $this->checkCustomerRole()) {
            return $redirect;
        }

        $user = Auth::user();
        
        $contracts = Contract::where('user_id', $user->id)
                            ->with(['project', 'project.service'])
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);
        
        return view('customer.contracts', compact('contracts'));
    }

    /**
     * Download contract PDF.
     */
    public function downloadContract(Contract $contract)
    {
        // Check if user is customer
        if ($redirect = $this->checkCustomerRole()) {
            return $redirect;
        }

        // Ensure user can only download their own contracts
        if ($contract->user_id !== Auth::id()) {
            abort(403);
        }

        // Always generate PDF from template
        return $this->generateContractPDF($contract);
    }

    /**
     * Generate contract PDF from template
     */
    private function generateContractPDF(Contract $contract)
    {
        $pdf = \PDF::loadView('admin.contracts.print', compact('contract'));

        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');

        // Generate filename
        $filename = 'Kontrak_' . $contract->contract_number . '.pdf';

        // Download PDF
        return $pdf->download($filename);
    }
}
