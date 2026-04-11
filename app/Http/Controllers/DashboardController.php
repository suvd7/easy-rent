<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Lease;
use App\Models\MaintenanceRequest;
use App\Models\Property;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // ================= TENANT =================
        if ($user->role === 'tenant') {

            // IMPORTANT FIX:
            // show only latest lease per apartment (prevents duplicates in UI)
            $leases = Lease::with('apartment.property')
                ->where('tenant_id', $user->id)
                ->orderBy('apartment_id')
                ->orderByDesc('created_at')
                ->get()
                ->groupBy('apartment_id')
                ->map(fn ($group) => $group->first())
                ->values();

            $openMaintenance = MaintenanceRequest::where('tenant_id', $user->id)
                ->where('status', 'open')
                ->count();

            return view('dashboard.tenant', compact('leases', 'openMaintenance'));
        }

        // ================= ADMIN =================
        if ($user->role === 'admin') {

            $stats = [
                'total_users'         => User::count(),
                'total_properties'    => Property::count(),
                'total_apartments'    => Apartment::count(),
                'occupied_apartments' => Apartment::where('is_available', false)->count(),
                'active_leases'       => Lease::where('status', 'active')->count(),
                'open_maintenance'    => MaintenanceRequest::where('status', 'open')->count(),
            ];

            return view('dashboard.admin', compact('stats'));
        }

        // ================= OWNER =================
        if ($user->role === 'owner') {

            $properties = Property::where('owner_id', $user->id)
                ->withCount('apartments')
                ->get();

            $apartmentIds = Apartment::whereIn('property_id', $properties->pluck('id'))
                ->pluck('id');

            $stats = [
                'total_properties'    => $properties->count(),
                'total_apartments'    => $apartmentIds->count(),
                'occupied_apartments' => Apartment::whereIn('id', $apartmentIds)
                    ->where('is_available', false)
                    ->count(),
                'active_leases'       => Lease::whereIn('apartment_id', $apartmentIds)
                    ->where('status', 'active')
                    ->count(),
                'open_maintenance'    => MaintenanceRequest::whereIn('apartment_id', $apartmentIds)
                    ->where('status', 'open')
                    ->count(),
            ];

            return view('dashboard.owner', compact('stats', 'properties'));
        }

        abort(403);
    }
}