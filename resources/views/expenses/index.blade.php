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
  

        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-bold"> {{ __('Expenses') }} </h2>
                <p class="text-sm text-gray-500">
                    {{ __('Track your financial goals') }}
                </p>
            </div>

            <div class="text-right">
                <p class="text-sm text-gray-500">
                    Previous Month Expenses
                </p>
                <p class="text-3xl font-bold text-purple-600"> 
                    {{ number_format($previousMonthExpenses, 2)}} 
                </p>
            </div>
        </div>



    </x-slot> 
    <div x-data="{ openCreate: false }" class="py-12">



        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">  

                <!-- Summary Cards -->
                <div class="grid grid-cols-2 gap-4 mb-6">

                    <div class="bg-purple-50 p-4 rounded">
                        <p class="text-sm text-gray-500">
                            Active Transaction
                        </p>
                        <p class="text-2xl font-bold text-purple-600">
                            {{ $activeTransaction }}
                        </p>
                    </div>

                    <div class="bg-green-50 p-4 rounded">
                        <p class="text-sm text-gray-500">
                            Total Expenses for this month
                        </p>
                        <p class="text-2xl font-bold text-green-600">
                            {{ number_format($thisMonthExpenses, 2) }} 
                        </p>
                    </div>

                </div>
 
                <!-- Recent Expenses Activity -->
                <div class="mt-8">
                    

                    <div class="flex flex-row justify-between my-2"> 
                        <h3 class="font-bold mb-3">
                            Recent Transactions
                        </h3>
    
                        <x-secondary-button
                            @click="openCreate = true"
                        >
                            Add
                        </x-secondary-button> 
                    </div>


                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="p-2 text-left">Title</th>
                                <th class="p-2 text-left">Amount</th>
                                <th class="p-2 text-center">Period</th>
                                <th class="p-2 text-right">Notes</th>
                                <th class="p-2 text-right">Date</th>
                            </tr>
                        </thead>

                        <tbody> 
                            @forelse ($expenses as $expense)  
                                <tr class="border-b">
                                    <td class="p-2">{{ $expense->expense_name}}</td>
                                    <td class="p-2">{{ number_format($expense->amount, 2) }}</td>
                                    <td class="p-2"> 

                                        {{ $expense->period?->format('M d, Y') }}
                                    </td>
                                    <td class="p-2">{{ \Illuminate\Support\Str::limit($expense->notes, 100, '...') }} </td> 
                                    <td class="p-2 text-right  ">
                                       
                                        {{ $expense->created_at?->format('M d, Y') }}
                                    </td>
                                </tr> 
                            @empty 
                                <tr class="border-b"> 
                                    <td colspan="4" class="p-2 text-center font-semibold">
                                        No expenses yet.
                                    </td>
                                </tr>
                            @endforelse 
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $expenses->links() }}
                    </div>
                </div>
            </div> 
        </div>


        <!-- Create Modal -->
        <div 
            x-show="openCreate"
            x-transition
            @click.self="openCreate = false"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
            x-cloak 
        >
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">

                <h2 class="text-lg font-semibold mb-4">Add Expenses</h2>

                <form method="POST" action="{{ route('expenses.store') }}">
                    @csrf  
                    <!-- "Expense Name -->
                    <div class="mb-3">
                        <x-input-label for="expense_name" value="Expense Name" />
                        <x-text-input
                            id="expense_name"
                            name="expense_name"
                            class="w-full"
                            required
                            placeholder="Expense Name"
                        />
                    </div>

                    <!-- Amount -->
                    <div class="mb-3">
                        <x-input-label for="amount" value="Amount" />
                        <x-text-input
                            id="amount"
                            name="amount"
                            type="number"
                            step="0.01"
                            class="w-full"
                            required
                            placeholder="Enter amount"
                        />
                    </div>
 

                    <!-- Period -->
                    <div class="mb-3">
                        <x-input-label for="period" value="Period" />
                        <x-text-input
                            id="period"
                            name="period"
                            type="date" 
                            class="w-full"
                            required
                        />
                    </div>

                    <!-- Notes -->
                    <div class="mb-3">
                        <x-input-label for="notes" value="Notes" />
                        <x-textarea
                            id="notes"
                            name="notes"
                            rows="4"
                            class="w-full"
                            placeholder="Enter notes..."
                        /> 
                    </div>
 

                    <div class="flex justify-end gap-2 mt-4">
                        <button
                            type="button"
                            @click="openCreate = false"
                            class="px-4 py-2 bg-gray-300 rounded hidden"
                        >
                            Cancel
                        </button>

                        <x-primary-button>
                            Save Expenses
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div> 






  
    </div>
 
</x-app-layout>
