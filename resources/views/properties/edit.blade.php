<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Edit Property
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto bg-white p-6 shadow rounded">

            <form method="POST" action="{{ route('properties.update', $property) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label>Name</label>
                    <input class="w-full border p-2" name="name" value="{{ $property->name }}">
                </div>

                <div class="mb-4">
                    <label>Address</label>
                    <input class="w-full border p-2" name="address" value="{{ $property->address }}">
                </div>

                <div class="mb-4">
                    <label>City</label>
                    <input class="w-full border p-2" name="city" value="{{ $property->city }}">
                </div>

                <div class="mb-4">
                    <label>Country</label>
                    <input class="w-full border p-2" name="country" value="{{ $property->country }}">
                </div>

                <div class="mb-4">
                    <label>Description</label>
                    <textarea class="w-full border p-2" name="description">
                        {{ $property->description }}
                    </textarea>
                </div>

                <button style="background:green; color:white; padding:10px; width:100%;">
                    Update
                </button>
            </form>

        </div>
    </div>
</x-app-layout>