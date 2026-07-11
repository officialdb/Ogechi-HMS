<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DoctorInviteNotification extends Notification
{
    use Queueable;

    public $token;
    public $doctorName;

    /**
     * Create a new notification instance.
     */
    public function __construct($token, $doctorName)
    {
        $this->token = $token;
        $this->doctorName = $doctorName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('doctor.invite.show', ['token' => $this->token]);

        return (new MailMessage)
                    ->from(env('MAIL_FROM_ADDRESS', 'no-reply@ogechihospital.org'), env('MAIL_FROM_NAME', 'Ogechi Hospital'))
                    ->subject('Welcome to Ogechi HMS - Doctor Registration')
                    ->greeting("Hello {$this->doctorName},")
                    ->line('You have been invited to join the Ogechi Hospital Management System as a Doctor.')
                    ->line('Please click the button below to verify your account and set your password.')
                    ->action('Complete Registration', $url)
                    ->line('This link will expire in 7 days.')
                    ->line('Thank you for joining our team!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
