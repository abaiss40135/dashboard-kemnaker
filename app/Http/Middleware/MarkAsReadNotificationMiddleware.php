<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MarkAsReadNotificationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('notification_id')){
            $notification = new \App\Http\Controllers\NotificationController();
            $notification->markAsRead($request->notification_id);
        }
        return $next($request);
    }
}
