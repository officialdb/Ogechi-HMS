<?php

namespace Modules\Appointments\Providers;

use Nwidart\Modules\Support\ModuleServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class AppointmentsServiceProvider extends ModuleServiceProvider
{
    /**
     * The name of the module.
     */
    protected string $name = 'Appointments';

    /**
     * The lowercase version of the module name.
     */
    protected string $nameLower = 'appointments';

    protected array $commands = [
        \Modules\Appointments\Console\MarkMissedAppointments::class,
        \Modules\Appointments\Console\SendAppointmentReminders::class,
    ];

    /**
     * Provider classes to register.
     *
     * @var string[]
     */
    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];

    /**
     * Define module schedules.
     * 
     * @param $schedule
     */
    // protected function configureSchedules(Schedule $schedule): void
    // {
    //     $schedule->command('inspire')->hourly();
    // }
}
