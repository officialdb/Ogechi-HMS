<?php

namespace Modules\Patients\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Patients\Http\Requests\StorePatientVitalRequest;
use Modules\Patients\Models\Patient;
use Modules\Patients\Services\PatientService;

class PatientVitalsController extends Controller
{
    public function __construct(
        private readonly PatientService $patientService
    ) {
    }

    public function store(StorePatientVitalRequest $request, Patient $patient): RedirectResponse
    {
        $this->patientService->recordVital($patient, $request->validated(), $request->user());

        return redirect()
            ->route('patients.show', $patient)
            ->withFragment('vitals')
            ->with('status', 'Patient vitals recorded successfully.');
    }
}
