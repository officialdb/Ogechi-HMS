<?php

namespace Modules\Patients\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class PatientVisit extends Model
{
    use LogsActivity;

    protected $fillable = [
        'patient_id',
        'attended_by',
        'visit_date',
        'visit_type',
        'chief_complaint',
        'diagnosis',
        'treatment_notes',
        'follow_up_date',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'visit_date' => 'datetime',
            'follow_up_date' => 'date',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function attendedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'attended_by');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('patient_visits')
            ->logOnly([
                'patient_id',
                'visit_date',
                'visit_type',
                'chief_complaint',
                'diagnosis',
                'follow_up_date',
            ])
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }
}
