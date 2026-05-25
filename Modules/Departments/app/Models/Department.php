<?php

namespace Modules\Departments\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'head_of_department',
        'phone',
        'location',
        'status',
    ];

    /**
     * A department has many doctors.
     */
    public function doctors()
    {
        return $this->hasMany(\Modules\Doctors\Models\Doctor::class, 'department_id');
    }

    /**
     * Scope: active departments only.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
