<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            New Maintenance Request
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">

                <form action="{{ route('maintenance.store') }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    {{-- Apartment select (dropdown) --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Apartment</label>
                        <select name="apartment_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">— Select apartment —</option>
                            @foreach($apartments as $apt)
                                <option value="{{ $apt->id }}"
                                    {{ old('apartment_id') == $apt->id ? 'selected' : '' }}>
                                    {{ $apt->unit_number }}
                                    — {{ $apt->property->name ?? '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('apartment_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Title --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               placeholder="e.g. Broken heater"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" rows="4"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                  placeholder="Describe the issue in detail...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- RADIO BUTTONS — priority (assignment requirement) --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                        <div class="flex gap-6">
                            @foreach(['low', 'medium', 'high', 'urgent'] as $level)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="priority" value="{{ $level }}"
                                           {{ old('priority', 'medium') === $level ? 'checked' : '' }}
                                           class="text-blue-600">
                                    <span class="text-sm text-gray-700 capitalize">{{ $level }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('priority')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- FILE UPLOAD — photo (assignment requirement) --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">
                            Photo of the issue
                            <span class="text-gray-400 font-normal">(optional)</span>
                        </label>
                        <input type="file" name="photo" accept="image/*"
                               class="mt-1 block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded file:border-0
                                      file:text-sm file:font-medium
                                      file:bg-blue-50 file:text-blue-700
                                      hover:file:bg-blue-100">
                        @error('photo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button style="background:blue; color:white; padding:10px;">
                            Submit
                        </button>
                        <a href="{{ route('maintenance.index') }}"
                           class="px-6 py-2 border rounded text-gray-600 hover:bg-gray-50">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>