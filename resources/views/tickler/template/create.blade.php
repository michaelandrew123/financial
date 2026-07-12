<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Tickler
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">

                <form action="{{ route('tickler.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <x-input-label for="company" value="Company" />
                            <x-text-input
                                id="company"
                                name="company"
                                class="block mt-1 w-full"
                                value="{{ old('company') }}"
                                required
                            />
                            <x-input-error :messages="$errors->get('company')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="department" value="Department" />
                            <x-text-input
                                id="department"
                                name="department"
                                class="block mt-1 w-full"
                                value="{{ old('department') }}"
                            />
                        </div>

                        <div>
                            <x-input-label for="position" value="Position" />
                            <x-text-input
                                id="position"
                                name="position"
                                class="block mt-1 w-full"
                                value="{{ old('position') }}"
                                required
                            />
                            <x-input-error :messages="$errors->get('position')" class="mt-2" />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="address" value="Company Address" />
                            <x-text-input
                                id="address"
                                name="address"
                                class="block mt-1 w-full"
                                value="{{ old('address') }}"
                                required
                            />
                      
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="description" value="Description" />
                            <textarea
                                id="description"
                                name="description"
                                rows="5"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            >{{ old('description') }}</textarea>
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end">
                        <x-primary-button>
                            Save Tickler
                        </x-primary-button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>