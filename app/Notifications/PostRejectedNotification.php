<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Modules\CMS\Models\Post;

class PostRejectedNotification extends Notification
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
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Post Review Update – Action Needed')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Unfortunately, your post titled "' . $this->post->title . '" has been reviewed and could not be approved at this time.')
            ->action('Edit & Resubmit', route('modules.cms.edit', $this->post->id))
            ->line('Please revise your post and resubmit it for review.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'post_id' => $this->post->id,
            'title'   => $this->post->title,
            'message' => 'Your post titled "' . $this->post->title . '" has been rejected.',
            'url'     => route('modules.cms.edit', $this->post->id),
        ];
    }
}
