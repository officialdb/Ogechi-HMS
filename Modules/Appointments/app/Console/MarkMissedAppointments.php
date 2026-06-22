<?php

namespace Modules\Appointments\Console;

use Illuminate\Console\Command;
use Modules\Appointments\Models\Appointment;
use Carbon\Carbon;

class MarkMissedAppointments extends Command
{
    protected $signature = 'appointments:mark-missed';
    protected $description = 'Mark scheduled appointments that have passed by 1 hour as missed';

    public function handle()
    {
        $this->info('Checking for missed appointments...');

        $now = Carbon::now();

        // Get appointments where the datetime is more than 1 hour ago
        $appointments = Appointment::where('status', 'scheduled')->get();
        $count = 0;

        foreach ($appointments as $appointment) {
            $appointmentDateTime = Carbon::parse($appointment->appointment_date->format('Y-m-d') . ' ' . $appointment->appointment_time);
            
            if ($appointmentDateTime->copy()->addHour()->isPast()) {
                $appointment->update(['status' => 'missed']);
                $count++;
            }
        }

        $this->info("Successfully marked {$count} appointments as missed.");
    }
}
