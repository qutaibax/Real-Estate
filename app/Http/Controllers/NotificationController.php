<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\NotificationService;

class NotificationController extends Controller
{
    public function Notification(NotificationService $service)
    {
        return response()->json([
            'status' => true,
            'data' => $service->index()
        ]);
    }

    public function markAsRead(NotificationService $service,$id)
    {
        $service->markAsRead($id);
        return response()->json([
            'status' => true,
            'message' => 'Notification marked as read'
        ],200);
    }
    public function deleteNotification(NotificationService $service,$id)
    {
        $service->destroy($id);
        return response()->json([
            'status' => true,
            'message' => 'Notification deleted successfully'
        ],200);
    }

}

