<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class InquiryController extends Controller
{
    /**
     * Show the inquiry form with a specific service pre-selected.
     */
    public function create($serviceId = null)
    {
        // Get all active services
        $services = Service::where('is_active', true)->get();
        
        // Pre-select a service if specified
        $selectedService = null;
        if ($serviceId) {
            $selectedService = Service::findOrFail($serviceId);
        }
        
        return view('inquiry.form', compact('services', 'selectedService'));
    }

    /**
     * Store a new inquiry directly from the form.
     */
    public function store(Request $request)
    {
      try {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|regex:/^[0-9+\-\s()]+$/|min:10|max:15',
            'address' => 'required|string',
            'property_type' => 'required|string',
            'area_size' => 'required|numeric',
            'budget' => 'required|numeric',
            'description' => 'required|string',
            'status' => 'in:new,processing,completed,cancelled', // Optional, default to 'new'
            'admin_notes' => 'nullable|string',
            'start_date' => 'nullable|date',
            'schedule_flexibility' => 'nullable|string',
            'current_condition' => 'nullable|string',
        ], [
            'phone.regex' => 'Nomor telepon hanya boleh berisi angka, tanda +, -, spasi, dan tanda kurung.',
            'phone.min' => 'Nomor telepon minimal 10 digit.',
            'phone.max' => 'Nomor telepon maksimal 15 digit.',
        ]);

        DB::beginTransaction();

        try {
            // Create or get user
            $user = User::firstOrCreate(
                ['email' => $validated['email']],
                [
                    'name' => $validated['name'],
                    'phone' => $validated['phone'],
                    'password' => bcrypt(Str::random(10)),
                    'role' => 'customer'
                ]
            );

            // Create inquiry with all required fields
            $inquiry = Inquiry::create([
                'user_id' => $user->id,
                'service_id' => $validated['service_id'],
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'property_type' => $validated['property_type'],
                'area_size' => $validated['area_size'],
                'budget' => $validated['budget'],
                'description' => $validated['description'],
                'address' => $validated['address'],
                'status' => 'new'
            ]);

            // Broadcast new inquiry event to admin
            broadcast(new \App\Events\NewInquiryReceived($inquiry))->toOthers();

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Permintaan layanan berhasil dikirim!'
                ]);
            }

             return redirect()->route('home')
                           ->with('success', 'Permintaan layanan berhasil dikirim!');

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

    } catch (ValidationException $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Data yang dimasukkan tidak valid',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        Log::error('Inquiry creation failed: ' . $e->getMessage());
        
        return response()->json([
            'status' => 'error',
            'message' => 'Terjadi kesalahan saat memproses permintaan Anda.'
        ], 500);
    }

    }
    /**
     * Show inquiry form for a specific service.
     */
    public function inquire($serviceSlug)
    {
        // Find the service by slug
        $service = Service::where('slug', $serviceSlug)->where('is_active', true)->firstOrFail();
        
        // Get all active services for the form dropdown
        $services = Service::where('is_active', true)->get();
        
        // Pass the selected service to pre-select it in the form
        return view('inquiry.form', [
            'services' => $services,
            'selectedService' => $service
        ]);
    }

    public function update(Request $request, Inquiry $inquiry)
{
    try {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|regex:/^[0-9+\-\s()]+$/|min:10|max:15',
            'address' => 'required|string',
            'property_type' => 'required|string',
            'area_size' => 'required|numeric|min:1',
            'budget' => 'required|numeric|min:0|max:9999999999.99', // Sesuai dengan decimal(12,2)
            'description' => 'required|string',
            'current_condition' => 'required|string',
            'status' => 'required|in:new,contacted,in_progress,completed,cancelled',
            'start_date' => 'required|date',
            'schedule_flexibility' => 'required|string',
            'service_id' => 'required|exists:services,id',
        ]);

        DB::beginTransaction();
        
        try {
            $inquiry->update($validated);
            DB::commit();
            
            return redirect()
                ->route('admin.inquiries.show', $inquiry)
                ->with('success', 'Permintaan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    } catch (ValidationException $e) {
        return back()
            ->withErrors($e->errors())
            ->withInput();
    } catch (\Exception $e) {
        Log::error('Inquiry update failed: ' . $e->getMessage());
        return back()
            ->with('error', 'Terjadi kesalahan saat memperbarui permintaan.')
            ->withInput();
    }
}
}
