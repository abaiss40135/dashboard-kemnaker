<?php

namespace App\Http\Controllers;


class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function markAsRead($notification_id)
    {

        $notification = auth()->user()->unreadNotifications()->where('id', $notification_id)->first();
        if ($notification) {
            $notification->markAsRead();
        }
        return $this->responseSuccess([
            'message' => 'Notification marked as read',
        ]);
    }
}
