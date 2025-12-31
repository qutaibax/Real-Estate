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
}

