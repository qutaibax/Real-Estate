<?php

namespace App\Services;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Str;



class NotificationService
{
    public function index()
    {
        return auth()->user()->notifications()
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function send($user, $title, $message, $type = 'basic')
    {
        DatabaseNotification::create([
            'id' => Str::uuid(),
            'type' => 'App\Notifications\Book',
            'notifiable_type' => 'App\Models\User',
            'notifiable_id' => $user->id,
            'data' => [
                'title' => $title,
                'message' => $message,
                'type' => $type,
            ],
        ]);

        return true;
    }

    public function markAsRead($notificationId): bool
    {
        $notification = auth()->user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();
        return true;
    }

    public function destroy($id): bool
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->delete();
        return true;
    }
}
