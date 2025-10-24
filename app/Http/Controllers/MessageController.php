<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Message;
use App\Models\Project;
use App\Models\User;
use App\Models\Chat;
use App\Notifications\NewMessageNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MessageController extends Controller
{
    /**
     * Display the customer chat interface
     */
    public function customerChat(): View
    {
        $user = Auth::user();
        
        // Get inquiries with unread message counts
        $inquiries = $user->inquiries()
            ->with('service')
            ->select('inquiries.*')
            ->addSelect([
                'unread_messages_count' => Message::selectRaw('COUNT(*)')
                    ->whereColumn('inquiry_id', 'inquiries.id')
                    ->where('is_from_admin', true)
                    ->where('is_read', false)
            ])
            ->orderByDesc(
                Message::select('created_at')
                    ->whereColumn('inquiry_id', 'inquiries.id')
                    ->orderByDesc('created_at')
                    ->limit(1)
            )
            ->orderByDesc('inquiries.created_at')
            ->get();
        
        // Get projects with unread message counts
        $projects = $user->projects()
            ->with('service')
            ->select('projects.*')
            ->addSelect([
                'unread_messages_count' => Message::selectRaw('COUNT(*)')
                    ->whereColumn('project_id', 'projects.id')
                    ->where('is_from_admin', true)
                    ->where('is_read', false)
            ])
            ->orderByDesc(
                Message::select('created_at')
                    ->whereColumn('project_id', 'projects.id')
                    ->orderByDesc('created_at')
                    ->limit(1)
            )
            ->orderByDesc('projects.created_at')
            ->get();
        
        // Get customer chat messages
        $chatMessages = Chat::where('customer_id', $user->id)
            ->orderBy('created_at', 'asc')
            ->get();

        // Auto mark unread messages from admin as read when customer opens messages page
        Chat::where('customer_id', $user->id)
            ->where('is_from_admin', true)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // Also mark unread messages in messages table as read
        Message::where('user_id', $user->id)
            ->where('is_from_admin', true)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('messages.customer', compact('inquiries', 'projects', 'chatMessages'));
    }

    /**
     * Get messages for a specific inquiry or project
     */
    public function getMessages(Request $request): JsonResponse
    {
        $request->validate([
            'inquiry_id' => 'nullable|exists:inquiries,id',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        $user = Auth::user();
        $messages = [];

        if ($request->has('inquiry_id')) {
            $inquiry = Inquiry::findOrFail($request->inquiry_id);
            if ($user->isAdmin() || $inquiry->user_id == $user->id) {
                $messages = Message::where('inquiry_id', $inquiry->id)
                    ->orderBy('created_at')
                    ->get();
            }
        } elseif ($request->has('project_id')) {
            $project = Project::findOrFail($request->project_id);
            if ($user->isAdmin() || $project->user_id == $user->id) {
                $messages = Message::where('project_id', $project->id)
                    ->orderBy('created_at')
                    ->get();
            }
        } else {
            // Get general chat messages
            $messages = Chat::where('customer_id', $user->id)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return response()->json($messages);
    }

    /**
     * Send a new message
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $request->validate([
            'inquiry_id' => 'nullable|exists:inquiries,id',
            'project_id' => 'nullable|exists:projects,id',
            'message' => 'required|string',
        ]);

        $user = Auth::user();
        $isFromAdmin = $user->isAdmin();

        // Handle general chat message
        if (!$request->has('inquiry_id') && !$request->has('project_id')) {
            $chat = Chat::create([
                'customer_id' => $user->id,
                'message' => $request->message,
                'is_from_admin' => false
            ]);
            
            // Notify admin about new message
            $adminUser = User::where('role', 'admin')->first();
            if ($adminUser) {
                $adminUser->notify(new NewMessageNotification($chat, 'chat', 'Customer Chat'));
            }
            
            return response()->json([
                'success' => true,
                'message' => $chat
            ]);
        }

        $message = new Message();
        $message->user_id = $user->id;
        $message->message = $request->message;
        $message->is_from_admin = $isFromAdmin;

        // Set the appropriate relationship and prepare notification data
        $chatType = null;
        $chatTitle = null;
        $recipientUser = null;

        if ($request->has('inquiry_id')) {
            $inquiry = Inquiry::findOrFail($request->inquiry_id);
            if ($user->isAdmin() || $inquiry->user_id == $user->id) {
                $message->inquiry_id = $inquiry->id;
                $chatType = 'inquiry';
                $chatTitle = $inquiry->service->name;
                
                // Set recipient - if admin is sending, notify the customer, and vice versa
                $recipientUser = $isFromAdmin ? User::find($inquiry->user_id) : User::where('role', 'admin')->first();
            }
        } elseif ($request->has('project_id')) {
            $project = Project::findOrFail($request->project_id);
            if ($user->isAdmin() || $project->user_id == $user->id) {
                $message->project_id = $project->id;
                $chatType = 'project';
                $chatTitle = $project->title;
                
                // Set recipient - if admin is sending, notify the customer, and vice versa
                $recipientUser = $isFromAdmin ? User::find($project->user_id) : User::where('role', 'admin')->first();
            }
        }

        $message->save();

        // Send notification to the recipient
        if ($recipientUser) {
            $recipientUser->notify(new NewMessageNotification($message, $chatType, $chatTitle));
        }

        // Broadcast message event for real-time updates
        if ($isFromAdmin) {
            // Admin sending to customer
            broadcast(new \App\Events\NewChatMessage((object)[
                'id' => $message->id,
                'message' => $message->message,
                'is_from_admin' => true,
                'created_at' => $message->created_at,
                'customer_id' => $recipientUser ? $recipientUser->id : null,
                'admin_id' => $user->id,
            ]))->toOthers();
        } else {
            // Customer sending to admin
            broadcast(new \App\Events\NewChatMessage((object)[
                'id' => $message->id,
                'message' => $message->message,
                'is_from_admin' => false,
                'created_at' => $message->created_at,
                'customer_id' => $user->id,
                'admin_id' => null,
            ]))->toOthers();
        }

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * Mark messages as read
     */
    public function markAsRead(Request $request): JsonResponse
    {
        $request->validate([
            'message_ids' => 'required|array',
            'message_ids.*' => 'exists:messages,id',
        ]);

        $user = Auth::user();
        $isAdmin = $user->isAdmin();

        $query = Message::whereIn('id', $request->message_ids);
        
        // Only mark messages that are directed to the current user type
        if ($isAdmin) {
            $query->where('is_from_admin', false);
        } else {
            $query->where('is_from_admin', true);
        }

        $query->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}
