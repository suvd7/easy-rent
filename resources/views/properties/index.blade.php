<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Properties</h2>
        <p class="text-sm text-gray-500 mt-0.5">Manage your rental properties</p>
    </x-slot>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-end mb-4">
        <a href="{{ route('properties.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
            + Add property
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($properties as $property)
            <div class="bg-white rounded-xl border border-gray-200 p-5 hover:border-blue-200 transition">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="font-semibold text-gray-800">{{ $property->name }}</h3>
                        <p class="text-sm text-gray-400 mt-0.5">{{ $property->city }}, {{ $property->country }}</p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full
                        {{ $property->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $property->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                @if($property->address)
                    <p class="text-sm text-gray-500 mb-4">{{ $property->address }}</p>
                @endif

                <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                    <a href="{{ route('properties.apartments.index', $property) }}"
                       class="text-sm text-blue-600 hover:underline">
                        View apartments →
                    </a>
                    <div class="flex gap-3">
                        <a href="{{ route('properties.edit', $property) }}"
                           class="text-sm text-gray-500 hover:text-gray-700">Edit</a>
                        <form action="{{ route('properties.destroy', $property) }}"
                              method="POST" class="inline"
                              onsubmit="return confirm('Delete this property?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-sm text-red-500 hover:text-red-700">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white rounded-xl border border-dashed border-gray-300 p-12 text-center">
                <p class="text-gray-400 text-sm">No properties yet.</p>
                <a href="{{ route('properties.create') }}"
                   class="mt-2 inline-block text-blue-600 text-sm hover:underline">
                    Add your first property →
                </a>
            </div>
        @endforelse
    </div>

</x-app-layout>