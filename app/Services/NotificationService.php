<?php

namespace App\Services;

use App\Events\NotificationSent;
use App\Models\Notification;
use App\Models\User;

class NotificationService {
    public function sendNotification(User $user, string $message) {
        $notification = new Notification();

        $notification->user_id = $user->id;
        $notification->message = $message;

        $notification->save();

        event(new NotificationSent($user, $message));
    }
}