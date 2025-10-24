<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
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
     * Show the profile page.
     */
    public function index(): View
    {
        // Check if user is customer
        if ($redirect = $this->checkCustomerRole()) {
            return $redirect;
        }

        $user = Auth::user();
        return view('customer.profile', compact('user'));
    }

    /**
     * Show the edit profile form.
     */
    public function edit(): View
    {
        // Check if user is customer
        if ($redirect = $this->checkCustomerRole()) {
            return $redirect;
        }

        $user = Auth::user();
        return view('customer.profile-edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        // Check if user is customer
        if ($redirect = $this->checkCustomerRole()) {
            return $redirect;
        }

        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user->update($validated);

        return redirect()->route('customer.profile')
                        ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Show the change password form.
     */
    public function showChangePasswordForm(): View
    {
        // Check if user is customer
        if ($redirect = $this->checkCustomerRole()) {
            return $redirect;
        }

        return view('customer.change-password');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        // Check if user is customer
        if ($redirect = $this->checkCustomerRole()) {
            return $redirect;
        }

        $validated = $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($validated['current_password'], $user->password)) {
            return redirect()->back()
                           ->withErrors(['current_password' => 'Password saat ini tidak benar.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($validated['password'])
        ]);

        return redirect()->route('customer.profile')
                        ->with('success', 'Password berhasil diubah.');
    }
}
