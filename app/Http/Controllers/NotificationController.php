<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Fetch latest notifications
    public function index(): JsonResponse
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->take(15)
            ->get()
            ->map(fn($n) => [
                'id'         => $n->id,
                'message'    => $n->message,
                'time'       => $n->created_at->diffForHumans(),
                'unread'     => is_null($n->read_at),
                'icon'       => $n->icon,
                'icon_bg'    => $n->icon_bg,
                'icon_color' => $n->icon_color,
                'url'        => $n->url,
            ]);

        $unreadCount = Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count'  => $unreadCount,
        ]);
    }

    // Mark single as read
    public function markRead(Notification $notification): JsonResponse
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    // Mark all as read
    public function markAllRead(): JsonResponse
    {
        Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    // Delete all read notifications for this user
    public function clearAll(): JsonResponse
    {
        Notification::where('user_id', Auth::id())
            ->whereNotNull('read_at')
            ->delete();

        return response()->json(['success' => true]);
    }
}