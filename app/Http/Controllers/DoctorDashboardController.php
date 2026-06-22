<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorDashboardController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        if (!$doctor) {
            abort(403, 'Doctor profile not found.');
        }

        $upcomingAppointments = \Modules\Appointments\Models\Appointment::with('patient')
            ->where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', '>=', today())
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->limit(10)
            ->get();

        $todayAppointments = \Modules\Appointments\Models\Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', today())
            ->count();

        $totalPatients = \Modules\Appointments\Models\Appointment::where('doctor_id', $doctor->id)
            ->distinct('patient_id')
            ->count('patient_id');

        return view('doctor.dashboard', compact('doctor', 'upcomingAppointments', 'todayAppointments', 'totalPatients'));
    }
}
