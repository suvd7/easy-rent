<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaintenanceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin' || $user->role === 'owner') {
            $requests = MaintenanceRequest::with(['tenant', 'apartment'])
                ->latest()
                ->get();
        } else {
            $requests = MaintenanceRequest::with(['apartment'])
                ->where('tenant_id', $user->id)
                ->latest()
                ->get();
        }

        return view('maintenance.index', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $apartments = Apartment::with('property')->get();

        return view('maintenance.create', compact('apartments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'apartment_id' => 'required|exists:apartments,id',
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'priority'     => 'required|in:low,medium,high,urgent',
            'photo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('maintenance', 'public');
        }

        MaintenanceRequest::create([
            'tenant_id'    => auth()->id(),
            'apartment_id' => $validated['apartment_id'],
            'title'        => $validated['title'],
            'description'  => $validated['description'],
            'priority'     => $validated['priority'],
            'status'       => 'open',
            'photo_path'   => $photoPath,
        ]);

        return redirect()->route('maintenance.index')
            ->with('success', 'Maintenance request submitted.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaintenanceRequest $maintenance)
    {
        $apartments = Apartment::with('property')->get();

        return view('maintenance.edit', compact('maintenance', 'apartments'));
    }

    public function update(Request $request, MaintenanceRequest $maintenance)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'priority'    => 'required|in:low,medium,high,urgent',
            'status'      => 'required|in:open,in_progress,resolved',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($maintenance->photo_path) {
                Storage::disk('public')->delete($maintenance->photo_path);
            }
            $validated['photo_path'] = $request->file('photo')->store('maintenance', 'public');
        }

        if (isset($validated['status']) && $validated['status'] === 'resolved' && !$maintenance->resolved_at) {
            $validated['resolved_at'] = now();
        }

        unset($validated['photo']);
        $maintenance->update($validated);

        return redirect()->route('maintenance.index')
            ->with('success', 'Request updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaintenanceRequest $maintenance)
    {
        if ($maintenance->photo_path) {
            Storage::disk('public')->delete($maintenance->photo_path);
        }

        $maintenance->delete();

        return redirect()->route('maintenance.index')
            ->with('success', 'Deleted successfully');
    }
}
