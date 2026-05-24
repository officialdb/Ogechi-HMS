<?php

namespace Modules\Patients\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Patients\Models\Patient;
use Modules\Patients\Models\PatientVisit;
use Modules\Patients\Models\PatientVital;

class PatientService
{
    public function paginatedPatients(?string $search = null, int $perPage = 12): LengthAwarePaginator
    {
        return Patient::query()
            ->when($search, function ($query, string $search): void {
                $query->where(function ($patientQuery) use ($search): void {
                    $patientQuery
                        ->where('patient_number', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('middle_name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data, ?Authenticatable $user = null): Patient
    {
        return DB::transaction(function () use ($data, $user): Patient {
            $patient = Patient::create([
                ...$data,
                'uuid' => (string) Str::uuid(),
                'registered_by' => $user?->getAuthIdentifier(),
            ]);

            $patient->updateQuietly([
                'patient_number' => $this->generatePatientNumber($patient),
            ]);

            return $patient->refresh();
        });
    }

    public function update(Patient $patient, array $data): Patient
    {
        $patient->update($data);

        return $patient->refresh();
    }

    public function delete(Patient $patient): void
    {
        $patient->delete();
    }

    public function recordVital(Patient $patient, array $data, ?Authenticatable $user = null): PatientVital
    {
        return $patient->vitals()->create([
            ...$data,
            'recorded_by' => $user?->getAuthIdentifier(),
        ]);
    }

    public function recordVisit(Patient $patient, array $data, ?Authenticatable $user = null): PatientVisit
    {
        return $patient->visits()->create([
            ...$data,
            'attended_by' => $user?->getAuthIdentifier(),
        ]);
    }

    private function generatePatientNumber(Patient $patient): string
    {
        return sprintf('OGH-PAT-%s-%06d', now()->format('Y'), $patient->id);
    }
}
