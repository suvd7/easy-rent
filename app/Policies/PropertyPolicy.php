<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Property;

class PropertyPolicy
{
    /**
     * Anyone logged in can see the list page (optional rule)
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Only owner/admin can view a property detail
     */
    public function view(User $user, Property $property): bool
    {
        return $user->role === 'admin'
            || $user->id === $property->owner_id;
    }

    /**
     * Only owner/admin can create properties
     */
    public function create(User $user): bool
    {
        return $user->role === 'owner'
            || $user->role === 'admin';
    }

    /**
     * Only owner of that property or admin can update it
     */
    public function update(User $user, Property $property): bool
    {
        return $user->role === 'admin'
            || $user->id === $property->owner_id;
    }

    /**
     * Only owner or admin can delete property
     */
    public function delete(User $user, Property $property): bool
    {
        return $user->role === 'admin'
            || $user->id === $property->owner_id;
    }

    /**
     * Optional (if you use restore/force delete later)
     */
    public function restore(User $user, Property $property): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, Property $property): bool
    {
        return $user->role === 'admin';
    }
}