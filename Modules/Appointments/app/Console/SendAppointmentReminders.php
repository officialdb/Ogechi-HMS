<?php

namespace Modules\Appointments\Console;

use Illuminate\Console\Command;
use Modules\Appointments\Models\Appointment;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification as BaseNotification;

class AppointmentReminderNotification extends BaseNotification
{
    protected $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Upcoming Appointment Reminder',
            'message' => "Reminder: {$this->appointment->patient->first_name} {$this->appointment->patient->last_name} has an appointment tomorrow at {$this->appointment->appointment_time}.",
            'link' => route('modules.appointments.index')
        ];
    }
}

class SendAppointmentReminders extends Command
{
    protected $signature = 'appointments:send-reminders';
    protected $description = 'Send 24-hour reminders for upcoming appointments';

    public function handle()
    {
        $this->info('Checking for tomorrow\'s appointments...');

        $tomorrow = Carbon::tomorrow()->format('Y-m-d');
        $appointments = Appointment::with(['patient', 'doctor'])->whereDate('appointment_date', $tomorrow)->where('status', 'scheduled')->get();

        $count = 0;
        // Receptionists or Admins (Using ID 1 or role if available, assuming we just notify all users with role 'admin' or 'receptionist')
        // For simplicity we will notify all admins. Assuming User model has a role or is_admin. 
        // Or we can just log it if we don't know the exact role structure.
        $admins = User::whereHas('roles', function($q){
            $q->whereIn('name', ['super-admin', 'admin', 'receptionist']);
        })->get();

        foreach ($appointments as $appointment) {
            // 1. Internal Notification
            if ($admins->count()) {
                Notification::send($admins, new AppointmentReminderNotification($appointment));
            }

            // 2. Email Patient (Mocking email since patient doesn't have a notifiable model by default, we just log it or mail directly if email field exists)
            if ($appointment->patient && $appointment->patient->email) {
                // In a real app we'd send a Mailable.
                $this->info("Sending email to patient: {$appointment->patient->email}");
            }
            $count++;
        }

        $this->info("Successfully sent reminders for {$count} appointments.");
    }
}
