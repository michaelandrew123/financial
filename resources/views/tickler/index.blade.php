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

    <div class="py-8"
  
        x-data="{  
            openCreate: false, 
            openViewTransaction: false,
            selectedTickler: {},
            transactions: []
        }"  
    >

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
            <div class="bg-white shadow rounded-lg overflow-hidden p-4 sm:p-8">  
                <div class="px-6 py-4 "> 
                    <h2 class="font-semibold text-lg"> 
                        Ticklers 
                    </h2> 
                </div> 

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($ticklers as $tickler)
                        <div class="bg-white rounded-lg shadow border border-gray-200 p-5">
                            <div class="mb-4 flex flex-row justify-between"> 
                                <h3 class="text-lg font-semibold text-gray-800"> 
                                    {{ $tickler->company }}  
                                </h3> 
                                <div class=""> 
                                    <h3 class="text-lg font-semibold text-gray-800">
                                        {{ $tickler->department }}  
                                    </h3>
                                    <p class="text-sm text-gray-500">
                                        {{ $tickler->position }} 
                                    </p>
                                </div>  
                            </div> 

                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Company Address</span>
                                    <span class="font-medium">{{ $tickler->address }}</span>
                                </div> 
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Description</span>
                                    <span> 
                                        {{ $tickler->description ? \Illuminate\Support\Str::limit($tickler->description, 100) : 'N/A' }} 
                                    </span>
                                </div> 
                            </div>

                            <div class="mt-5 pt-4 border-t flex flex-col gap-2 justify-between"> 
                                <div class="flex flex-row justify-between gap-2" >  
                                    <x-secondary-button
                                        @click="
                                            selectedTickler = {
                                                id: {{ $tickler->id }},
                                                company: {{ Js::from($tickler->company) }},
                                            };
                                            openCreate = true;
                                        "
                                        class="w-full justify-center" 
                                    >
                                        Add Tickler Item
                                    </x-secondary-button>  
                                    <a  href="{{ route('tickler.edit',$tickler) }}"
                                        class="w-full hidden px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600"> 
                                        Edit 
                                    </a> 
                                    <x-primary-button
                                        class="w-full justify-center"
                                        @click="
                                            selectedTickler = {
                                                id: {{ $tickler->id }},
                                                company: {{ Js::from($tickler->company) }},
                                            };

                                            transactions = {{ Js::from(
                                                $tickler->items->map(function ($item) {
                                                    return [
                                                        'id' => $item->id,
                                                        'items' => $item->items,
                                                        'created_at' => $item->created_at->format('F j, Y g:i A'),
                                                        'approved_by_name' => ucfirst($item->approved_by_name),
                                                        'approved_by_signature' => ucfirst($item->approved_by_signature),
                                                        'signature' => ucfirst($item->signature)
                                                    ];
                                                })
                                            ) }};

                                            openViewTransaction = true;
                                        "
                                    >
                                        View Item
                                    </x-primary-button>

                                </div> 
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-8 text-gray-500">
                            No Tickler yet.
                        </div>
                    @endforelse
                </div> 
                <table class="min-w-full hidden"> 
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
                                        <a href="{{ route('tickler.show',$tickler) }}" class="text-blue-600"> 
                                            View 
                                        </a> 
                                        <a class="hidden" href="{{ route('tickler.edit',$tickler) }}" class="text-yellow-600"> 
                                            Edit 
                                        </a> 
                                        <form class="hidden" method="POST" action="{{ route('tickler.destroy',$tickler) }}"> 
                                            @csrf
                                            @method('DELETE') 
                                            <button onclick="return confirm('Delete this tickler?')"
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
                <div class="p-6 hidden"> 
                    {{ $ticklers->links() }} 
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
                    Add Item Tickler <span x-text="selectedTickler.company"></span>
                </h2>


                <form method="POST" action="{{ route('tickler-items.store') }}">
                    @csrf

                        <input
                            type="hidden"
                            name="tickler_id"
                            :value="selectedTickler.id"
                        > 
                        <div class="mb-6">

                            <label class="block font-medium mb-2">
                                Checklist Items
                            </label>

                            <!-- Current Items -->
                            <div
                                class="space-y-2 mb-4"
                                x-show="items.length"
                            >

                                <template
                                    x-for="(item,index) in items"
                                    :key="index"
                                >

                                    <div
                                        class="flex justify-between items-center rounded border bg-gray-50 px-3 py-2"
                                    >

                                        <div class="flex items-center gap-2">

                                            <span
                                                class="text-green-600 font-bold"
                                            >
                                                ✓
                                            </span>

                                            <span x-text="item"></span>

                                        </div>

                                        <div class="flex items-center gap-2">

                                            <input
                                                type="hidden"
                                                name="items[]"
                                                :value="item"
                                            >

                                            <button
                                                type="button"
                                                @click="items.splice(index,1)"
                                                class="text-red-500 hover:text-red-700"
                                            >
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

                                <button
                                    type="button"
                                    class="px-4 bg-indigo-600 text-white rounded hover:bg-indigo-700"

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
                                    Name
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    class="w-full rounded border-gray-300"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">
                                    Approved By
                                </label>

                                <input
                                    type="text"
                                    name="approved_by_name"
                                    class="w-full rounded border-gray-300"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">
                                    Approved By Signature
                                </label>

                                <input
                                    type="text"
                                    name="approved_by_signature"
                                    class="w-full rounded border-gray-300"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">
                                    Signature
                                </label>

                                <input
                                    type="text"
                                    name="signature"
                                    class="w-full rounded border-gray-300"
                                >
                            </div>

                        </div>

                        <!-- ========================= -->
                        <!-- BUTTONS -->
                        <!-- ========================= -->

                        <div class="flex justify-end gap-3 mt-6">
 
                            <button
                                type="button"
                                @click="
                                    openCreate=false;
                                    items=[];
                                    newItem='';
                                "
                                class="px-4 py-2 rounded border"
                            >
                                Cancel
                            </button>

                            <button
                                type="submit"
                                class="px-5 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700"
                            >
                                Save
                            </button>

                        </div>

                </form>
  
            </div>
        </div> 
 
        <!-- view modal for created tickler items  --> 
        <div
            x-show="openViewTransaction"
            x-transition
            @click.self="openViewTransaction = false"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
            x-cloak
            x-data="{ 
                tab: null,
                selectedTransaction: null
            }"
            >
            <div class="bg-white rounded-lg shadow-lg w-full max-w-5xl">

                <div class="flex justify-between items-center border-b px-6 py-4">
                    <div>
                        <h2 class="text-xl font-semibold">
                            Tickler List Item
                        </h2> 
                        <p class="text-gray-500" x-text="selectedTickler.company"></p>
                    </div>

                    <button
                        @click="openViewTransaction = false"
                        class="text-gray-500 hover:text-gray-700 text-xl hidden"
                    >
                        ✕
                    </button>
                </div>

                <div class="p-6 overflow-x-auto">
                    <!-- Content Panel -->  
                    <div
                        x-show="selectedTransaction"
                        x-transition
                        class="my-8 border rounded-lg p-6 bg-gray-50 shadow-lg"
                    >
                        <div class="flex flex-row justify-between">
                            <h3 class="text-lg font-semibold mb-4">
                                Checklist Items
                            </h3> 
                            <button
                                @click="selectedTransaction = false"
                                class="text-gray-500 hover:text-gray-700 text-xl"
                            >
                                ✕
                            </button>
                        </div> 
                        <ul class="space-y-2"> 
                            <template
                                x-for="(item,index) in selectedTransaction.items"
                                :key="index"
                            > 
                                <li
                                    class="flex items-center gap-3 border rounded px-3 py-2 bg-white"
                                > 
                                    <span class="text-green-600 hidden">
                                        ✔
                                    </span> 
                                    <span class="text-green-600 font-bold" >
                                                ✓
                                    </span>
                                    <span x-text="item"></span> 
                                </li> 
                            </template> 
                        </ul> 
                    </div>   
                    <table class="min-w-full divide-y divide-gray-200 border rounded-lg"> 
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">
                                    Date
                                </th> 
                                <th class="px-4 py-3 text-left font-semibold">
                                    Approved by name
                                </th> 
                                <th class="px-4 py-3 text-left font-semibold">
                                    Approved by signature
                                </th> 
                                <th class="px-4 py-3 text-left font-semibold">
                                    Signature
                                </th>  
                            </tr>
                        </thead> 
                        <tbody class="divide-y divide-gray-200"> 
                            <template x-if="transactions.length === 0">
                                <tr>
                                    <td
                                        colspan="4"
                                        class="text-center py-6 text-gray-500"
                                    >
                                        No salary history found.
                                    </td>
                                </tr>
                            </template> 
                            <template
                                x-for="(transaction, index) in transactions"
                                :key="index" 
                            >
                                <tr
                                    class="hover:bg-green-50 cursor-pointer"
                                    @click="
                                        tab = transaction.id;
                                        selectedTransaction = transaction;
                                    "
                                >
                                    <td class="px-4 py-3">
                                        <span x-text="transaction.created_at"></span>
                                    </td>

                                    <td class="px-4 py-3">
                                        <span x-text="transaction.approved_by_name"></span>
                                    </td>

                                    <td class="px-4 py-3">
                                        <span x-text="transaction.approved_by_signature"></span>
                                    </td>

                                    <td class="px-4 py-3">
                                        <span x-text="transaction.signature"></span>
                                    </td>
                                </tr>  
                            </template> 
                        </tbody> 
                    </table>  
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