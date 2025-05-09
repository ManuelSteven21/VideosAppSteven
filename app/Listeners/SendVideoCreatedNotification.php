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
        \Log::info('Executant el listener SendVideoCreatedNotification...');

        $admins = User::where('super_admin', true)->get();
        \Log::info('Admins trobats: ' . $admins->count());

        foreach ($admins as $admin) {
            \Log::info('Enviant correu a: ' . $admin->email);

            Mail::to($admin->email)->send(new \App\Mail\VideoCreatedMail($event->video));
        }

        \Log::info('Enviant notificació broadcast...');
        Notification::send($admins, new VideoCreatedNotification($event->video));
    }

}
