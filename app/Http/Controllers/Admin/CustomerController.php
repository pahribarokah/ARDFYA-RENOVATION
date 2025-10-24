<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminMiddleware;
use App\Models\Chat;
use App\Models\Contract;
use App\Models\Inquiry;
use App\Models\Message;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
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
     * Display a listing of the customers.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = User::where('role', 'customer');
        
        // Search functionality
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        $customers = $query->latest()->paginate(10);
        
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);
        
        // Set role as customer
        $validated['role'] = 'customer';
        
        // Hash the password
        $validated['password'] = Hash::make($validated['password']);
        
        $customer = User::create($validated);
        
        Log::info('Admin created new customer', ['customer_id' => $customer->id]);
        
        return redirect()->route('admin.customers.show', $customer)
            ->with('success', 'Pelanggan berhasil dibuat!');
    }

    /**
     * Display the specified customer.
     */
    public function show(User $customer)
    {
        // Make sure the user is a customer
        if ($customer->role !== 'customer') {
            return redirect()->route('admin.customers.index')
                ->with('error', 'Data yang diminta bukan merupakan pelanggan.');
        }
        
        // Get all customer inquiries with their related data (including those directly linked by user_id)
        $inquiries = Inquiry::with(['service'])
            ->where('user_id', $customer->id)
            ->latest()
            ->get();
        
        // Also look for inquiries that have matching email but no user_id
        $emailInquiries = Inquiry::with(['service'])
            ->where('email', $customer->email)
            ->whereNull('user_id')
            ->latest()
            ->get();
            
        // Combine both collections
        $combinedInquiries = $inquiries->concat($emailInquiries);
        
        // Fix any inquiries that have matching email but no user_id
        foreach ($emailInquiries as $inquiry) {
            $inquiry->user_id = $customer->id;
            $inquiry->save();
            
            Log::info('Fixed orphaned inquiry for customer', [
                'customer_id' => $customer->id,
                'inquiry_id' => $inquiry->id,
                'email' => $inquiry->email
            ]);
        }
        
        // Get all customer projects
        $projects = Project::with(['service'])
            ->where('user_id', $customer->id)
            ->latest()
            ->get();
        
        // Get statistics
        $stats = [
            'new_inquiries' => Inquiry::where('user_id', $customer->id)->where('status', 'new')->count(),
            'in_progress' => Inquiry::where('user_id', $customer->id)->where('status', 'in_progress')->count(),
            'active_projects' => Project::where('user_id', $customer->id)->whereIn('status', ['planning', 'active', 'in_progress'])->count(),
            'completed_projects' => Project::where('user_id', $customer->id)->where('status', 'completed')->count(),
        ];
        
        return view('admin.customers.show', [
            'customer' => $customer, 
            'inquiries' => $combinedInquiries, 
            'projects' => $projects, 
            'stats' => $stats
        ]);
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit(User $customer)
    {
        // Make sure the user is a customer
        if ($customer->role !== 'customer') {
            return redirect()->route('admin.customers.index')
                ->with('error', 'Data yang diminta bukan merupakan pelanggan.');
        }
        
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(Request $request, User $customer)
    {
        // Make sure the user is a customer
        if ($customer->role !== 'customer') {
            return redirect()->route('admin.customers.index')
                ->with('error', 'Data yang diminta bukan merupakan pelanggan.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $customer->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);
        
        // Update password if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8',
            ]);
            
            $validated['password'] = Hash::make($request->input('password'));
        }
        
        $customer->update($validated);
        
        Log::info('Admin updated customer', ['customer_id' => $customer->id]);
        
        return redirect()->route('admin.customers.show', $customer)
            ->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(User $customer, Request $request)
    {
        // Make sure the user is a customer
        if ($customer->role !== 'customer') {
            return redirect()->route('admin.customers.index')
                ->with('error', 'Data yang diminta bukan merupakan pelanggan.');
        }

        // Check if the customer has related models
        $hasInquiries = Inquiry::where('user_id', $customer->id)->exists();
        $hasProjects = Project::where('user_id', $customer->id)->exists();
        $hasContracts = Contract::where('user_id', $customer->id)->exists();
        $hasMessages = Message::where('user_id', $customer->id)->exists();
        $hasChats = Chat::where('customer_id', $customer->id)->exists();
        $hasNotifications = $customer->notifications()->exists();

        // Check if force delete is requested
        $forceDelete = $request->input('force') === 'true';

        if (($hasInquiries || $hasProjects || $hasContracts || $hasMessages || $hasChats || $hasNotifications) && !$forceDelete) {
            $relatedData = [];
            if ($hasInquiries) $relatedData[] = 'Inquiry';
            if ($hasProjects) $relatedData[] = 'Proyek';
            if ($hasContracts) $relatedData[] = 'Kontrak';
            if ($hasMessages) $relatedData[] = 'Pesan';
            if ($hasChats) $relatedData[] = 'Chat';
            if ($hasNotifications) $relatedData[] = 'Notifikasi';

            $forceDeleteUrl = route('admin.customers.destroy', $customer) . '?force=true';
            $csrfToken = csrf_token();

            return redirect()->route('admin.customers.index')
                ->with('error', 'Pelanggan tidak dapat dihapus karena memiliki data terkait: ' . implode(', ', $relatedData) . '.')
                ->with('force_delete_data', [
                    'customer_id' => $customer->id,
                    'customer_name' => $customer->name,
                    'url' => $forceDeleteUrl,
                    'token' => $csrfToken
                ]);
        }

        DB::beginTransaction();

        try {
            // If force delete, remove all related data first
            if ($forceDelete) {
                // Delete related data in correct order (child first, parent last)

                // 1. Delete contracts (will cascade to payments if any)
                Contract::where('user_id', $customer->id)->delete();

                // 2. Delete messages
                Message::where('user_id', $customer->id)->delete();

                // 3. Delete chats
                Chat::where('customer_id', $customer->id)->delete();

                // 4. Delete notifications
                $customer->notifications()->delete();

                // 5. Delete projects (will cascade to project images if any)
                Project::where('user_id', $customer->id)->delete();

                // 6. Delete inquiries
                Inquiry::where('user_id', $customer->id)->delete();
            }

            // Also remove any orphaned inquiries with the same email
            Inquiry::where('email', $customer->email)->whereNull('user_id')->delete();

            // Delete the customer
            $customer->delete();

            DB::commit();

            Log::info('Admin deleted customer', [
                'email' => $customer->email,
                'force_delete' => $forceDelete
            ]);

            return redirect()->route('admin.customers.index')
                ->with('success', 'Pelanggan berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error deleting customer', [
                'customer_id' => $customer->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('admin.customers.index')
                ->with('error', 'Terjadi kesalahan saat menghapus pelanggan: ' . $e->getMessage());
        }
    }

    /**
     * Return JSON list of customers for API usage
     */
    public function getCustomersJson(Request $request)
    {
        $search = $request->input('search');
        
        $query = User::where('role', 'customer');
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        $customers = $query->orderBy('name')->get();
        
        // Map to simplified array for frontend
        $result = $customers->map(function($customer) {
            return [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
            ];
        });
        
        return response()->json($result);
    }
}
