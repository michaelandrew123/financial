@if (session('success'))
    <div class="mb-4 p-4 rounded-lg bg-green-50 border border-green-200 text-green-700 flex justify-between items-center">
        <span>{{ session('success') }}</span>

        <button onclick="this.parentElement.remove()" class="text-green-700 font-bold">
            ✕
        </button>
    </div>
@endif


@if ($errors->any())
    <div class="mb-4 p-4 rounded-lg bg-red-50 border border-red-200 text-red-700">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<x-app-layout>
    
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800">
                    {{ __('Tickler Template') }}
                </h2>
                <p class="text-sm text-gray-500">
                    Manage your tickler's templates.
                </p>
            </div>

            <div class="text-right">
                <p class="text-sm text-gray-500">
                    {{ now()->format('F d, Y') }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8" 
        x-data="{   
            selectedTemplate: {},
            openCreate: false,
            transactions: [],
            openViewTransaction: false
        }"   
        > 
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"> 
            <div class="bg-white shadow rounded-lg overflow-hidden p-4 sm:p-8">  
                <div class="px-6 py-4 ">  
                    <div class="flex flex-row justify-between my-2"> 
                            <h3 class="font-semibold text-lg mb-3">
                                Tickler Template
                            </h3>

                            <x-secondary-button
                                @click="openCreate = true"
                            >
                                Add
                            </x-secondary-button> 
                        </div>  
                </div> 
 
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($items as $item)
                        <div class="bg-white rounded-lg shadow border border-gray-200 p-5">
                            <div class="mb-4 flex flex-row justify-between"> 
                                <h3 class="text-lg font-semibold text-gray-800"> 
                                    {{ $item->title }}  
                                </h3>  
                            </div> 

                            <div class="space-y-2 text-sm mb-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Date Created</span>
                                    <span class="font-medium">{{ $item->created_at?->format('M, d Y, h:A') }}</span>
                                </div>  
                            </div> 
                            <div class="flex flex-row justify-between">
                                <x-primary-button 
                                    @click="
                                        selectedTemplate = {
                                            id: {{ $item->id }},
                                            title: {{ Js::from($item->title) }},
                                            created_at: {{ Js::from($item->created_at->format('F j, Y g:i A'))}},
                                            items: {{  Js::from($item->items)}},
                                        }; 
                                        openViewTransaction = true;
                                    " 
                                >
                                    View
                                </x-primary-button>

                           
                                <form
                                    method="POST"
                                    action="{{ route('tickler-template.destroy', $item) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this template?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <x-danger-button>
                                        Delete
                                    </x-danger-button>
                                </form>
                            </div>  
                        </div>
                    @empty
                        <div class="col-span-full text-center py-8 text-gray-500">
                            No tickler template yet.
                        </div>
                    @endforelse
                </div>  
            </div> 
        </div> 




        <!-- create modal for tickler items                                         -->
        <div 
            x-show="openCreate"
            x-transition
            @click.self="openCreate = false"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
            x-cloak 

            x-data="{
                newItem: '',
                items: []
            }"
            >
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md"> 
                <h2 class="text-lg font-semibold mb-4">
                    Tickler Template
                </h2> 
                <form method="POST" action="{{ route('tickler-template.store') }}">
                    @csrf 
                        <div class="mb-6">

                            <label class="block font-medium mb-2">
                                Checklist Items
                            </label>

                            <!-- Current Items -->
                            <div class="space-y-2 mb-4" x-show="items.length" > 
                                <template x-for="(item,index) in items" :key="index" > 
                                    <div class="flex justify-between items-center rounded border bg-gray-50 px-3 py-2" > 
                                        <div class="flex items-center gap-2"> 
                                            <span class="text-green-600 font-bold" >
                                                ✓
                                            </span> 
                                            <span x-text="item"></span> 
                                        </div> 
                                        <div class="flex items-center gap-2"> 
                                            <input type="hidden" name="items[]" :value="item" > 
                                            <button type="button" @click="items.splice(index,1)" class="text-red-500 hover:text-red-700" >
                                                ✕
                                            </button> 
                                        </div> 
                                    </div> 
                                </template> 
                            </div>

                            <!-- Add Item -->

                            <div class="flex gap-2"> 
                                <input
                                    x-model="newItem"
                                    type="text"
                                    placeholder="Enter checklist item..."
                                    class="flex-1 rounded border-gray-300" 
                                    @keydown.enter.prevent="
                                        if(newItem.trim()){
                                            items.push(newItem.trim());
                                            newItem='';
                                        }
                                    "
                                > 
                                <button type="button" class="px-4 bg-indigo-600 text-white rounded hover:bg-indigo-700" 
                                    @click="
                                        if(newItem.trim()){
                                            items.push(newItem.trim());
                                            newItem='';
                                        }
                                    "
                                >
                                    +
                                </button> 
                            </div> 
                            <p class="text-xs text-gray-500 mt-2">
                                Press Enter or click + to add another checklist item.
                            </p>

                        </div>

                        <!-- ========================= -->
                        <!-- OTHER FIELDS -->
                        <!-- ========================= -->

                        <div class="space-y-4">

                            <div>
                                <label class="block text-sm font-medium mb-1">
                                title
                                </label>

                                <input
                                    type="text"
                                    name="title"
                                    required
                                    class="w-full rounded border-gray-300"
                                >
                            </div>
 

                        </div>
 
                        <!-- ========================= -->
                        <!-- BUTTONS -->
                        <!-- ========================= -->

                        <div class="flex justify-end gap-3 mt-6"> 
                            <button type="button"
                                @click="
                                    openCreate=false;
                                    items=[];
                                    newItem=''; 
                                " class="px-4 py-2 rounded border"
                            >
                                Cancel
                            </button> 
                            <button type="submit" class="px-5 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700" >
                                Save
                            </button> 
                        </div> 
                </form>
  
            </div>
        </div> 

        <div
            x-show="openViewTransaction"
            x-transition
            @click.self="openViewTransaction = false"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
            x-cloak 
            >
            <div class="bg-white rounded-lg shadow-lg w-full max-w-5xl">

                <div class="flex justify-between items-center border-b px-6 py-4">
                    <div>
                        <h2 class="text-xl font-semibold">
                            Tickler Template List Item
                        </h2> 
                        <p class="text-gray-500" x-text="selectedTemplate.title"></p>
                    </div>
 
                </div>
 
                <div class="p-6 overflow-x-auto"> 
                    <div 
                        class="my-8 border rounded-lg p-6 bg-gray-50 shadow-lg"
                    >
                        <div class="flex flex-row justify-between">
                            <h3 class="text-lg font-semibold mb-4">
                                Checklist Items
                            </h3>  
                        </div> 
                        <ul class="space-y-2"> 
                          

                            <template
                                x-for="(item,index) in selectedTemplate.items"
                                :key="index"
                            > 
                                <li
                                    class="flex items-center gap-3 border rounded px-3 py-2  " > 
                                 
                                    <span class="text-green-600 font-bold" >
                                                ✓
                                    </span>
                                    <span x-text="item"></span> 
                                </li> 
                            </template> 

                        </ul> 
                    </div>    
                </div> 

                <div class="border-t px-6 py-4 flex justify-end"> 
                    <x-secondary-button
                        @click="openViewTransaction = false"
                    >
                        Close
                    </x-secondary-button> 
                </div>   
            </div>
        </div>                                





    </div> 

</x-app-layout>