<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Lease</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">

                <form action="{{ route('leases.update', $lease) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Tenant</label>
                        <select name="tenant_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @foreach($tenants as $tenant)
                                <option value="{{ $tenant->id }}"
                                    {{ old('tenant_id', $lease->tenant_id) == $tenant->id ? 'selected' : '' }}>
                                    {{ $tenant->name }} — {{ $tenant->email }}
                                </option>
                            @endforeach
                        </select>
                        @error('tenant_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Apartment</label>
                        <select name="apartment_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @foreach($apartments as $apt)
                                <option value="{{ $apt->id }}"
                                    {{ old('apartment_id', $lease->apartment_id) == $apt->id ? 'selected' : '' }}>
                                    Unit {{ $apt->unit_number }} — {{ $apt->property->name ?? '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('apartment_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Start date</label>
                            <input type="date" name="start_date"
                                   value="{{ old('start_date', $lease->start_date) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('start_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">End date</label>
                            <input type="date" name="end_date"
                                   value="{{ old('end_date', $lease->end_date) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('end_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Monthly rent ($)</label>
                        <input type="number" step="0.01" name="monthly_rent"
                               value="{{ old('monthly_rent', $lease->monthly_rent) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('monthly_rent') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @foreach(['active', 'expired', 'terminated'] as $s)
                                <option value="{{ $s }}"
                                    {{ old('status', $lease->status) === $s ? 'selected' : '' }}>
                                    {{ ucfirst($s) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea name="notes" rows="3"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('notes', $lease->notes) }}</textarea>
                        @error('notes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                            Save changes
                        </button>
                        <a href="{{ route('leases.show', $lease) }}"
                           class="px-6 py-2 border rounded text-gray-600 hover:bg-gray-50">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>