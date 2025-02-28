<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Helpers\UserHelper;
use PHPUnit\Framework\Attributes\Test;

class VideoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        UserHelper::createPermissions();
    }

    #[Test]
    public function user_without_permissions_can_see_default_videos_page()
    {
        $user = UserHelper::createRegularUser();

        $this->actingAs($user)
            ->get(route('videos.index'))
            ->assertStatus(200);
    }

    #[Test]
    public function user_with_permissions_can_see_default_videos_page()
    {
        $user = UserHelper::createVideoManagerUser();

        $this->actingAs($user)
            ->get(route('videos.index'))
            ->assertStatus(200);
    }

    #[Test]
    public function users_cannot_view_non_existing_video()
    {
        // Fer la petició per veure un vídeo que no existeix
        $response = $this->get(route('videos.show', 9999));

        // Verificar que la resposta és un 404
        $response->assertStatus(404);
    }
}
