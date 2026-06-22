<?php

namespace Modules\CMS\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Modules\CMS\Models\Post;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PostSubmittedNotification;

class PostSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_writer_can_submit_post_and_notifies_publishers()
    {
        $this->seed(\Database\Seeders\RoleAndPermissionSeeder::class);

        Notification::fake();

        $writer = User::factory()->create();
        $writer->assignRole('Writer');

        $publisher = User::factory()->create();
        $publisher->assignRole('Publisher');

        $post = Post::create([
            'title' => 'Test Post',
            'category' => 'General Health',
            'body' => 'Test Body',
            'user_id' => $writer->id,
            'approval_status' => 'draft',
        ]);

        $response = $this->actingAs($writer)->post(route('modules.cms.submit', $post));
        
        $response->assertRedirect();
        
        $this->assertEquals('submitted', $post->fresh()->approval_status);
        
        Notification::assertSentTo(
            [$publisher],
            PostSubmittedNotification::class
        );
    }
}
