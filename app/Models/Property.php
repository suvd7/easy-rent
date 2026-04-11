<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Property;
use App\Models\Apartment;
use App\Models\Lease;
use App\Models\MaintenanceRequest;

class Property extends Model
{
    protected $fillable = [
        'owner_id',
        'name',
        'address',
        'city',
        'country',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function apartments()
    {
        return $this->hasMany(Apartment::class);
    }
}