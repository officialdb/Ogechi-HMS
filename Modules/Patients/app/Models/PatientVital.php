<?php

namespace Modules\Patients\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class PatientVital extends Model
{
    use LogsActivity;

    protected $fillable = [
        'patient_id',
        'recorded_by',
        'recorded_at',
        'height_cm',
        'weight_kg',
        'temperature_c',
        'systolic_bp',
        'diastolic_bp',
        'pulse_rate',
        'respiratory_rate',
        'oxygen_saturation',
        'blood_sugar',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'recorded_at' => 'datetime',
            'height_cm' => 'decimal:2',
            'weight_kg' => 'decimal:2',
            'temperature_c' => 'decimal:1',
            'blood_sugar' => 'decimal:2',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('patient_vitals')
            ->logOnly([
                'patient_id',
                'recorded_at',
                'temperature_c',
                'systolic_bp',
                'diastolic_bp',
                'pulse_rate',
                'oxygen_saturation',
            ])
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }
}
