<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
// ContractPayment model removed
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use PDF;
use Exception;

class ContractController extends Controller
{
    /**
     * Display a listing of contracts
     */
    public function index(Request $request): View
    {
        $query = Contract::with(['project', 'user']);
        
        // Payment status filtering removed
        
        // Filter by contract status if provided
        if ($request->has('contract_status') && $request->contract_status != 'all') {
            $query->where('contract_status', $request->contract_status);
        }
        
        // Search by contract number, project name, or customer name
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('contract_number', 'like', "%{$search}%")
                  ->orWhereHas('project', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        $contracts = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.contracts.index', compact('contracts'));
    }

    /**
     * Show the form for creating a new contract
     */
    public function create(Request $request): View
    {
        $projectId = $request->project_id;
        $project = null;
        $projectsWithoutContracts = [];
        
        try {
            if ($projectId) {
                $project = Project::with('user')->findOrFail($projectId);
                Log::info('Loading specific project for contract creation', ['project_id' => $projectId]);
            } else {
                // Only get projects without contracts
                $projectsWithoutContracts = Project::whereDoesntHave('contract')
                    ->with('user')
                    ->get();
                
                Log::info('Loading all projects without contracts', ['count' => count($projectsWithoutContracts)]);
                
                // If no projects without contracts, log warning
                if ($projectsWithoutContracts->count() === 0) {
                    Log::warning('No projects available without contracts for new contract creation');
                }
            }
        } catch (\Exception $e) {
            Log::error('Error loading projects for contract creation', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            // Initialize empty array as fallback
            $projectsWithoutContracts = [];
        }
        
        $paymentMethods = [
            'cash' => 'Tunai',
            'bank_transfer' => 'Transfer Bank',
            'credit_card' => 'Kartu Kredit',
            'check' => 'Cek',
            'other' => 'Lainnya',
        ];
        
        return view('admin.contracts.create', compact('project', 'projectsWithoutContracts', 'paymentMethods'));
    }

    /**
     * Store a newly created contract
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            
            $validated = $request->validate([
                'project_id' => 'required|exists:projects,id|unique:contracts,project_id',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'amount' => 'required|numeric|min:0',
                'contract_status' => 'nullable|in:draft,active,completed,terminated',
                'notes' => 'nullable|string',
            ]);

            // Get user_id from the project
            $project = Project::findOrFail($request->project_id);
            $validated['user_id'] = $project->user_id;
            
            // Generate contract number
            $validated['contract_number'] = Contract::generateContractNumber();
            
            // Set contract status to active by default if not provided
            if (!isset($validated['contract_status']) || empty($validated['contract_status'])) {
                $validated['contract_status'] = 'active';
            }



            $contract = Contract::create($validated);
            
            // Payment tracking removed - contracts are now managed without payment details
            
            DB::commit();

            return redirect()->route('admin.contracts.show', $contract)
                ->with('success', 'Kontrak berhasil dibuat.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error creating contract', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat kontrak: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified contract
     */
    public function show(Contract $contract): View
    {
        $contract->load(['project.service', 'user']);
        return view('admin.contracts.show', compact('contract'));
    }

    /**
     * Show the form for editing the specified contract
     */
    public function edit(Contract $contract): View
    {
        $contract->load('project.user');

        $contractStatuses = [
            'draft' => 'Draft',
            'active' => 'Aktif',
            'completed' => 'Selesai',
            'terminated' => 'Dihentikan',
        ];

        return view('admin.contracts.edit', compact('contract', 'contractStatuses'));
    }

    /**
     * Update the specified contract
     */
    public function update(Request $request, Contract $contract): RedirectResponse
    {
        try {
            DB::beginTransaction();
            
            $validated = $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'amount' => 'required|numeric|min:0',
                'contract_status' => 'required|in:draft,active,completed,terminated',
                'notes' => 'nullable|string',
            ]);



            $contract->update($validated);
            
            DB::commit();

            return redirect()->route('admin.contracts.show', $contract)
                ->with('success', 'Kontrak berhasil diperbarui.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating contract', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui kontrak: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified contract
     */
    public function destroy(Contract $contract): RedirectResponse
    {
        try {
            DB::beginTransaction();
            
            // Delete file if exists
            if ($contract->contract_file) {
                Storage::disk('public')->delete($contract->contract_file);
            }
            
            // Delete all related payments
            $contract->payments()->delete();
            
            // Delete the contract
            $contract->delete();
            
            DB::commit();

            return redirect()->route('admin.contracts.index')
                ->with('success', 'Kontrak berhasil dihapus.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error deleting contract', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus kontrak: ' . $e->getMessage());
        }
    }

    /**
     * Download the contract file
     */
    public function download(Contract $contract)
    {
        if (!$contract->contract_file) {
            return redirect()->back()->with('error', 'File kontrak tidak tersedia.');
        }

        // Generate proper filename for download
        $filename = 'Kontrak_' . $contract->contract_number . '.' . pathinfo($contract->contract_file, PATHINFO_EXTENSION);

        return Storage::disk('public')->download($contract->contract_file, $filename);
    }
    
    // Payment management removed - contracts now managed without payment tracking
    

    
    /**
     * Generate contract report
     */
    public function report(Request $request): View
    {
        $query = Contract::with(['project', 'user']);
        
        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        
        // Filter by contract status
        if ($request->has('contract_status') && $request->contract_status != 'all') {
            $query->where('contract_status', $request->contract_status);
        }

        $contracts = $query->get();

        // Calculate basic stats (payment tracking removed)
        $totalAmount = $contracts->sum('amount');
        $totalContracts = $contracts->count();
        $activeContracts = $contracts->where('contract_status', 'active')->count();
        $completedContracts = $contracts->where('contract_status', 'completed')->count();
        $draftContracts = $contracts->where('contract_status', 'draft')->count();

        return view('admin.contracts.report', compact(
            'contracts',
            'totalAmount',
            'totalContracts',
            'activeContracts',
            'completedContracts',
            'draftContracts'
        ));
    }

    public function print(Contract $contract)
{
    $pdf = PDF::loadView('admin.contracts.print', compact('contract'));
    
    // Atur ukuran kertas dan orientasi
    $pdf->setPaper('A4', 'portrait');
    
    // Generate nama file
    $filename = 'Kontrak_' . $contract->contract_number . '.pdf';
    
    // Download PDF
    return $pdf->download($filename);
}
}
