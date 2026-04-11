<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Lease;
use Illuminate\Http\Request;

class BrowseController extends Controller
{
    public function index(Request $request)
    {
        $apartments = Apartment::with('property')
            ->where('status', 'available')
            ->when($request->min_price, fn($q, $v) => $q->where('rent_amount', '>=', $v))
            ->when($request->max_price, fn($q, $v) => $q->where('rent_amount', '<=', $v))
            ->when($request->bedrooms, fn($q, $v) => $q->where('bedrooms', $v))
            ->when($request->bathrooms, fn($q, $v) => $q->where('bathrooms', $v))
            ->get();

        return view('browse.index', compact('apartments'));
    }

    public function show(Apartment $apartment)
    {
        return view('browse.show', compact('apartment'));
    }

    public function requestLease(Request $request, Apartment $apartment)
    {
        $validated = $request->validate([
            'start_date' => 'required|date|after:today',
            'end_date'   => 'required|date|after:start_date',
        ]);

        // ✅ SAFE RULE:
        // Only block if there is already an ACTIVE lease
        $alreadyActive = Lease::where('apartment_id', $apartment->id)
            ->where('status', 'active')
            ->exists();

        if ($alreadyActive) {
            return back()->with('error', 'This apartment is already leased.');
        }

        // Optional safety: prevent duplicate pending requests
        $alreadyRequested = Lease::where('apartment_id', $apartment->id)
            ->where('tenant_id', auth()->id())
            ->where('status', 'requested')
            ->exists();

        if ($alreadyRequested) {
            return back()->with('error', 'You already requested this apartment.');
        }

        Lease::create([
            'apartment_id' => $apartment->id,
            'tenant_id'    => auth()->id(),
            'start_date'   => $validated['start_date'],
            'end_date'     => $validated['end_date'],
            'monthly_rent' => $apartment->rent_amount,
            'status'       => 'requested',
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Lease request submitted!');
    }
}