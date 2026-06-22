<?php

namespace Modules\Doctors\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Doctors\Database\Factories\DoctorInviteFactory;

class DoctorInvite extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'doctor_id',
        'email',
        'token',
        'expires_at',
        'used_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // protected static function newFactory(): DoctorInviteFactory
    // {
    //     // return DoctorInviteFactory::new();
    // }
}
