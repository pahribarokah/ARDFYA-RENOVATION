<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Inquiry;
use App\Models\Project;
use App\Models\Contract;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;
use PDF;

class ReportsController extends Controller
{
    /**
     * Show reports dashboard.
     */
    public function index(): View
    {
        return view('admin.reports.index');
    }

    /**
     * Generate customer report.
     */
    public function customers(Request $request): View
    {
        $startDate = $request->get('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        
        $customers = User::where('role', 'customer')
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->with(['inquiries', 'projects', 'contracts'])
                        ->get();
        
        $totalCustomers = $customers->count();
        $totalInquiries = $customers->sum(function($customer) {
            return $customer->inquiries->count();
        });
        $totalProjects = $customers->sum(function($customer) {
            return $customer->projects->count();
        });
        
        return view('admin.reports.customers', compact(
            'customers',
            'totalCustomers',
            'totalInquiries',
            'totalProjects',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Generate inquiry report.
     */
    public function inquiries(Request $request): View
    {
        $startDate = $request->get('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        $status = $request->get('status', 'all');
        
        $query = Inquiry::whereBetween('created_at', [$startDate, $endDate])
                       ->with(['user', 'service']);
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $inquiries = $query->get();
        
        $statusCounts = [
            'pending' => $inquiries->where('status', 'pending')->count(),
            'approved' => $inquiries->where('status', 'approved')->count(),
            'rejected' => $inquiries->where('status', 'rejected')->count(),
            'converted' => $inquiries->where('status', 'converted')->count(),
        ];
        
        return view('admin.reports.inquiries', compact(
            'inquiries',
            'statusCounts',
            'startDate',
            'endDate',
            'status'
        ));
    }

    /**
     * Generate project report.
     */
    public function projects(Request $request): View
    {
        $startDate = $request->get('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        $status = $request->get('status', 'all');
        
        $query = Project::whereBetween('created_at', [$startDate, $endDate])
                       ->with(['user', 'service', 'contract']);
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $projects = $query->get();
        
        $statusCounts = [
            'planning' => $projects->where('status', 'planning')->count(),
            'in_progress' => $projects->where('status', 'in_progress')->count(),
            'on_hold' => $projects->where('status', 'on_hold')->count(),
            'completed' => $projects->where('status', 'completed')->count(),
            'cancelled' => $projects->where('status', 'cancelled')->count(),
        ];
        
        $totalBudget = $projects->sum('budget');
        
        return view('admin.reports.projects', compact(
            'projects',
            'statusCounts',
            'totalBudget',
            'startDate',
            'endDate',
            'status'
        ));
    }

    /**
     * Generate contract report.
     */
    public function contracts(Request $request): View
    {
        $startDate = $request->get('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        $status = $request->get('status', 'all');
        
        $query = Contract::whereBetween('created_at', [$startDate, $endDate])
                        ->with(['user', 'project']);
        
        if ($status !== 'all') {
            $query->where('contract_status', $status);
        }
        
        $contracts = $query->get();
        
        $statusCounts = [
            'draft' => $contracts->where('contract_status', 'draft')->count(),
            'active' => $contracts->where('contract_status', 'active')->count(),
            'completed' => $contracts->where('contract_status', 'completed')->count(),
            'cancelled' => $contracts->where('contract_status', 'cancelled')->count(),
        ];
        
        $totalValue = $contracts->sum('amount');
        
        return view('admin.reports.contracts', compact(
            'contracts',
            'statusCounts',
            'totalValue',
            'startDate',
            'endDate',
            'status'
        ));
    }

    /**
     * Generate portfolio report.
     */
    public function portfolios(Request $request): View
    {
        $category = $request->get('category', 'all');
        
        $query = Portfolio::with([]);
        
        if ($category !== 'all') {
            $query->where('category', $category);
        }
        
        $portfolios = $query->get();
        
        $categoryCounts = Portfolio::selectRaw('category, COUNT(*) as count')
                                 ->groupBy('category')
                                 ->pluck('count', 'category')
                                 ->toArray();
        
        $featuredCount = $portfolios->where('is_featured', true)->count();
        $activeCount = $portfolios->where('is_active', true)->count();
        $totalValue = $portfolios->sum('project_value');
        
        return view('admin.reports.portfolios', compact(
            'portfolios',
            'categoryCounts',
            'featuredCount',
            'activeCount',
            'totalValue',
            'category'
        ));
    }

    /**
     * Export report as PDF.
     */
    public function exportPdf(Request $request, $type)
    {
        $data = $this->getReportData($request, $type);
        
        $pdf = PDF::loadView("admin.reports.pdf.{$type}", $data);
        
        return $pdf->download("{$type}_report_" . date('Y-m-d') . ".pdf");
    }

    /**
     * Get report data based on type.
     */
    private function getReportData(Request $request, $type)
    {
        switch ($type) {
            case 'customers':
                return $this->customers($request)->getData();
            case 'inquiries':
                return $this->inquiries($request)->getData();
            case 'projects':
                return $this->projects($request)->getData();
            case 'contracts':
                return $this->contracts($request)->getData();
            case 'portfolios':
                return $this->portfolios($request)->getData();
            default:
                abort(404);
        }
    }
}
