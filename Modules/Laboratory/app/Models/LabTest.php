<?php

namespace Modules\Laboratory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'test_name',
        'test_type',
        'status',
        'result',
        'notes',
        'cost',
        'tested_at',
    ];

    protected $casts = [
        'tested_at' => 'datetime',
        'cost'      => 'decimal:2',
    ];

    public function patient()
    {
        return $this->belongsTo(\Modules\Patients\Models\Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(\Modules\Doctors\Models\Doctor::class);
    }
}
