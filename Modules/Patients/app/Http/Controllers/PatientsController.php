<?php

namespace Modules\Patients\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Doctors\Models\Doctor;
use Modules\Patients\Http\Requests\StorePatientRequest;
use Modules\Patients\Http\Requests\UpdatePatientRequest;
use Modules\Patients\Models\Patient;
use Modules\Patients\Services\PatientService;

class PatientsController extends Controller
{
    public function __construct(
        private readonly PatientService $patientService
    ) {
    }

    public function index(Request $request): View
    {
        $search = trim((string) $request->string('search'));
        $user   = $request->user();

        // If logged in as a Doctor, scope stats and list to their assigned patients only
        $doctorRecord = $user->hasRole('Doctor') ? $user->doctor : null;

        $baseQuery = $doctorRecord
            ? Patient::where('assigned_doctor_id', $doctorRecord->id)
            : Patient::query();

        $stats = [
            'total'          => (clone $baseQuery)->count(),
            'admitted_today' => \Illuminate\Support\Facades\DB::table('patient_visits')
                                    ->whereDate('visit_date', today())
                                    ->where('visit_type', 'admission')
                                    ->when($doctorRecord, fn($q) => $q->whereIn('patient_id',
                                        (clone $baseQuery)->pluck('id')))
                                    ->count(),
            'outpatients'    => \Illuminate\Support\Facades\DB::table('patient_visits')
                                    ->whereDate('visit_date', today())
                                    ->whereIn('visit_type', ['consultation', 'follow-up'])
                                    ->when($doctorRecord, fn($q) => $q->whereIn('patient_id',
                                        (clone $baseQuery)->pluck('id')))
                                    ->count(),
            'discharged'     => \Illuminate\Support\Facades\DB::table('patient_visits')
                                    ->where('visit_type', 'routine-check')
                                    ->when($doctorRecord, fn($q) => $q->whereIn('patient_id',
                                        (clone $baseQuery)->pluck('id')))
                                    ->count(),
        ];

        return view('patients::patients.index', [
            'patients' => $this->patientService->paginatedPatients($search, $doctorRecord),
            'search'   => $search,
            'stats'    => $stats,
        ]);
    }

    public function create(): View
    {
        return view('patients::patients.create', [
            'patient' => new Patient(),
            'selectOptions' => $this->selectOptions(),
        ]);
    }

    public function store(StorePatientRequest $request): RedirectResponse
    {
        $patient = $this->patientService->create($request->validated(), $request->user());

        return redirect()
            ->route('patients.show', $patient)
            ->with('status', 'Patient registered successfully.');
    }

    public function show(Patient $patient): View
    {
        return view('patients::patients.show', [
            'patient' => $patient->load('registeredBy'),
            'visitTypes' => $this->visitTypes(),
            'vitals' => $patient->vitals()
                ->with('recordedBy')
                ->latest('recorded_at')
                ->latest('id')
                ->take(6)
                ->get(),
            'visits' => $patient->visits()
                ->with('attendedBy')
                ->latest('visit_date')
                ->latest('id')
                ->take(6)
                ->get(),
        ]);
    }

    public function edit(Patient $patient): View
    {
        return view('patients::patients.edit', [
            'patient' => $patient,
            'selectOptions' => $this->selectOptions(),
        ]);
    }

    public function update(UpdatePatientRequest $request, Patient $patient): RedirectResponse
    {
        $patient = $this->patientService->update($patient, $request->validated());

        return redirect()
            ->route('patients.show', $patient)
            ->with('status', 'Patient details updated successfully.');
    }

    public function destroy(Patient $patient): RedirectResponse
    {
        $name = $patient->full_name;

        $this->patientService->delete($patient);

        return redirect()
            ->route('patients.index')
            ->with('status', "{$name} was archived successfully.");
    }

    private function selectOptions(): array
    {
        return [
            'genders' => [
                'male'   => 'Male',
                'female' => 'Female',
                'other'  => 'Other',
            ],
            'maritalStatuses' => [
                'single'   => 'Single',
                'married'  => 'Married',
                'divorced' => 'Divorced',
                'widowed'  => 'Widowed',
            ],
            'bloodGroups' => [
                'A+' => 'A+', 'A-' => 'A-',
                'B+' => 'B+', 'B-' => 'B-',
                'AB+' => 'AB+', 'AB-' => 'AB-',
                'O+' => 'O+', 'O-' => 'O-',
            ],
            'genotypes' => [
                'AA' => 'AA', 'AS' => 'AS',
                'SS' => 'SS', 'AC' => 'AC', 'SC' => 'SC',
            ],
            'doctors' => Doctor::where('status', 'active')
                ->orderBy('last_name')
                ->get()
                ->mapWithKeys(fn($d) => [$d->id => $d->full_name])
                ->toArray(),
        ];
    }

    private function visitTypes(): array
    {
        return [
            'consultation' => 'Consultation',
            'follow-up' => 'Follow-up',
            'emergency' => 'Emergency',
            'admission' => 'Admission',
            'routine-check' => 'Routine Check',
        ];
    }
}
