
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Maintenance Request
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">

                <form action="{{ route('maintenance.update', $maintenance) }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Title --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title"
                               value="{{ old('title', $maintenance->title) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" rows="4"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $maintenance->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- RADIO BUTTONS — priority --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                        <div class="flex gap-6">
                            @foreach(['low', 'medium', 'high', 'urgent'] as $level)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="priority" value="{{ $level }}"
                                           {{ old('priority', $maintenance->priority) === $level ? 'checked' : '' }}
                                           class="text-blue-600">
                                    <span class="text-sm text-gray-700 capitalize">{{ $level }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('priority')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @foreach(['open', 'in_progress', 'resolved'] as $s)
                                <option value="{{ $s }}"
                                    {{ old('status', $maintenance->status) === $s ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $s)) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- FILE UPLOAD — replace photo --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">
                            Replace photo
                            <span class="text-gray-400 font-normal">(leave empty to keep current)</span>
                        </label>

                        @if($maintenance->photo_path)
                            <div class="mt-2 mb-2">
                                <img src="{{ Storage::url($maintenance->photo_path) }}"
                                     alt="Current photo"
                                     class="h-24 rounded border object-cover">
                                <p class="text-xs text-gray-400 mt-1">Current photo</p>
                            </div>
                        @endif

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
                        <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                            Save changes
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