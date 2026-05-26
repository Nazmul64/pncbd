<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffChat;
use App\Models\StaffChatMessage;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffChatController extends Controller
{
    // ══════════════════════════════════════════════════════════════════════════
    // ADMIN-SIDE — সব staff-এর তালিকা (A-Z by name)
    // GET /admin/staff-chat  →  admin.staff-chat.index
    // ══════════════════════════════════════════════════════════════════════════
    public function index()
    {
        // Employee / manager / sub-admin রোলে থাকা সব active user, A-Z
        $staffList = User::whereHas('roles', function ($q) {
                $q->whereIn('slug', ['employee', 'manager', 'sub-admin']);
            })
            ->orderBy('name', 'asc')
            ->get();

        // প্রতিটির chat thread load করো (unread count সহ)
        $staffList->each(function ($staff) {
            $chat = StaffChat::where('staff_id', $staff->id)->first();
            $staff->chat_thread   = $chat;
            $staff->unread_admin  = $chat ? $chat->unreadForAdmin() : 0;
        });

        // মোট unread
        $totalUnread = StaffChatMessage::where('sender_type', 'staff')
            ->where('is_read', false)
            ->count();

        return view('admin.staff_chat.index', compact('staffList', 'totalUnread'));
    }

    // ══════════════════════════════════════════════════════════════════════════
    // ADMIN-SIDE — নির্দিষ্ট staff-এর সাথে chat window
    // GET /admin/staff-chat/{staffId}  →  admin.staff-chat.show
    // ══════════════════════════════════════════════════════════════════════════
    public function show(int $staffId)
    {
        $staffUser = User::findOrFail($staffId);

        // thread খুঁজো বা তৈরি করো
        $chat = StaffChat::forStaff($staffId);

        // Messages
        $messages = $chat->messages()
            ->with('sender')
            ->orderBy('id', 'asc')
            ->get();

        // Admin open করলে staff-এর messages read করে দাও
        $chat->messages()
            ->where('sender_type', 'staff')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // Sidebar-এর জন্য staff list (A-Z)
        $staffList = User::whereHas('roles', function ($q) {
                $q->whereIn('slug', ['employee', 'manager', 'sub-admin']);
            })
            ->orderBy('name', 'asc')
            ->get();

        $staffList->each(function ($staff) {
            $t = StaffChat::where('staff_id', $staff->id)->first();
            $staff->chat_thread  = $t;
            $staff->unread_admin = $t ? $t->unreadForAdmin() : 0;
        });

        return view('admin.staff_chat.show', compact('staffUser', 'chat', 'messages', 'staffList'));
    }

    // ══════════════════════════════════════════════════════════════════════════
    // ADMIN-SIDE — reply পাঠায়
    // POST /admin/staff-chat/{staffId}/reply  →  admin.staff-chat.reply
    // ══════════════════════════════════════════════════════════════════════════
    public function reply(Request $request, int $staffId): JsonResponse
    {
        $request->validate(['message' => 'required|string|max:2000']);

        $chat = StaffChat::forStaff($staffId);

        $msg = StaffChatMessage::create([
            'staff_chat_id' => $chat->id,
            'sender_type'   => 'admin',
            'sender_id'     => Auth::id(),
            'message'       => $request->message,
            'is_read'       => false,
        ]);

        $chat->update(['last_activity_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => $this->formatMsg($msg),
        ]);
    }

    // ══════════════════════════════════════════════════════════════════════════
    // ADMIN-SIDE — নতুন message poll করো
    // GET /admin/staff-chat/{staffId}/messages?after_id=XX
    // ══════════════════════════════════════════════════════════════════════════
    public function getMessages(Request $request, int $staffId): JsonResponse
    {
        $chat    = StaffChat::forStaff($staffId);
        $afterId = (int) $request->input('after_id', 0);

        $msgs = $chat->messages()
            ->with('sender')
            ->when($afterId > 0, fn($q) => $q->where('id', '>', $afterId))
            ->orderBy('id', 'asc')
            ->get();

        // Auto-mark staff messages as read
        $chat->messages()
            ->where('sender_type', 'staff')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'success'  => true,
            'messages' => $msgs->map(fn($m) => $this->formatMsg($m))->values(),
        ]);
    }

    // ══════════════════════════════════════════════════════════════════════════
    // ADMIN-SIDE — মোট unread badge count
    // GET /admin/staff-chat/unread-count  →  admin.staff-chat.unread
    // ══════════════════════════════════════════════════════════════════════════
    public function adminUnreadCount(): JsonResponse
    {
        $count = StaffChatMessage::where('sender_type', 'staff')
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    // ══════════════════════════════════════════════════════════════════════════
    // STAFF-SIDE — নিজের chat দেখো (শুধু নিজেরটা)
    // GET /admin/emplee/staff-chat  →  admin.emplee.staff-chat.index
    // ══════════════════════════════════════════════════════════════════════════
    public function staffIndex()
    {
        $staffId = Auth::id();
        $chat    = StaffChat::forStaff($staffId);

        $messages = $chat->messages()
            ->with('sender')
            ->orderBy('id', 'asc')
            ->get();

        // Admin-এর messages পড়া হয়ে গেছে
        $chat->messages()
            ->where('sender_type', 'admin')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('emplee.staff_chat.index', compact('chat', 'messages'));
    }

    // ══════════════════════════════════════════════════════════════════════════
    // STAFF-SIDE — নিজে reply দেয়
    // POST /admin/emplee/staff-chat/reply  →  admin.emplee.staff-chat.reply
    // ══════════════════════════════════════════════════════════════════════════
    public function staffReply(Request $request): JsonResponse
    {
        $request->validate(['message' => 'required|string|max:2000']);

        $staffId = Auth::id();
        $chat    = StaffChat::forStaff($staffId);

        $msg = StaffChatMessage::create([
            'staff_chat_id' => $chat->id,
            'sender_type'   => 'staff',
            'sender_id'     => $staffId,
            'message'       => $request->message,
            'is_read'       => false,
        ]);

        $chat->update(['last_activity_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => $this->formatMsg($msg),
        ]);
    }

    // ══════════════════════════════════════════════════════════════════════════
    // STAFF-SIDE — নতুন message poll (নিজের chat)
    // GET /admin/emplee/staff-chat/messages?after_id=XX
    // ══════════════════════════════════════════════════════════════════════════
    public function staffGetMessages(Request $request): JsonResponse
    {
        $staffId = Auth::id();
        $chat    = StaffChat::forStaff($staffId);
        $afterId = (int) $request->input('after_id', 0);

        $msgs = $chat->messages()
            ->with('sender')
            ->when($afterId > 0, fn($q) => $q->where('id', '>', $afterId))
            ->orderBy('id', 'asc')
            ->get();

        // Auto-mark admin messages as read
        $chat->messages()
            ->where('sender_type', 'admin')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'success'  => true,
            'messages' => $msgs->map(fn($m) => $this->formatMsg($m))->values(),
        ]);
    }

    // ══════════════════════════════════════════════════════════════════════════
    // STAFF-SIDE — নিজের unread count (admin পাঠিয়েছে)
    // GET /admin/emplee/staff-chat/unread-count  →  admin.emplee.staff-chat.unread
    // ══════════════════════════════════════════════════════════════════════════
    public function staffUnreadCount(): JsonResponse
    {
        $staffId = Auth::id();
        $chat    = StaffChat::where('staff_id', $staffId)->first();

        $count = $chat
            ? $chat->messages()->where('sender_type', 'admin')->where('is_read', false)->count()
            : 0;

        return response()->json(['count' => $count]);
    }

    // ── Private formatter ──────────────────────────────────────────────────────
    private function formatMsg(StaffChatMessage $m): array
    {
        return [
            'id'          => $m->id,
            'message'     => $m->message,
            'sender_type' => $m->sender_type,
            'sender_name' => $m->sender_type === 'admin' ? 'Admin' : ($m->sender?->name ?? 'Staff'),
            'is_own'      => ($m->sender_type === 'admin') === (Auth::user()?->isAdmin() ?? false),
            'time'        => $m->created_at->format('g:i A'),
            'is_read'     => (bool) $m->is_read,
        ];
    }
}
