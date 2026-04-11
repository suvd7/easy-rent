<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Apartment {{ $apartment->unit_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">

                <form action="{{ route('properties.apartments.update', [$property, $apartment]) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-2 gap-4">

                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Unit number</label>
                            <input type="text" name="unit_number"
                                   value="{{ old('unit_number', $apartment->unit_number) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('unit_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Floor</label>
                            <input type="number" name="floor"
                                   value="{{ old('floor', $apartment->floor) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('floor') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Monthly rent ($)</label>
                            <input type="number" step="0.01" name="rent_amount"
                                   value="{{ old('rent_amount', $apartment->rent_amount) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('rent_amount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Size (sqm)</label>
                            <input type="number" step="0.01" name="size_sqm"
                                   value="{{ old('size_sqm', $apartment->size_sqm) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('size_sqm') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Bedrooms</label>
                            <input type="number" name="bedrooms"
                                   value="{{ old('bedrooms', $apartment->bedrooms) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('bedrooms') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Bathrooms</label>
                            <input type="number" name="bathrooms"
                                   value="{{ old('bathrooms', $apartment->bathrooms) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('bathrooms') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                @foreach(['available', 'occupied', 'maintenance'] as $s)
                                    <option value="{{ $s }}"
                                        {{ old('status', $apartment->getRawOriginal('status')) === $s ? 'selected' : '' }}>
                                        {{ ucfirst($s) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="col-span-2 space-y-2">
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="has_parking" value="1"
                                       {{ old('has_parking', $apartment->has_parking) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600">
                                <span class="text-sm text-gray-700">Has parking</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="is_available" value="1"
                                       {{ old('is_available', $apartment->is_available) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600">
                                <span class="text-sm text-gray-700">Available for rent</span>
                            </label>
                        </div>

                        {{-- IMAGE FIELD --}}
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Apartment Image</label>

                            @if($apartment->image)
                                <img src="{{ asset('storage/' . $apartment->image) }}"
                                     class="mt-2 h-32 w-full object-cover rounded-md mb-3">
                            @endif

                            <input type="file" name="image"
                                   class="mt-1 block w-full text-sm text-gray-700
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-md file:border-0
                                          file:bg-blue-400 file:text-white
                                          hover:file:bg-blue-700">
                            <p class="text-xs text-gray-400 mt-1">Leave empty to keep current image</p>

                            @error('image')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>{{-- end grid --}}

                    <div class="mt-6 flex gap-3">
                        <button style="background:blue; color:white; padding:10px;">
                            Save changes
                        </button>
                        <a href="{{ route('properties.apartments.index', $property) }}"
                           class="px-6 py-2 border rounded text-gray-600 hover:bg-gray-50">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>