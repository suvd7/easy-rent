<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Property::class);

        $properties = Property::all();

        return view('properties.index', compact('properties'));
    }

    public function create()
    {
        $this->authorize('create', Property::class);

        return view('properties.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Property::class);

        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required',
        ]);

        Property::create([
            'owner_id' => auth()->id(),
            'name' => $request->name,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'description' => $request->description,
        ]);

        return redirect()->route('properties.index')
            ->with('success', 'Property created successfully');
    }

    public function show(Property $property)
    {
        $this->authorize('view', $property);

        return view('properties.show', compact('property'));
    }

    public function edit(Property $property)
    {
        $this->authorize('update', $property);

        return view('properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        $this->authorize('update', $property);

        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required',
        ]);

        $property->update($request->all());

        return redirect()->route('properties.index')
            ->with('success', 'Property updated successfully');
    }

    public function destroy(Property $property)
    {
        $this->authorize('delete', $property);

        $property->delete();

        return redirect()->route('properties.index')
            ->with('success', 'Property deleted successfully');
    }
}