<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800">
                    {{ __('Tickler Dashboard') }}
                </h2>
                <p class="text-sm text-gray-500">
                    Manage your ticklers, companies and templates.
                </p>
            </div>

            <div class="text-right">
                <p class="text-sm text-gray-500">
                    {{ now()->format('F d, Y') }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Statistics --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-gray-500 text-sm">
                        Total Ticklers
                    </p>

                    <h1 class="text-3xl font-bold text-indigo-600">
                        {{ $ticklers->count() }}
                    </h1>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-gray-500 text-sm">
                        Companies
                    </p>

                    <h1 class="text-3xl font-bold text-green-600">
                        {{ $companies->count() }}
                    </h1>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-gray-500 text-sm">
                        Templates
                    </p>

                    <h1 class="text-3xl font-bold text-orange-500">
                        {{ $templates->count() }}
                    </h1>
                </div>

            </div>

            {{-- Buttons --}}
            <div class="bg-white shadow rounded-lg p-6">

                <div class="flex flex-wrap gap-3">

                    <a href="{{ route('tickler.create') }}"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded">

                        + New Tickler
                    </a>

                    <a href="{{ route('tickler-company.index') }}"
                        class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded">

                        Companies
                    </a>

                    <a href="{{ route('tickler-template.index') }}"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded">

                        Templates
                    </a>

                </div>

            </div>

            {{-- Search --}}
            <div class="bg-white rounded-lg shadow p-6">

                <form method="GET">

                    <div class="flex gap-4">

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search Tickler..."
                            class="w-full rounded border-gray-300">

                        <button
                            class="bg-indigo-600 text-white px-6 rounded">

                            Search

                        </button>

                    </div>

                </form>

            </div>

            {{-- Ticklers Table --}}
            <div class="bg-white shadow rounded-lg overflow-hidden">

                <div class="px-6 py-4 border-b">

                    <h2 class="font-semibold text-lg">

                        Ticklers

                    </h2>

                </div>

                <table class="min-w-full"> 
                    <thead class="bg-gray-100">

                        <tr> 
                            <th class="px-6 py-3 text-left">Company</th> 
                            <th class="px-6 py-3 text-left">Department</th> 
                            <th class="px-6 py-3 text-left">Position</th> 
                            <th class="px-6 py-3 text-left">Address</th> 
                            <th class="px-6 py-3 text-left">Description</th> 
                            <th class="px-6 py-3 text-center">Action</th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($ticklers as $tickler)

                        <tr class="border-t hover:bg-gray-50">

                            <td class="px-6 py-4"> 
                                {{ $tickler->company }}  
                            </td>

                            <td class="px-6 py-4">  
                                {{ $tickler->department }}  
                            </td>

                            <td class="px-6 py-4"> 
                                {{ $tickler->position }} 
                            </td>

                            <td class="px-6 py-4">
                                {{ $tickler->address }}
                            </td>

                            <td class="px-6 py-4"> 
                                {{ \Illuminate\Support\Str::limit($tickler->description, 100) }}
                            </td>  


                            <td class="px-6 py-4">

                                <div class="flex justify-center gap-2">

                                    <a href="{{ route('tickler.show',$tickler) }}"
                                        class="text-blue-600">

                                        View

                                    </a>

                                    <a class="hidden" href="{{ route('tickler.edit',$tickler) }}"
                                        class="text-yellow-600">

                                        Edit

                                    </a>

                                    <form
                                       class="hidden"
                                        method="POST"
                                        action="{{ route('tickler.destroy',$tickler) }}">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            onclick="return confirm('Delete this tickler?')"
                                            class="text-red-600">

                                            Delete

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5"
                                class="text-center py-10 text-gray-500">

                                No Ticklers Found.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

                <div class="p-6">

                    {{ $ticklers->links() }}

                </div>

            </div>

        </div>

    </div>

</x-app-layout>