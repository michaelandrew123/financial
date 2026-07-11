<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Edit Tickler
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

                <form action="{{ route('tickler.update', $tickler) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <x-input-label value="Company"/>
                            <x-text-input
                                name="company"
                                class="w-full mt-1"
                                value="{{ old('company', $tickler->company) }}"
                            />
                        </div>

                        <div>
                            <x-input-label value="Department"/>
                            <x-text-input
                                name="department"
                                class="w-full mt-1"
                                value="{{ old('department', $tickler->department) }}"
                            />
                        </div>
 
                        <div>
                            <x-input-label value="Position"/>
                            <x-text-input
                                name="position"
                                class="w-full mt-1"
                                value="{{ old('position', $tickler->position) }}"
                            />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label value="Address"/>

                            <textarea
                                name="address"
                                rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            >{{ old('address', $tickler->address) }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label value="Description"/>

                            <textarea
                                name="description"
                                rows="5"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            >{{ old('description', $tickler->description) }}</textarea>
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end">
                        <x-primary-button>
                            Update Tickler
                        </x-primary-button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>