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
                <h2 class="text-xl font-bold"> {{ __('Saving') }} </h2>
                <p class="text-sm text-gray-500">
                    {{ __('Track your financial goals') }}
                </p>
            </div>

            <div class="text-right">
                <p class="text-sm text-gray-500">Total Saved</p>
                <p class="text-3xl font-bold text-purple-600"> 
                    ₱{{ number_format($totalSaved, 2) }}
                </p>
            </div>
        </div>



    </x-slot> 
    <div  x-data="{ openCreate: false }" class="py-12">
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
                            This Month Saved
                        </p>
                        <p class="text-2xl font-bold text-green-600">
                            ₱{{ number_format($thisMonthSaved, 2) }}
                        </p>
                    </div>

                </div>


                <!-- Savings Goals -->
                <!-- <div class="space-y-5">

                    @forelse($savings as $saving)

                        <div>
                            <div class="flex justify-between mb-1">

                                <div>
                                    <p class="font-semibold">
                                        {{ $saving->goal_name }}
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        Target: ₱{{ number_format($saving->target_amount, 2) }}
                                    </p>

                                    <p class="text-xs text-gray-400">
                                        {{ ucfirst($saving->frequency) }}
                                    </p>
                                </div>

                                <span class="font-bold text-purple-600">
                                    Goal
                                </span>

                            </div>

                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-purple-600 h-3 rounded-full w-full"></div>
                            </div>
                        </div> 
                    @empty 
                        <div class="text-center text-gray-500 py-4">
                            No savings goals yet.
                        </div>

                    @endforelse

                </div> -->

                
                <!-- Savings Goals -->
                <div class="space-y-5 hidden">

                    <!-- Goal 1 -->
                    <div>
                        <div class="flex justify-between mb-1">
                            <div>
                                <p class="font-semibold">
                                    Emergency Fund
                                </p>
                                <p class="text-sm text-gray-500">
                                    ₱75,000 of ₱100,000
                                </p>
                            </div>

                            <span class="font-bold text-purple-600">
                                75%
                            </span>
                        </div>

                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-purple-600 h-3 rounded-full w-[75%]"></div>
                        </div>
                    </div>

                    <!-- Goal 2 -->
                    <div>
                        <div class="flex justify-between mb-1">
                            <div>
                                <p class="font-semibold">
                                    New Laptop
                                </p>
                                <p class="text-sm text-gray-500">
                                    ₱30,000 of ₱50,000
                                </p>
                            </div>

                            <span class="font-bold text-blue-600">
                                60%
                            </span>
                        </div>

                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-blue-500 h-3 rounded-full w-[60%]"></div>
                        </div>
                    </div>

                    <!-- Goal 3 -->
                    <div>
                        <div class="flex justify-between mb-1">
                            <div>
                                <p class="font-semibold">
                                    Vacation Fund
                                </p>
                                <p class="text-sm text-gray-500">
                                    ₱20,000 of ₱40,000
                                </p>
                            </div>

                            <span class="font-bold text-green-600">
                                50%
                            </span>
                        </div>

                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-green-500 h-3 rounded-full w-[50%]"></div>
                        </div>
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
                                <th class="p-2 text-left">Date</th>
                                <th class="p-2 text-left">Title</th>
                                <th class="p-2 text-center">Type</th>
                                <th class="p-2 text-right">Amount</th>
                            </tr>
                        </thead>

                        <tbody> 
                            @forelse ($savings as $saving)  
                                <tr class="border-b">
                                    <td class="p-2">{{ $saving->created_at->format('M d, y') }}</td>
                                    <td class="p-2">{{ $saving->goal_name }}</td>
                                    <td class="p-2 text-center">
                                        <span class="px-2 py-1 bg-green-100 text-green-600 rounded text-xs">
                                            Deposit
                                        </span>
                                    </td>
                                    <td class="p-2 text-right text-green-600 font-semibold">
                                        ₱{{ $saving->target_amount }}
                                    </td>
                                </tr> 
                            @empty 
                                <tr class="border-b"> 
                                    <td colspan="4" class="p-2 text-center font-semibold">
                                        No savings yet.
                                    </td>
                                </tr>
                            @endforelse 
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $savings->links() }}
                    </div>
                </div>
  

            </div> 
        </div>
 
        <!-- Modal -->
        <div 
            x-show="openCreate"
            x-transition
            @click.self="openCreate = false"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
            x-cloak
        >
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">

                <h2 class="text-lg font-semibold mb-4">Add Saving</h2>

                <form method="POST" action="{{ route('savings.store') }}">
                    @csrf

                    <!-- Goal Name -->
                    <div class="mb-3">
                        <x-input-label value="Goal Name" />
                        <x-text-input name="goal_name" class="w-full" required autofocus />
                    </div>

                    <!-- Target Amount -->
                    <div class="mb-3">
                        <x-input-label value="Target Amount" />
                        <x-text-input name="target_amount" type="number" class="w-full" required />
                    </div>

                    <!-- Frequency -->
                    <div class="mb-3">
                        <x-input-label value="Frequency" />
                        <select name="frequency" class="w-full border-gray-300 rounded">
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                            <option value="yearly">Yearly</option>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end space-x-2 mt-4">

                        <button type="button"
                                @click="open = false"
                                class="px-4 py-2 bg-gray-300 rounded hidden">
                            Cancel
                        </button>

                        <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div> 
    </div>
 
</x-app-layout>
