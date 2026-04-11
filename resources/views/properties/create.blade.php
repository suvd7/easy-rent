<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Create Property
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto bg-white p-6 shadow rounded">

            <form method="POST" action="{{ route('properties.store') }}">
                @csrf

                <div class="mb-4">
                    <label>Name</label>
                    <input class="w-full border p-2" name="name" required>
                </div>

                <div class="mb-4">
                    <label>Address</label>
                    <input class="w-full border p-2" name="address" required>
                </div>

                <div class="mb-4">
                    <label>City</label>
                    <input class="w-full border p-2" name="city" required>
                </div>

                <div class="mb-4">
                    <label>Country</label>
                    <input class="w-full border p-2" name="country" required>
                </div>

                <div class="mb-4">
                    <label>Description</label>
                    <textarea class="w-full border p-2" name="description"></textarea>
                </div>

                <button style="background:blue; color:white; padding:10px;">
                    Save
                </button>
            </form>

        </div>
    </div>
</x-app-layout>