<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Video;

class VideoCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function build()
    {
        return $this->subject('Nou vídeo creat')
            ->view('emails.video_created');
    }
}
