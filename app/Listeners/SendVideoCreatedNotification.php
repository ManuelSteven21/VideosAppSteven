<?php

namespace App\Listeners;

use App\Events\VideoCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\VideoCreated as VideoCreatedNotification;
use App\Models\User;

class SendVideoCreatedNotification
{
    public function handle(VideoCreated $event)
    {
        $admins = User::where('super_admin', true)->get();

        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new \App\Mail\VideoCreatedMail($event->video));
        }

        Notification::send($admins, new VideoCreatedNotification($event->video));
    }

}
