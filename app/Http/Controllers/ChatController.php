<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Database\QueryException;

class ChatController extends Controller
{
    /**
     * Menampilkan antarmuka chat admin
     */
    public function adminChat(): View
    {
        return view('admin.chat');
    }

    /**
     * Get list of customers with chats
     */    public function getCustomers()
    {
        $customers = User::where('role', 'customer')
            ->select('users.*')
            ->with(['chats' => function($query) {
                $query->whereNull('deleted_at')->latest()->take(1);
            }])
            ->orderBy('name')
            ->get()
            ->map(function($customer) {
                $unreadCount = Chat::where('customer_id', $customer->id)
                    ->where('is_from_admin', false)
                    ->where('is_read', false)
                    ->count();
                    
                $lastMessage = $customer->chats->first();
                
                return [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'last_message' => $lastMessage ? $lastMessage->message : null,
                    'last_message_time' => $lastMessage ? $lastMessage->created_at : null,
                    'unread' => $unreadCount
                ];
            });

        return response()->json($customers);
    }

    /**
     * Menyimpan pesan chat baru dari pelanggan
     */
    public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'message' => 'required_without:file|string|max:1000',
            'file' => 'required_without:message|file|max:10240|mimes:jpeg,png,jpg,gif,pdf,doc,docx'
        ], [
            'message.required_without' => 'Pesan atau file harus diisi',
            'file.required_without' => 'Pesan atau file harus diisi',
            'file.max' => 'Ukuran file maksimal 10MB'
        ]);

        $chatData = [
            'customer_id' => auth()->id(),
            'message' => $request->message ?? '',
            'is_from_admin' => false,
            'is_read' => false
        ];

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            // Simpan file dalam folder berdasarkan tipe
            $folder = $file->getMimeType() ? explode('/', $file->getMimeType())[0] : 'others';
            $filePath = $file->storeAs("chat-files/{$folder}", $fileName, 'public');
            
            // Set file data
            $chatData['file_url'] = asset('storage/' . $filePath);
            $chatData['file_name'] = $file->getClientOriginalName();
            $chatData['file_type'] = $file->getMimeType();
            $chatData['file_size'] = $file->getSize();
        }

        $chat = Chat::create($chatData);
        $chat->load('customer');

        broadcast(new NewChatMessage($chat))->toOthers();

        return response()->json([
            'status' => 'sukses',
            'pesan' => 'Pesan berhasil dikirim',
            'data' => $chat
        ]);

    } catch (QueryException $e) {
        \Log::error('Error database: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'pesan' => 'Terjadi kesalahan pada database',
        ], 500);
    } catch (\Exception $e) {
        \Log::error('Error umum: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'pesan' => 'Terjadi kesalahan yang tidak terduga',
        ], 500);
    }
}

    /**
     * Store admin reply to a customer
     */

    public function adminReply(Request $request, $customerId)
    {
        try {
            $validated = $request->validate([
                'file' => 'required_without:message|file|max:10240'
            ]);

            $customer = User::where('role', 'customer')->findOrFail($customerId);
            
            $chatData = [
                'customer_id' => $customerId,
                'admin_id' => auth()->id(),
                'message' => $request->message ?? '',
                'is_from_admin' => true,
                'is_read' => false
            ];

            // Handle file upload
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('chat-files', $fileName, 'public');
                
                $chatData['file_url'] = asset('storage/' . $filePath);
                $chatData['file_name'] = $file->getClientOriginalName();
                $chatData['file_type'] = $file->getMimeType();
                $chatData['file_size'] = $file->getSize();
            }

        //      // Perbaikan handling file upload
        // if ($request->hasFile('file')) {
        //     $file = $request->file('file');
        //     $fileName = time() . '_' . $file->getClientOriginalName();
        //     // Simpan file dalam folder berdasarkan tipe
        //     $folder = $file->getMimeType() ? explode('/', $file->getMimeType())[0] : 'others';
        //     $filePath = $file->storeAs("chat-files/{$folder}", $fileName, 'public');
            
        //     // Pastikan URL yang disimpan benar
        //     $chatData['file_url'] = Storage::url($filePath); // Gunakan Storage::url
        //     $chatData['file_name'] = $file->getClientOriginalName();
        //     $chatData['file_type'] = $file->getMimeType();
        //     $chatData['file_size'] = $file->getSize();
        // }


            $chat = Chat::create($chatData);
            $chat->load(['customer', 'admin']);
            
            broadcast(new NewChatMessage($chat))->toOthers();

            return response()->json([
                'status' => 'success',
                'data' => $chat
            ]);

        } catch (\Exception $e) {
            \Log::error('Error sending admin reply: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send message'
            ], 500);
        }
    }

    /**
     * Get messages for a specific customer
     */
    public function getMessages(Request $request)
    {
        // If admin, use customer_id from request, otherwise use authenticated user id
        $customerId = Auth::user()->role === 'admin' 
            ? $request->input('customer_id')
            : Auth::id();
            
        if (!$customerId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Customer ID is required'
            ], 400);
        }

        $messages = Chat::where('customer_id', $customerId)
            ->with(['customer', 'admin'])
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    /**
     * Mark messages as read
     */
    public function markAsRead(Request $request)
    {
        try {
            $validated = $request->validate([
                'message_ids' => 'required|array',
                'message_ids.*' => 'exists:chats,id'
            ]);

            $isAdmin = Auth::user()->role === 'admin';

            Chat::whereIn('id', $validated['message_ids'])
                ->where('is_from_admin', !$isAdmin)
                ->update(['is_read' => true]);

            return response()->json([
                'status' => 'success',
                'message' => 'Messages marked as read'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error marking messages as read: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to mark messages as read'
            ], 500);
        }
    }

    /**
     * Get all chats grouped by customer
     */
    public function getAllChats()
    {
        $chats = Chat::with(['customer', 'admin'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('customer_id')
            ->toArray();

        return response()->json($chats);
    }
}
