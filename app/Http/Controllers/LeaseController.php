<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Apartment;
use App\Models\Lease;

class LeaseController extends Controller
{
    public function index()
    {
        $leases = Lease::with(['tenant', 'apartment'])
            ->latest()
            ->get();

        return view('leases.index', compact('leases'));
    }

    public function create()
    {
        $tenants = User::where('role', 'tenant')->get();

        $apartments = Apartment::whereDoesntHave('leases', function ($q) {
            $q->where('status', 'active');
        })->get();

        return view('leases.create', compact('tenants', 'apartments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenant_id'    => 'required|exists:users,id',
            'apartment_id' => 'required|exists:apartments,id',
            'start_date'   => 'required|date',
            'end_date'     => 'nullable|date|after:start_date',
            'monthly_rent' => 'required|numeric|min:0',
        ]);

        $exists = Lease::where('apartment_id', $validated['apartment_id'])
            ->where('status', 'active')
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'apartment_id' => 'Apartment already leased.'
            ]);
        }

        DB::transaction(function () use ($validated) {

            Lease::create([
                'tenant_id'    => $validated['tenant_id'],
                'apartment_id' => $validated['apartment_id'],
                'start_date'   => $validated['start_date'],
                'end_date'     => $validated['end_date'] ?? null,
                'monthly_rent' => $validated['monthly_rent'],
                'status'       => 'active',
            ]);

            Apartment::where('id', $validated['apartment_id'])
                ->update(['is_available' => false]);
        });

        return redirect()->route('leases.index')
            ->with('success', 'Lease created successfully.');
    }

    public function approve(Lease $lease)
    {
        $lease->update(['status' => 'active']);

        $lease->apartment->update([
            'is_available' => false
        ]);

        return redirect()
            ->route('leases.index')
            ->with('success', 'Lease approved successfully.');
    }

    public function reject(Lease $lease)
    {
        $lease->update(['status' => 'rejected']);

        return redirect()
            ->route('leases.index')
            ->with('success', 'Lease rejected successfully.');
    }

    public function end(Lease $lease)
    {
        DB::transaction(function () use ($lease) {

            $lease->update(['status' => 'ended']);

            $lease->apartment->update([
                'is_available' => true
            ]);
        });

        return redirect()->route('leases.index');
    }
}