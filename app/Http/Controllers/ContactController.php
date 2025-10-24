<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    /**
     * Handle contact form submission
     */
    public function send(Request $request)
    {
        // Validate form inputs
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create data array for email
        $contactData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
        ];

        try {
            // Send email
            Mail::to('info@ardfya.com')->send(new ContactFormMail($contactData));

            // Redirect with success message
            return redirect()->back()->with('success', 'Pesan Anda telah berhasil dikirim. Kami akan menghubungi Anda segera.');
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Contact form email error: ' . $e->getMessage());

            // Redirect with error message
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengirim pesan. Silakan coba lagi nanti atau hubungi kami melalui telepon.')
                ->withInput();
        }
    }
} 