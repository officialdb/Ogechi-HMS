<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Modules\CMS\Models\Post;

class PostSubmittedNotification extends Notification
{
    use Queueable;

    public $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): \Illuminate\Notifications\Messages\MailMessage
    {
        $url = route('modules.cms.edit', $this->post->id);

        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('New Post Submitted for Review')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('A new post titled "' . $this->post->title . '" has been submitted for review by ' . ($this->post->author->name ?? 'a Writer') . '.')
            ->action('Review Post', $url)
            ->line('Please review and approve or reject it.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'post_id' => $this->post->id,
            'title' => $this->post->title,
            'message' => 'A new post titled "' . $this->post->title . '" has been submitted for review.',
            'url' => route('modules.cms.edit', $this->post->id),
        ];
    }
}
