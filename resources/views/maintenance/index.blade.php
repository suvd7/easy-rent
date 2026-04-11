<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Maintenance Requests
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4 flex justify-end">
                <a href="{{ route('maintenance.create') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    + New Request
                </a>
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Apartment</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Priority</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Photo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($requests as $req)
                            <tr>
                                <td class="px-6 py-4 font-medium">{{ $req->title }}</td>
                                <td class="px-6 py-4">
                                    {{ $req->apartment->unit_number ?? '—' }}
                                    <span class="text-xs text-gray-400">
                                        {{ $req->apartment->property->name ?? '' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded-full
                                        {{ $req->priority === 'urgent' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $req->priority === 'high'   ? 'bg-orange-100 text-orange-800' : '' }}
                                        {{ $req->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $req->priority === 'low'    ? 'bg-green-100 text-green-800' : '' }}">
                                        {{ ucfirst($req->priority) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded-full
                                        @if($req->status === 'open') bg-blue-100 text-blue-800
                                        @elseif($req->status === 'in_progress') bg-yellow-100 text-yellow-800
                                        @elseif($req->status === 'resolved') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst(str_replace('_', ' ', $req->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($req->photo_path)
                                        <a href="{{ asset('storage/' . $req->photo_path) }}" target="_blank"
                                           class="text-blue-600 text-sm hover:underline">View</a>
                                    @else
                                        <span class="text-gray-400 text-sm">None</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 space-x-2">
                                    <a href="{{ route('maintenance.edit', $req) }}"
                                       class="text-blue-600 hover:underline text-sm">Edit</a>
                                    <form action="{{ route('maintenance.destroy', $req) }}"
                                          method="POST" class="inline"
                                          onsubmit="return confirm('Delete this request?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline text-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                                    No maintenance requests yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>