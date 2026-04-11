<?php

namespace App\Http\Controllers;

use App\Models\Lease;

class TenantController extends Controller
{
    public function apartment()
    {
        $lease = Lease::with('apartment.property')
            ->where('tenant_id', auth()->id())
            ->where('status', 'active')
            ->latest()
            ->first();

        return view('tenant.apartment', compact('lease'));
    }
}