<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use App\Events\VideoCreated;
use App\Notifications\VideoCreated as VideoCreatedNotification;
use App\Models\User;
use App\Models\Video;

class VideoNotificationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_video_created_event_is_dispatched(): void
    {
        Event::fake();

        /** @var \App\Models\Video $video */
        $video = Video::factory()->create();

        event(new VideoCreated($video));

        Event::assertDispatched(VideoCreated::class, function ($event) use ($video) {
            return $event->video->id === $video->id;
        });
    }

    public function test_push_notification_is_sent_when_video_is_created(): void
    {
        Notification::fake();

        $admin = User::factory()->create(['super_admin' => true]);
        /** @var \App\Models\Video $video */
        $video = Video::factory()->create();

        event(new VideoCreated($video));

        Notification::assertSentTo(
            [$admin],
            VideoCreatedNotification::class,
            function ($notification, $channels) use ($video) {
                return $notification->video->id === $video->id
                    && in_array('broadcast', $channels);
            }
        );
    }
}
