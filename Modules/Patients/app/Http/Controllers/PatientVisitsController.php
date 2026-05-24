<?php

namespace Modules\Patients\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Patients\Http\Requests\StorePatientVisitRequest;
use Modules\Patients\Models\Patient;
use Modules\Patients\Services\PatientService;

class PatientVisitsController extends Controller
{
    public function __construct(
        private readonly PatientService $patientService
    ) {
    }

    public function store(StorePatientVisitRequest $request, Patient $patient): RedirectResponse
    {
        $this->patientService->recordVisit($patient, $request->validated(), $request->user());

        return redirect()
            ->route('patients.show', $patient)
            ->withFragment('visits')
            ->with('status', 'Patient visit history updated successfully.');
    }
}
