<?php

namespace App\Services\API\Admin\Notification;

use App\Interfaces\API\Admin\Notification\NotificationInterface;
use App\Models\AdminNotification;
use Illuminate\Http\Request;

class NotificationService implements NotificationInterface
{
    public function getNotifications()
    {
        return response()->json([
            'notifications' => AdminNotification::orderBy('created_at', 'DESC')->get(),
            'unread_notifications' =>  AdminNotification::unread()->count()
        ], 200);
    }

    public function setToReadNotification(int $id)
    {
        AdminNotification::where('id', $id)->update(['is_read' => true]);

        return response()->json([
            'notifications' => AdminNotification::orderBy('created_at', 'DESC')->get(),
            'unread_notifications' =>  AdminNotification::unread()->count()
        ], 200);
    }

    public function newNotification(Request $request)
    {
        AdminNotification::create($request->except('token'));
        return response()->json([
            'notifications' => AdminNotification::orderBy('created_at', 'DESC')->get(),
            'unread_notifications' =>  AdminNotification::unread()->count()
        ], 200);
    }

    public function destroyAllNotifications()
    {
        AdminNotification::truncate();
        return response()->json([
            'notifications' => AdminNotification::orderBy('created_at', 'DESC')->get(),
            'unread_notifications' =>  AdminNotification::unread()->count()
        ], 200);
    }
}
