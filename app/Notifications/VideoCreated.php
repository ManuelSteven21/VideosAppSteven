<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\Video;

class VideoCreated extends Notification implements ShouldQueue
{
    use Queueable;

    public $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function via($notifiable)
    {
        return ['broadcast', 'database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->video->title,
            'published_at' => $this->video->formatted_published_at,
            'url' => route('videos.show', $this->video->id),
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nou vídeo creat')
            ->line('S\'ha creat un nou vídeo: ' . $this->video->title)
            ->action('Veure vídeo', route('videos.show', $this->video->id))
            ->line('Gràcies per utilitzar la nostra plataforma!');
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'video_id'   => $this->video->id,
            'title'      => $this->video->title,
            'created_by' => $this->video->user->name ?? 'Desconegut',
        ]);
    }
}
