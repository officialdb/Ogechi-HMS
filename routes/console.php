<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Pharmacy Jobs
Schedule::command('pharmacy:check-status')->dailyAt('00:00');

// Billing Jobs
Schedule::command('billing:mark-overdue')->dailyAt('00:00');

// Appointment Jobs
Schedule::command('appointments:send-reminders')->dailyAt('08:00');
Schedule::command('appointments:mark-missed')->hourly();
