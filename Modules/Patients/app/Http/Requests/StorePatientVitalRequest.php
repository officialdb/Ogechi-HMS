<?php

namespace Modules\Patients\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientVitalRequest extends FormRequest
{
    protected $errorBag = 'storeVital';

    public function authorize(): bool
    {
        $user = $this->user();

        return $user !== null && $user->can('patients.update');
    }

    public function rules(): array
    {
        return [
            'recorded_at' => ['required', 'date'],
            'height_cm' => ['nullable', 'numeric', 'between:1,300'],
            'weight_kg' => ['nullable', 'numeric', 'between:1,500'],
            'temperature_c' => ['nullable', 'numeric', 'between:30,45'],
            'systolic_bp' => ['nullable', 'integer', 'between:40,300'],
            'diastolic_bp' => ['nullable', 'integer', 'between:20,200'],
            'pulse_rate' => ['nullable', 'integer', 'between:20,250'],
            'respiratory_rate' => ['nullable', 'integer', 'between:5,80'],
            'oxygen_saturation' => ['nullable', 'integer', 'between:50,100'],
            'blood_sugar' => ['nullable', 'numeric', 'between:1,1000'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
