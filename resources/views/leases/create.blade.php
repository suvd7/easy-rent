<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Create Lease
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto bg-white p-6 shadow rounded">

            <form method="POST" action="{{ route('leases.store') }}">
                @csrf

                {{-- Tenant --}}
                <div class="mb-4">
                    <label class="block font-medium">Tenant</label>
                    <select name="tenant_id" class="w-full border p-2">
                        <option value="">Select tenant</option>
                        @foreach($tenants as $tenant)
                            <option value="{{ $tenant->id }}">
                                {{ $tenant->name }} ({{ $tenant->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('tenant_id')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Apartment --}}
                <div class="mb-4">
                    <label class="block font-medium">Apartment</label>
                    <select name="apartment_id" class="w-full border p-2">
                        <option value="">Select apartment</option>
                        @foreach($apartments as $apartment)
                            <option value="{{ $apartment->id }}">
                                Unit {{ $apartment->unit_number }} - {{ $apartment->rent_amount }}$
                            </option>
                        @endforeach
                    </select>
                    @error('apartment_id')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Start Date --}}
                <div class="mb-4">
                    <label class="block font-medium">Start Date</label>
                    <input type="date" name="start_date" class="w-full border p-2">
                    @error('start_date')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- End Date --}}
                <div class="mb-4">
                    <label class="block font-medium">End Date</label>
                    <input type="date" name="end_date" class="w-full border p-2">
                </div>

                {{-- Monthly Rent --}}
                <div class="mb-4">
                    <label class="block font-medium">Monthly Rent</label>
                    <input type="number" step="0.01" name="monthly_rent" class="w-full border p-2">
                    @error('monthly_rent')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="flex gap-3">
                    <!-- <button type="submit"
                            class="bg-green-600 text-white px-4 py-2 rounded">
                        Create Lease
                    </button> -->
                    <button style="bg-green-600 text-white px-4 py-2 rounded">
                        Create Lease   
                     </button>

                    <a href="{{ route('leases.index') }}"
                       class="px-4 py-2 border rounded">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>