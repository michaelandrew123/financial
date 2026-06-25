<!-- @if (session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
        {{ session('success') }}
    </div>
@endif -->
@if (session('success'))
    <div class="mb-4 p-4 rounded-lg bg-green-50 border border-green-200 text-green-700 flex justify-between items-center">
        <span>{{ session('success') }}</span>

        <button onclick="this.parentElement.remove()" class="text-green-700 font-bold">
            ✕
        </button>
    </div>
@endif
<x-app-layout>  
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Event') }}
        </h2>
    </x-slot> 
    <div   
        x-data="{
            openCreate: false,
            openEdit: false,
            editEvent: {}
        }" 
        class="py-12"> 

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"> 
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                <div class="w-full py-2 px-1 text-center text-gray-700 shadow-lg bg-red-100 border rounded-lg my-5 ">Under Maintenance</div>
                <div class="float-right mb-5 hidden">   
                    <button
                        @click="openCreate = true"
                        class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700"
                    >
                        Add
                    </button>
                </div>

                
                <table class="min-w-full border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Title</th>
                            <th class="px-4 py-2 text-right">Description</th>
                            <th class="px-4 py-2 text-right">Event date</th> 
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($events as $event)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-2">
                                    {{ $event->title }}
                                </td>
                                <td class="px-4 py-2 text-right">
                                    {{ \Illuminate\Support\Str::limit($event->description, 100, '...') }}
                                </td>
                                <td class="px-4 py-2 text-right">
                                    {{ $event->event_date?->format('M d, Y') }}
                                </td> 
    
                                <td class="px-4 py-2 text-center">
                                    <button
                                        @click="
                                            editEvent = {
                                                id: {{ $editEvent->id }},
                                                title: @js($company->title), 
                                                description: @js($company->description), 
                                                event_date: '{{ $company->event_date?->format('Y-m-d') }}'
                                            };
                                            openEdit = true;
                                        "
                                        class="px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600"
                                    >
                                        Edit
                                    </button> 
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-4 text-center text-gray-500">
                                    No Event yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Create Modal -->
        <div 
            x-show="openCreate"
            x-transition
            @click.self="openCreate = false"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
            x-cloak >
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">

                <h2 class="text-lg font-semibold mb-4">Add Event</h2>

                <form method="POST" action="{{ route('events.store') }}">
                    @csrf 
                    <!-- Company Name -->
                    <div class="mb-3">
                        <x-input-label for="title" value="Title" />
                        <x-text-input
                            id="title"
                            name="title"
                            class="w-full"
                            required
                        />
                    </div>

                    <!-- address-->
                    <div class="mb-3">
                        <x-input-label for="description" value="Description" />
            
                        <x-textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="w-full"
                            placeholder="Enter description..."
                        />
                        
                    </div>
  
                    <div class="mb-3">
                        <x-input-label for="event_date" value="Event Date" />
                         <x-text-input
                            id="event_date"
                            name="event_date"
                            type="date" 
                            class="w-full"
                            required
                        /> 
  
                    </div>
  
                    <div class="flex justify-end gap-2 mt-4">
                        <button
                            type="button"
                            @click="openCreate = false"
                            class="px-4 py-2 bg-gray-300 rounded"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700"
                        >
                            Save Event
                        </button>
                    </div>
                </form>
            </div>
        </div> 




        <!-- update Modal -->
        <div
            x-show="openEdit"
            x-transition
            @click.self="openEdit = false"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
            x-cloak
            >
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">

                <h2 class="text-lg font-semibold mb-4">
                    Edit Event
                </h2>
 
                <form
                    :action="'/companies/' + editEvent.id"
                    method="POST"
                >
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <x-input-label for="title" value="Title" />
                        <x-text-input
                            id="title"
                            type="text"
                            name="title"
                            class="w-full"
                            x-model="editEvent.title"
                            required
                        />
                    </div>
 
                    <div class="mb-3">
                        <x-input-label for="description" value="Description" />
            
                        <x-textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="w-full"
                            x-model="editEvent.description"
                            placeholder="Enter description..."
                        />
                        
                    </div>
  
                    <div class="mb-3">
                        <x-input-label for="event_date" value="Event Date" />
                         <x-text-input
                            id="event_date"
                            name="event_date"
                            type="date" 
                            class="w-full" 
                            x-model="editEvent.event_date"
                            required
                        /> 
  
                    </div>
 
                    <div class="flex justify-end gap-2 mt-4">
                        <button
                            type="button"
                            @click="openEdit = false"
                            class="px-4 py-2 bg-gray-300 rounded"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded"
                        >
                            Update
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>


</x-app-layout>
