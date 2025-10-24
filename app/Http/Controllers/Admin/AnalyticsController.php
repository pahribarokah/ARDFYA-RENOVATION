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

class AnalyticsController extends Controller
{
    /**
     * Show analytics dashboard.
     */
    public function index(): View
    {
        // Customer Analytics
        $totalCustomers = User::where('role', 'customer')->count();
        $newCustomersThisMonth = User::where('role', 'customer')
                                   ->whereMonth('created_at', Carbon::now()->month)
                                   ->whereYear('created_at', Carbon::now()->year)
                                   ->count();
        
        // Inquiry Analytics
        $totalInquiries = Inquiry::count();
        $pendingInquiries = Inquiry::where('status', 'pending')->count();
        $approvedInquiries = Inquiry::where('status', 'approved')->count();
        $convertedInquiries = Inquiry::where('status', 'converted')->count();
        $conversionRate = $totalInquiries > 0 ? round(($convertedInquiries / $totalInquiries) * 100, 2) : 0;
        
        // Project Analytics
        $totalProjects = Project::count();
        $activeProjects = Project::whereIn('status', ['planning', 'in_progress'])->count();
        $completedProjects = Project::where('status', 'completed')->count();
        $completionRate = $totalProjects > 0 ? round(($completedProjects / $totalProjects) * 100, 2) : 0;
        
        // Contract Analytics
        $totalContracts = Contract::count();
        $activeContracts = Contract::where('contract_status', 'active')->count();
        $totalContractValue = Contract::sum('amount');
        
        // Portfolio Analytics
        $totalPortfolios = Portfolio::count();
        $featuredPortfolios = Portfolio::where('is_featured', true)->count();
        $activePortfolios = Portfolio::where('is_active', true)->count();
        
        // Monthly Data for Charts
        $monthlyInquiries = $this->getMonthlyData(Inquiry::class);
        $monthlyProjects = $this->getMonthlyData(Project::class);
        $monthlyContracts = $this->getMonthlyData(Contract::class);
        
        // Status Distribution
        $inquiryStatusData = Inquiry::selectRaw('status, COUNT(*) as count')
                                   ->groupBy('status')
                                   ->pluck('count', 'status')
                                   ->toArray();
        
        $projectStatusData = Project::selectRaw('status, COUNT(*) as count')
                                   ->groupBy('status')
                                   ->pluck('count', 'status')
                                   ->toArray();
        
        return view('admin.analytics.index', compact(
            'totalCustomers',
            'newCustomersThisMonth',
            'totalInquiries',
            'pendingInquiries',
            'approvedInquiries',
            'convertedInquiries',
            'conversionRate',
            'totalProjects',
            'activeProjects',
            'completedProjects',
            'completionRate',
            'totalContracts',
            'activeContracts',
            'totalContractValue',
            'totalPortfolios',
            'featuredPortfolios',
            'activePortfolios',
            'monthlyInquiries',
            'monthlyProjects',
            'monthlyContracts',
            'inquiryStatusData',
            'projectStatusData'
        ));
    }

    /**
     * Get monthly data for the last 12 months.
     */
    private function getMonthlyData($model)
    {
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = $model::whereMonth('created_at', $date->month)
                          ->whereYear('created_at', $date->year)
                          ->count();
            $data[] = [
                'month' => $date->format('M Y'),
                'count' => $count
            ];
        }
        return $data;
    }

    /**
     * Get analytics data as JSON for AJAX requests.
     */
    public function getData(Request $request)
    {
        $type = $request->get('type', 'overview');
        
        switch ($type) {
            case 'customers':
                return $this->getCustomerAnalytics();
            case 'inquiries':
                return $this->getInquiryAnalytics();
            case 'projects':
                return $this->getProjectAnalytics();
            case 'contracts':
                return $this->getContractAnalytics();
            case 'portfolios':
                return $this->getPortfolioAnalytics();
            default:
                return response()->json(['error' => 'Invalid type'], 400);
        }
    }

    private function getCustomerAnalytics()
    {
        $customers = User::where('role', 'customer')
                        ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                        ->where('created_at', '>=', Carbon::now()->subDays(30))
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
        
        return response()->json($customers);
    }

    private function getInquiryAnalytics()
    {
        $inquiries = Inquiry::selectRaw('DATE(created_at) as date, status, COUNT(*) as count')
                           ->where('created_at', '>=', Carbon::now()->subDays(30))
                           ->groupBy('date', 'status')
                           ->orderBy('date')
                           ->get();
        
        return response()->json($inquiries);
    }

    private function getProjectAnalytics()
    {
        $projects = Project::selectRaw('DATE(created_at) as date, status, COUNT(*) as count')
                          ->where('created_at', '>=', Carbon::now()->subDays(30))
                          ->groupBy('date', 'status')
                          ->orderBy('date')
                          ->get();
        
        return response()->json($projects);
    }

    private function getContractAnalytics()
    {
        $contracts = Contract::selectRaw('DATE(created_at) as date, SUM(amount) as total_value, COUNT(*) as count')
                            ->where('created_at', '>=', Carbon::now()->subDays(30))
                            ->groupBy('date')
                            ->orderBy('date')
                            ->get();
        
        return response()->json($contracts);
    }

    private function getPortfolioAnalytics()
    {
        $portfolios = Portfolio::selectRaw('category, COUNT(*) as count')
                              ->groupBy('category')
                              ->get();
        
        return response()->json($portfolios);
    }
}
