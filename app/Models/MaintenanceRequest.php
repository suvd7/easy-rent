<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    protected $fillable = [
        'tenant_id',
        'apartment_id',
        'title',
        'description',
        'priority',
        'status',
        'photo_path',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    // public function update(User $user, MaintenanceRequest $maintenance)
    // {
    //     return $user->role === 'admin'
    //         || $user->role === 'owner'
    //         || $user->id === $maintenance->tenant_id;
    // }
}