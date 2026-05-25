<?php

namespace Modules\Doctors\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'department_id',
        'first_name',
        'last_name',
        'specialization',
        'email',
        'phone',
        'license_number',
        'status',
        'bio',
    ];

    /**
     * Get the doctor's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "Dr. {$this->first_name} {$this->last_name}";
    }

    public function appointments()
    {
        return $this->hasMany(\Modules\Appointments\Models\Appointment::class);
    }

    /**
     * A doctor belongs to a department.
     */
    public function department()
    {
        return $this->belongsTo(\Modules\Departments\Models\Department::class);
    }
}
