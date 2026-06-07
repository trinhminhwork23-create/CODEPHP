<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function latest(Request $request)
    {
        $since = $request->query('since', now()->subMinutes(1)->timestamp);
        $timestamp = date('Y-m-d H:i:s', $since / 1000);

        $newActivities = ActivityLog::where('created_at', '>', $timestamp)->count();

        return response()->json([
            'new_activities' => $newActivities,
            'timestamp' => now()->timestamp
        ]);
    }

    public function index()
    {
        $notifications = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.notifications.index', compact('notifications'));
    }

    public function dropdown()
    {
        $recentNotifications = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $unreadCount = ActivityLog::where('created_at', '>', now()->subHours(24))->count();

        return response()->json([
            'notifications' => $recentNotifications,
            'unread_count' => $unreadCount
        ]);
    }
}
