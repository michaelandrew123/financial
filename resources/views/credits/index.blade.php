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
            {{ __('Credit') }}
        </h2>
    </x-slot> 
    <div   
    x-data="{
        openCreate: false,
        openEdit: false,
        editCredit: {}
    }" 
    class="py-12">

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

            <div class="float-right mb-5">  
                <!-- <button
                    @click="open = true"
                    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700"
                >
                    Add
                </button> -->
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
                        <th class="px-4 py-2 text-right">Original Amount</th>
                        <th class="px-4 py-2 text-right">Remaining Balance</th>
                        <th class="px-4 py-2 text-right">Monthly Payment</th>
                        <th class="px-4 py-2 text-center">Start Date</th>
                        <th class="px-4 py-2 text-center">End Date</th>
                        <th class="px-4 py-2 text-center">Status</th>
                        <th class="px-4 py-2 text-center hidden">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($credits as $credit)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2">
                                {{ $credit->title }}
                            </td>

                            <td class="px-4 py-2 text-right">
                                ₱{{ number_format($credit->original_amount, 2) }}
                            </td>

                            <td class="px-4 py-2 text-right">
                                ₱{{ number_format($credit->remaining_balance, 2) }}
                            </td>

                            <td class="px-4 py-2 text-right">
                                ₱{{ number_format($credit->monthly_payment, 2) }}
                            </td>

                            <td class="px-4 py-2 text-center">
                                {{ $credit->start_date?->format('M d, Y') }}
                            </td>

                            <td class="px-4 py-2 text-center">
                                {{ $credit->end_date?->format('M d, Y') }}
                            </td>

                            <td class="px-4 py-2 text-center">
                                <span class="
                                    px-2 py-1 text-xs rounded-full
                                    @if($credit->status === 'active') bg-green-100 text-green-700
                                    @elseif($credit->status === 'paid') bg-blue-100 text-blue-700
                                    @elseif($credit->status === 'overdue') bg-red-100 text-red-700
                                    @elseif($credit->status === 'restructured') bg-yellow-100 text-yellow-700
                                    @else bg-gray-100 text-gray-700
                                    @endif
                                ">
                                    {{ ucfirst($credit->status) }}
                                </span>
                            </td>

                            <td class="px-4 py-2 text-center hidden">
                                <button
                                    @click="
                                        editCredit = {
                                            id: {{ $credit->id }},
                                            title:  @js($credit->title),
                                            original_amount: '{{ $credit->original_amount }}',
                                            monthly_payment: '{{ $credit->monthly_payment }}',
                                            start_date: '{{ $credit->start_date?->format('Y-m-d') }}',
                                            end_date: '{{ $credit->end_date?->format('Y-m-d') }}',
                                            status: @js($credit->status)
                                        };
                                        openEdit = true;
                                    "
                                    class="px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600"
                                >
                                    Edit
                                </button>
                                <!-- @can('delete', $credit)
                                    <button>Delete</button>
                                @endcan -->
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-4 text-center text-gray-500">
                                No credits yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
 
        <!-- Create Modal -->
        <div 
            x-show="openCreate"
            x-transition
            @click.self="openCreate = false"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
            x-cloak >
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">

                <h2 class="text-lg font-semibold mb-4">Add Credit</h2>

                <form method="POST" action="{{ route('credits.store') }}">
                    @csrf 
                    <!-- Title -->
                    <div class="mb-3">
                        <x-input-label for="title" value="Credit Title" />
                        <x-text-input
                            id="title"
                            name="title"
                            class="w-full"
                            required
                        />
                    </div>

                    <!-- Original Amount -->
                    <div class="mb-3">
                        <x-input-label for="original_amount" value="Original Amount" />
                        <x-text-input
                            id="original_amount"
                            name="original_amount"
                            type="number"
                            step="0.01"
                            class="w-full"
                            required
                        />
                    </div>
 

                    <!-- Monthly Payment -->
                    <div class="mb-3">
                        <x-input-label for="monthly_payment" value="Monthly Payment" />
                        <x-text-input
                            id="monthly_payment"
                            name="monthly_payment"
                            type="number"
                            step="0.01"
                            class="w-full"
                            required
                        />
                    </div>

                    <!-- Start Date -->
                    <div class="mb-3">
                        <x-input-label for="start_date" value="Start Date" />
                        <x-text-input
                            id="start_date"
                            name="start_date"
                            type="date"
                            class="w-full"
                        />
                    </div>

                    <!-- End Date -->
                    <div class="mb-3">
                        <x-input-label for="end_date" value="End Date" />
                        <x-text-input
                            id="end_date"
                            name="end_date"
                            type="date"
                            class="w-full"
                        />
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <x-input-label for="status" value="Status" />
                        <select
                            id="status"
                            name="status"
                            class="w-full border-gray-300 rounded-md shadow-sm"
                        >
                            <option value="active">Active</option>
                            <option value="paid">Paid</option>
                            <option value="overdue">Overdue</option>
                            <option value="restructured">Restructured</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
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
                            Save Credit
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
                    Edit Credit
                </h2>
 
                <form
                    :action="'/credits/' + editCredit.id"
                    method="POST"
                >
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <x-input-label value="Credit Title" />
                        <input
                            type="text"
                            name="title"
                            x-model="editCredit.title"
                            class="w-full border-gray-300 rounded-md"
                        >
                    </div>

                    <div class="mb-3">
                        <x-input-label value="Original Amount" />
                        <input
                            type="number"
                            step="0.01"
                            name="original_amount"
                            x-model="editCredit.original_amount"
                            class="w-full border-gray-300 rounded-md"
                        >
                    </div>

                    <div class="mb-3">
                        <x-input-label value="Monthly Payment" />
                        <input
                            type="number"
                            step="0.01"
                            name="monthly_payment"
                            x-model="editCredit.monthly_payment"
                            class="w-full border-gray-300 rounded-md"
                        >
                    </div>

                    <div class="mb-3">
                        <x-input-label value="Start Date" />
                        <input
                            type="date"
                            name="start_date"
                            x-model="editCredit.start_date"
                            class="w-full border-gray-300 rounded-md"
                        >
                    </div>

                    <div class="mb-3">
                        <x-input-label value="End Date" />
                        <input
                            type="date"
                            name="end_date"
                            x-model="editCredit.end_date"
                            class="w-full border-gray-300 rounded-md"
                        >
                    </div>

                    <div class="mb-3">
                        <x-input-label value="Status" />

                        <select
                            name="status"
                            x-model="editCredit.status"
                            class="w-full border-gray-300 rounded-md"
                        >
                            <option value="active">Active</option>
                            <option value="paid">Paid</option>
                            <option value="overdue">Overdue</option>
                            <option value="restructured">Restructured</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
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
                            Update Credit
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>


</x-app-layout>
