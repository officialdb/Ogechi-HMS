<?php

namespace Modules\Pharmacy\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medication extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'generic_name',
        'category',
        'manufacturer',
        'quantity_in_stock',
        'unit_price',
        'expiry_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'quantity_in_stock' => 'integer',
        'unit_price' => 'decimal:2',
        'expiry_date' => 'date',
    ];

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'available' => 'emerald',
            'low_stock' => 'amber',
            'out_of_stock' => 'red',
            'expired' => 'slate',
            default => 'blue'
        };
    }
}
