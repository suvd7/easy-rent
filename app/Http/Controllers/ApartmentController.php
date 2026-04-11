<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApartmentController extends Controller
{
    public function index(Property $property)
    {
        $this->authorize('view', $property);
        $apartments = $property->apartments()->latest()->get();
        return view('apartments.index', compact('property', 'apartments'));
    }

    public function create(Property $property)
    {
        $this->authorize('update', $property);
        return view('apartments.create', compact('property'));
    }

    public function store(Request $request, Property $property)
    {
        $this->authorize('update', $property);

        $validated = $request->validate([
            'unit_number'  => 'required|string|max:20',
            'floor'        => 'required|integer|min:0',
            'rent_amount'  => 'required|numeric|min:0',
            'bedrooms'     => 'required|integer|min:0',
            'bathrooms'    => 'required|integer|min:0',
            'size_sqm'     => 'required|numeric|min:0',
            'has_parking'  => 'boolean',
            'is_available' => 'boolean',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $validated['has_parking']  = $request->boolean('has_parking');
        $validated['is_available'] = $request->boolean('is_available');
        $validated['status']       = 'available';

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('apartments', 'public');
        }

        $property->apartments()->create($validated);
        return redirect()->route('properties.apartments.index', $property);
    }

    public function show(Property $property, Apartment $apartment)
    {
        $this->authorize('view', $property);
        if ($apartment->property_id !== $property->id) {
            abort(404);
        }
        return view('apartments.show', compact('property', 'apartment'));
    }

    public function edit(Property $property, Apartment $apartment)
    {
        $this->authorize('update', $property);
        if ($apartment->property_id !== $property->id) {
            abort(404);
        }
        return view('apartments.edit', compact('property', 'apartment'));
    }

    public function update(Request $request, Property $property, Apartment $apartment)
    {
        $this->authorize('update', $property);
        if ($apartment->property_id !== $property->id) {
            abort(404);
        }

        $validated = $request->validate([
            'unit_number'  => 'required|string|max:20',
            'floor'        => 'required|integer|min:0',
            'rent_amount'  => 'required|numeric|min:0',
            'bedrooms'     => 'required|integer|min:0',
            'bathrooms'    => 'required|integer|min:0',
            'size_sqm'     => 'required|numeric|min:0',
            'has_parking'  => 'boolean',
            'is_available' => 'boolean',
            'status'       => 'nullable|in:available,occupied,maintenance',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $validated['has_parking']  = $request->boolean('has_parking');
        $validated['is_available'] = $request->boolean('is_available');

        if ($request->hasFile('image')) {
            if ($apartment->image) {
                Storage::disk('public')->delete($apartment->image);
            }
            $validated['image'] = $request->file('image')->store('apartments', 'public');
        }
        //         dd([
        //     'validated' => $validated,
        //     'hasFile'   => $request->hasFile('image'),
        //     'apartment' => $apartment->id,
        // ]);

        $apartment->update($validated);
        return redirect()->route('properties.apartments.index', $property);
    }

    public function destroy(Property $property, Apartment $apartment)
    {
        $this->authorize('update', $property);
        if ($apartment->property_id !== $property->id) {
            abort(404);
        }
        $apartment->delete();
        return redirect()->route('properties.apartments.index', $property);
    }
}