<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Modules\CMS\Models\Post;

class PostApprovedNotification extends Notification
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
            ->subject('🎉 Your Post Has Been Published!')
            ->greeting('Great news, ' . $notifiable->name . '!')
            ->line('Your post titled "' . $this->post->title . '" has been approved and is now live on the hospital blog.')
            ->action('View Blog', route('website.blog.show', $this->post->slug))
            ->line('Thank you for your contribution!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'post_id' => $this->post->id,
            'title'   => $this->post->title,
            'message' => 'Your post titled "' . $this->post->title . '" has been approved and published.',
            'url'     => route('modules.cms.index'),
        ];
    }
}
