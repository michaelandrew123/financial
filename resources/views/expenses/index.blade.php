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
  

        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-bold"> {{ __('Expenses') }} </h2>
                <p class="text-sm text-gray-500">
                    {{ __('Track your financial goals') }}
                </p>
            </div>

            <div class="text-right">
                <p class="text-sm text-gray-500">Total Expenses for this month</p>
                <p class="text-3xl font-bold text-purple-600"> 
                 
                </p>
            </div>
        </div>



    </x-slot> 
    <div  x-data="{ open: false }" class="py-12">



        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">  

                <!-- Summary Cards -->
                <div class="grid grid-cols-2 gap-4 mb-6">

                    <div class="bg-purple-50 p-4 rounded">
                        <p class="text-sm text-gray-500">
                            Active Transaction
                        </p>
                        <p class="text-2xl font-bold text-purple-600">
                            
                        </p>
                    </div>

                    <div class="bg-green-50 p-4 rounded">
                        <p class="text-sm text-gray-500">
                            Previous Month Expenses
                        </p>
                        <p class="text-2xl font-bold text-green-600">
                          
                        </p>
                    </div>

                </div>
 
                <!-- Recent Savings Activity -->
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
                                    <td class="p-2">{{ $expense->amount }}</td>
                                    <td class="p-2">{{ $expense->period }}</td>
                                    <td class="p-2">{{ $expense->notes }}</td> 
                                    <td class="p-2 text-right text-green-600 font-semibold">
                                        {{ $expense->created_at->format('M d, y') }}
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









  
    </div>
 
</x-app-layout>
