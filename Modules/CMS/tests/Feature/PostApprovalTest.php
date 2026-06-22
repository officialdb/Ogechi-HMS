<?php

namespace Modules\CMS\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Modules\CMS\Models\Post;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PostApprovedNotification;
use App\Notifications\PostRejectedNotification;

class PostApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_publisher_can_approve_post_and_notifies_writer()
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
            'approval_status' => 'submitted',
        ]);

        $response = $this->actingAs($publisher)->post(route('modules.cms.approve', $post));
        $response->assertRedirect();

        $this->assertEquals('approved', $post->fresh()->approval_status);
        $this->assertNotNull($post->fresh()->published_at);

        Notification::assertSentTo(
            [$writer],
            PostApprovedNotification::class
        );
    }

    public function test_publisher_can_reject_post_and_notifies_writer()
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
            'approval_status' => 'submitted',
        ]);

        $response = $this->actingAs($publisher)->post(route('modules.cms.reject', $post));
        $response->assertRedirect();

        $this->assertEquals('rejected', $post->fresh()->approval_status);

        Notification::assertSentTo(
            [$writer],
            PostRejectedNotification::class
        );
    }
}
