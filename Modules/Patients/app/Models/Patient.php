<?php

namespace Modules\Patients\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Patient extends Model
{
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = [
        'uuid',
        'patient_number',
        'first_name',
        'last_name',
        'middle_name',
        'date_of_birth',
        'gender',
        'phone',
        'email',
        'marital_status',
        'blood_group',
        'genotype',
        'allergies',
        'address',
        'city',
        'state',
        'country',
        'next_of_kin_name',
        'next_of_kin_phone',
        'next_of_kin_relationship',
        'emergency_contact_name',
        'emergency_contact_phone',
        'notes',
        'registered_by',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    public function registeredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registered_by');
    }

    public function vitals(): HasMany
    {
        return $this->hasMany(PatientVital::class);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(PatientVisit::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(\Modules\Appointments\Models\Appointment::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(\Modules\Billing\Models\Invoice::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('patients')
            ->logOnly([
                'patient_number',
                'first_name',
                'last_name',
                'phone',
                'email',
                'gender',
                'blood_group',
                'genotype',
            ])
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }

    protected function fullName(): Attribute
    {
        return Attribute::get(function (): string {
            return collect([$this->first_name, $this->middle_name, $this->last_name])
                ->filter()
                ->implode(' ');
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
