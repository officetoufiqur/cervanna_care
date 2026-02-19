<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function read($id)
    {
        DB::table('notifications')
            ->where('id', $id)
            ->update(['admin_read_at' => now()]);

        return back();
    }

    public function getNotifications()
    {
        $user = Auth::user();
        $notifications = $user->unreadNotifications()
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Unread notifications retrieved successfully',
            'data' => $notifications,
        ], 200);
    }
}
