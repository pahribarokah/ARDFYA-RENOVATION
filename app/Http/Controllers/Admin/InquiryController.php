<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminMiddleware;
use App\Models\Inquiry;
use App\Models\Service;
use App\Models\User;
use App\Notifications\InquiryStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InquiryController extends Controller
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
     * Display a listing of the inquiries.
     */
    public function index(Request $request)
    {
        $status = $request->input('status', '');
        
        // Query dasar
        $query = Inquiry::with(['service', 'user', 'project']);
        
        // Filter by status if provided
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }
        
        // Debug query
        $sql = $query->toSql();
        $bindings = $query->getBindings();
        
        // Log query untuk debugging
        Log::info('Admin Inquiry Index Query', [
            'status' => $status,
            'search' => $request->input('search', ''),
            'query' => $sql,
            'bindings' => $bindings
        ]);
        
        try {
            // Jalankan query
            $inquiries = $query->latest()->paginate(10);
            
            // Debug cek data untuk pastikan tidak ada relasi yang rusak
            $inquiriesRaw = DB::table('inquiries')->get();
            
            // Log hasil query
            Log::info('Admin Inquiry Results', [
                'count' => $inquiries->count(),
                'total' => $inquiries->total(),
                'raw_count' => $inquiriesRaw->count(),
                'first_record' => $inquiries->count() > 0 ? [
                    'id' => $inquiries->first()->id,
                    'name' => $inquiries->first()->name,
                    'email' => $inquiries->first()->email,
                    'service_id' => $inquiries->first()->service_id,
                    'service' => $inquiries->first()->service ? $inquiries->first()->service->name : 'N/A'
                ] : 'No records'
            ]);
            
            // Cek apakah data sudah memiliki user_id
            $needFix = false;
            $inquiriesWithoutUser = DB::table('inquiries')->whereNull('user_id')->count();
            if ($inquiriesWithoutUser > 0) {
                Log::warning('Ada inquiry tanpa user_id', ['count' => $inquiriesWithoutUser]);
                $needFix = true;
            }
            
            // Lakukan perbaikan otomatis jika perlu
            if ($needFix) {
                $this->fixInquiriesWithoutUser();
            }
            
            return view('admin.inquiries.index', [
                'inquiries' => $inquiries,
                'status' => $status,
                'statuses' => [
                    'new' => 'Baru',
                    'contacted' => 'Dihubungi',
                    'in_progress' => 'Diproses',
                    'completed' => 'Selesai', 
                    'cancelled' => 'Dibatalkan'
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error saat menampilkan daftar inquiry', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Fallback jika terjadi error, tampilkan data tanpa relasi
            $inquiries = Inquiry::latest()->paginate(10);
            
            return view('admin.inquiries.index', [
                'inquiries' => $inquiries,
                'status' => $status,
                'statuses' => [
                    'new' => 'Baru',
                    'contacted' => 'Dihubungi',
                    'in_progress' => 'Diproses',
                    'completed' => 'Selesai', 
                    'cancelled' => 'Dibatalkan'
                ],
                'error' => 'Terjadi kesalahan saat memuat data. Beberapa relasi mungkin tidak tampil.'
            ]);
        }
    }

    /**
     * Fix inquiries without user_id
     */
    private function fixInquiriesWithoutUser()
    {
        try {
            // Ambil inquiry tanpa user_id
            $inquiries = DB::table('inquiries')->whereNull('user_id')->get();
            
            foreach ($inquiries as $inquiry) {
                // Cek apakah email sudah terdaftar
                $user = User::where('email', $inquiry->email)->first();
                
                if (!$user) {
                    // Buat user baru jika belum ada
                    $user = User::create([
                        'name' => $inquiry->name,
                        'email' => $inquiry->email,
                        'password' => bcrypt('password123'),
                        'role' => 'customer',
                    ]);
                    
                    Log::info('User baru dibuat untuk inquiry tanpa user_id', [
                        'inquiry_id' => $inquiry->id,
                        'user_id' => $user->id,
                    ]);
                }
                
                // Update inquiry dengan user_id baru
                DB::table('inquiries')
                    ->where('id', $inquiry->id)
                    ->update(['user_id' => $user->id]);
                
                Log::info('Inquiry berhasil diupdate dengan user_id', [
                    'inquiry_id' => $inquiry->id,
                    'user_id' => $user->id
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error saat memperbaiki inquiry tanpa user_id', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Show the form for creating a new inquiry.
     */
    public function create()
    {
        $services = Service::where('is_active', true)->get();
        $customers = User::where('role', 'customer')->get();
        
        return view('admin.inquiries.create', [
            'services' => $services,
            'customers' => $customers,
            'property_types' => [
                'rumah' => 'Rumah',
                'apartemen' => 'Apartemen',
                'ruko' => 'Ruko',
                'kantor' => 'Kantor',
                'lainnya' => 'Lainnya'
            ]
        ]);
    }

    /**
     * Store a newly created inquiry in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|regex:/^[0-9+\-\s()]+$/|min:10|max:20',
            'service_id' => 'required|exists:services,id',
            'address' => 'required|string',
            'property_type' => 'required|string',
            'area_size' => 'required|integer|min:1',
            'current_condition' => 'required|string',
            'description' => 'required|string',
            'budget' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'schedule_flexibility' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|string|in:new,contacted,in_progress,completed,cancelled',
        ]);
        
        $inquiry = Inquiry::create($validated);

        // Broadcast new inquiry event
        broadcast(new \App\Events\NewInquiryReceived($inquiry))->toOthers();

        Log::info('Admin created new inquiry', ['inquiry_id' => $inquiry->id]);

        return redirect()->route('admin.inquiries.show', $inquiry)
            ->with('success', 'Permintaan berhasil dibuat!');
    }

    /**
     * Display the specified inquiry.
     */
    public function show(Inquiry $inquiry)
    {
        // Load relationships
        $inquiry->load(['service', 'user', 'project', 'messages' => function($query) {
            $query->orderBy('created_at', 'desc');
        }]);
        
        return view('admin.inquiries.show', [
            'inquiry' => $inquiry
        ]);
    }

    /**
     * Show the form for editing the specified inquiry.
     */
    public function edit(Inquiry $inquiry)
    {
        $services = Service::where('is_active', true)->get();
        $customers = User::where('role', 'customer')->get();
        
        return view('admin.inquiries.edit', [
            'inquiry' => $inquiry,
            'services' => $services,
            'customers' => $customers,
            'property_types' => [
                'rumah' => 'Rumah',
                'apartemen' => 'Apartemen',
                'ruko' => 'Ruko',
                'kantor' => 'Kantor',
                'lainnya' => 'Lainnya'
            ],
            'statuses' => [
                'new' => 'Baru',
                'contacted' => 'Dihubungi',
                'in_progress' => 'Diproses',
                'completed' => 'Selesai', 
                'cancelled' => 'Dibatalkan'
            ]
        ]);
    }

    /**
     * Update the specified inquiry in storage.
     */
    public function update(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|regex:/^[0-9+\-\s()]+$/|min:10|max:20',
            'service_id' => 'required|exists:services,id',
            'address' => 'required|string',
            'property_type' => 'required|string',
            'area_size' => 'required|integer|min:1',
            'current_condition' => 'required|string',
            'description' => 'required|string',
            'budget' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'schedule_flexibility' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|string|in:new,contacted,in_progress,completed,cancelled',
        ]);
        
        $inquiry->update($validated);
        
        Log::info('Admin updated inquiry', ['inquiry_id' => $inquiry->id]);
        
        return redirect()->route('admin.inquiries.show', $inquiry)
            ->with('success', 'Permintaan berhasil diperbarui!');
    }

    /**
     * Update the status of the specified inquiry.
     */
    public function updateStatus(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:new,contacted,in_progress,completed,cancelled',
        ]);

        $oldStatus = $inquiry->status;
        $inquiry->update($validated);

        // Send notification to customer if status changed
        if ($oldStatus !== $validated['status'] && $inquiry->user) {
            $inquiry->user->notify(new InquiryStatusNotification($inquiry, $oldStatus, $validated['status']));

            // Broadcast real-time event
            broadcast(new \App\Events\InquiryStatusUpdated($inquiry, $oldStatus, $validated['status']))->toOthers();
        }

        Log::info('Admin updated inquiry status', [
            'inquiry_id' => $inquiry->id,
            'old_status' => $oldStatus,
            'new_status' => $validated['status']
        ]);

        return redirect()->back()
            ->with('success', 'Status permintaan berhasil diperbarui!');
    }

    /**
     * Remove the specified inquiry from storage.
     */
    public function destroy(Inquiry $inquiry)
    {
        // Check if the inquiry has related models
        if ($inquiry->project || $inquiry->messages->count() > 0) {
            return redirect()->route('admin.inquiries.index')
                ->with('error', 'Permintaan tidak dapat dihapus karena memiliki data terkait!');
        }
        
        Log::info('Admin deleted inquiry', ['inquiry_id' => $inquiry->id]);
        
        $inquiry->delete();
        
        return redirect()->route('admin.inquiries.index')
            ->with('success', 'Permintaan berhasil dihapus!');
    }
    
    /**
     * Fix all orphaned inquiries by associating them with users.
     */
    public function fixOrphanedInquiries()
    {
        DB::beginTransaction();
        
        try {
            $orphanedInquiries = Inquiry::whereNull('user_id')->get();
            $fixedCount = 0;
            
            foreach ($orphanedInquiries as $inquiry) {
                // Skip if no email is available
                if (empty($inquiry->email)) {
                    continue;
                }
                
                // Try to find a user with matching email
                $user = User::where('email', $inquiry->email)->first();
                
                // If no user found, create one
                if (!$user) {
                    $user = User::create([
                        'name' => $inquiry->name,
                        'email' => $inquiry->email,
                        'password' => bcrypt('password123'), // Temporary password
                        'phone' => $inquiry->phone ?? '',
                        'address' => $inquiry->address ?? '',
                        'role' => 'customer',
                    ]);
                    
                    Log::info('Created new user while fixing orphaned inquiries', [
                        'user_id' => $user->id,
                        'email' => $user->email,
                        'inquiry_id' => $inquiry->id
                    ]);
                }
                
                // Associate the inquiry with the user
                $inquiry->user_id = $user->id;
                $inquiry->save();
                $fixedCount++;
                
                Log::info('Fixed orphaned inquiry', [
                    'inquiry_id' => $inquiry->id,
                    'user_id' => $user->id
                ]);
            }
            
            DB::commit();
            
            return redirect()->back()
                ->with('success', "Berhasil memperbaiki {$fixedCount} permintaan yang tidak terhubung dengan pelanggan.");
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error fixing orphaned inquiries', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbaiki permintaan: ' . $e->getMessage());
        }
    }
}
