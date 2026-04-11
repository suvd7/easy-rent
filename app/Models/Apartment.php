<?php

namespace App\Models;

use App\Models\Property;
use App\Models\Lease;
use App\Models\MaintenanceRequest;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $fillable = [
        'property_id',
        'unit_number',
        'floor',
        'rent_amount',
        'bedrooms',
        'bathrooms',
        'size_sqm',
        'has_parking',
        'is_available',
        'status',
        'image',
    ];

    protected $casts = [
        'has_parking'  => 'boolean',
        'is_available' => 'boolean',
        'rent_amount'  => 'decimal:2',
        'size_sqm'     => 'decimal:2',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function leases()
    {
        return $this->hasMany(Lease::class);
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    public function isOccupied()
    {
        return $this->leases()->where('status', 'active')->exists();
    }

public function getStatusAttribute()
{
    // Check raw value first (set manually e.g. 'maintenance')
    $raw = $this->attributes['status'] ?? null;
    if ($raw === 'maintenance') {
        return 'maintenance';
    }
    return $this->isOccupied() ? 'occupied' : 'available';
}

public function setStatusAttribute($value)
{
    $this->attributes['status'] = $value;
}
}