<?php

namespace Modules\Patients\Http\Requests;

use Illuminate\Support\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePatientVisitRequest extends FormRequest
{
    protected $errorBag = 'storeVisit';

    public function authorize(): bool
    {
        $user = $this->user();

        return $user !== null && $user->can('patients.update');
    }

    public function rules(): array
    {
        return [
            'visit_date' => ['required', 'date'],
            'visit_type' => ['required', Rule::in(['consultation', 'follow-up', 'emergency', 'admission', 'routine-check'])],
            'chief_complaint' => ['nullable', 'string', 'max:2000'],
            'diagnosis' => ['nullable', 'string', 'max:2000'],
            'treatment_notes' => ['nullable', 'string', 'max:3000'],
            'follow_up_date' => [
                'nullable',
                'date',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    $visitDate = $this->date('visit_date');

                    if ($visitDate instanceof Carbon && Carbon::parse($value)->lt($visitDate->startOfDay())) {
                        $fail('The follow-up date must be on or after the visit date.');
                    }
                },
            ],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
