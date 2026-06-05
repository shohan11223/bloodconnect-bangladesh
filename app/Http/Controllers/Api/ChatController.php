<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LiveChat;
use App\Models\ChatMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function startChat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'visitor_name' => 'nullable|string|max:255',
            'visitor_email' => 'nullable|email',
            'visitor_phone' => 'nullable|string|max:20',
            'topic' => 'nullable|string|max:500',
        ]);

        $chat = LiveChat::create([
            'session_id' => \Str::uuid(),
            'user_id' => auth()->id(),
            'visitor_name' => $validated['visitor_name'] ?? 'অতিথি',
            'visitor_email' => $validated['visitor_email'],
            'visitor_phone' => $validated['visitor_phone'],
            'topic' => $validated['topic'],
            'status' => 'waiting',
        ]);

        return response()->json($chat, 201);
    }

    public function sendMessage(Request $request, $sessionId): JsonResponse
    {
        $chat = LiveChat::where('session_id', $sessionId)->firstOrFail();

        $validated = $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $message = ChatMessage::create([
            'live_chat_id' => $chat->id,
            'sender_id' => auth()->id(),
            'sender_type' => auth()->check() ? 'user' : 'guest',
            'sender_name' => auth()->user()?->name ?? $chat->visitor_name,
            'message' => $validated['message'],
        ]);

        $chat->increment('message_count');
        $chat->update(['last_message_at' => now()]);

        return response()->json($message, 201);
    }

    public function getMessages($sessionId): JsonResponse
    {
        $chat = LiveChat::where('session_id', $sessionId)->firstOrFail();
        $messages = $chat->messages()->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }

    public function closeChat($sessionId): JsonResponse
    {
        $chat = LiveChat::where('session_id', $sessionId)->firstOrFail();
        $chat->close();

        return response()->json(['message' => 'চ্যাট বন্ধ করা হয়েছে'], 200);
    }
}