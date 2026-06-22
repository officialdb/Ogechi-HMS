<?php

namespace Modules\Appointments\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Appointments\Models\Appointment;
use Modules\Patients\Models\Patient;
use Modules\Doctors\Models\Doctor;

class AppointmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user         = $request->user();
        $doctorRecord = $user->hasRole('Doctor') ? $user->doctor : null;

        $query = Appointment::with(['patient', 'doctor'])
            ->when($doctorRecord, fn($q) => $q->where('doctor_id', $doctorRecord->id)
                ->orWhereHas('patient', fn($p) => $p->where('assigned_doctor_id', $doctorRecord->id))
            );

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(fn($q) => $q
                ->whereHas('patient', fn($p) => $p
                    ->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('patient_number', 'like', "%{$search}%")
                )
                ->orWhereHas('doctor', fn($d) => $d
                    ->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                )
            );
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Calendar View Logic
        if ($request->view === 'calendar') {
            $allAppointments = $query->get()->map(function ($apt) {
                $colors = [
                    'pending'   => '#f59e0b',
                    'confirmed' => '#3b82f6',
                    'completed' => '#10b981',
                    'cancelled' => '#94a3b8',
                ];

                $patientName = $apt->patient
                    ? ($apt->patient->first_name . ' ' . $apt->patient->last_name)
                    : 'Unknown Patient';

                $doctorName = $apt->doctor
                    ? 'Dr. ' . $apt->doctor->last_name
                    : 'Unassigned';

                // Build a full ISO-8601 datetime string FullCalendar can parse
                $time = \Carbon\Carbon::parse($apt->appointment_time)->format('H:i:s');
                $start = $apt->appointment_date->format('Y-m-d') . 'T' . $time;

                return [
                    'id'    => $apt->id,
                    'title' => $patientName . ' — ' . $doctorName,
                    'start' => $start,
                    'url'   => route('modules.appointments.show', $apt),
                    'color' => $colors[$apt->status] ?? '#3b82f6',
                    'extendedProps' => [
                        'status' => $apt->status,
                        'reason' => $apt->reason ?? '',
                    ],
                ];
            });

            return view('appointments::calendar', compact('allAppointments'));
        }

        $appointments = $query->latest('appointment_date')->paginate(10)->withQueryString();

        return view('appointments::index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user         = auth()->user();
        $doctorRecord = $user->hasRole('Doctor') ? $user->doctor : null;

        // Doctors only book for their own patients
        $patients = Patient::select('id', 'first_name', 'last_name', 'patient_number')
            ->when($doctorRecord, fn($q) => $q->where('assigned_doctor_id', $doctorRecord->id))
            ->orderBy('first_name')
            ->get();

        $doctors = Doctor::where('status', '!=', 'inactive')
            ->select('id', 'first_name', 'last_name', 'specialization')
            ->orderBy('first_name')
            ->get();

        return view('appointments::create', compact('patients', 'doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id'       => 'required|exists:patients,id',
            'doctor_id'        => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'status'           => 'required|in:pending,confirmed,completed,cancelled',
            'reason'           => 'required|string|max:255',
            'notes'            => 'nullable|string',
        ]);

        Appointment::create($validated);

        return redirect()->route('modules.appointments.index')
                         ->with('success', 'Appointment scheduled successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor']);
        return view('appointments::show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        $patients = Patient::select('id', 'first_name', 'last_name', 'patient_number')->orderBy('first_name')->get();
        $doctors = Doctor::where('status', '!=', 'inactive')->select('id', 'first_name', 'last_name', 'specialization')->orderBy('first_name')->get();
        
        return view('appointments::edit', compact('appointment', 'patients', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id'       => 'required|exists:patients,id',
            'doctor_id'        => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i|date_format:H:i:s', // HTML time inputs can send either
            'status'           => 'required|in:pending,confirmed,completed,cancelled',
            'reason'           => 'required|string|max:255',
            'notes'            => 'nullable|string',
        ]);
        
        // Handle time format normalisation if it came as H:i:s
        if (strlen($validated['appointment_time']) === 8) {
            $validated['appointment_time'] = substr($validated['appointment_time'], 0, 5);
        }

        $appointment->update($validated);

        return redirect()->route('modules.appointments.show', $appointment)
                         ->with('success', 'Appointment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('modules.appointments.index')
                         ->with('success', 'Appointment cancelled and removed.');
    }
}
