<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">
                Tickler Details
            </h2>

            <a
                href="{{ route('tickler.edit', $tickler) }}"
                class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 hidden"
            >
                Edit
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg">

                <div class="divide-y">

                    <div class="p-5 flex">
                        <div class="w-48 font-semibold text-gray-600">
                            Company
                        </div>

                        <div>
                            {{ $tickler->company }}
                        </div>
                    </div>

                    <div class="p-5 flex">
                        <div class="w-48 font-semibold text-gray-600">
                            Department
                        </div>

                        <div>
                            {{ $tickler->department ?: '-' }}
                        </div>
                    </div>

                    <div class="p-5 flex">
                        <div class="w-48 font-semibold text-gray-600">
                            Position
                        </div>

                        <div>
                            {{ $tickler->position }}
                        </div>
                    </div>

                    <div class="p-5 flex">
                        <div class="w-48 font-semibold text-gray-600">
                            Address
                        </div>

                        <div>
                            {{ $tickler->address ?: '-' }}
                        </div>
                    </div>

                    <div class="p-5">
                        <div class="font-semibold text-gray-600 mb-2">
                            Description
                        </div>

                        <div class="whitespace-pre-line">
                            {{ $tickler->description ?: '-' }}
                        </div>
                    </div>

                    <div class="p-5 flex">
                        <div class="w-48 font-semibold text-gray-600">
                            Created
                        </div>

                        <div>
                            {{ $tickler->created_at->format('F d, Y h:i A') }}
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>