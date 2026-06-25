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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Company') }}
        </h2>
    </x-slot> 
    <div   
        x-data="{
            openCreate: false,
            openEdit: false,
            editCompany: {}
        }" 
        class="py-12">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"> 
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg"> 
        

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

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($companies as $company)
                        <div class="bg-white rounded-lg shadow border border-gray-200 p-5">
                            <div class="mb-4 flex flex-row justify-between">
                                
                                <div class="">
                                    <h3 class="text-lg font-semibold text-gray-800">
                                        {{ $company->name }}
                                    </h3>
                                    <p class="text-sm text-gray-500">
                                        {{ $company->email }}
                                    </p>
                                </div>
                                <div class="flex justify-between">
                                    @if($company->is_active)
                                        <div>
                                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 ">
                                                Active
                                            </span>
                                        </div>
                                    @else
                                        <div>
                                            <span class="px-2 py-1 text-xs bg-red-100 text-red-700 ">
                                                Inactive
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>


                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Address</span>
                                    <span class="font-medium">{{ $company->address }}</span>
                                </div>

                         
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Gross Salary</span>
                                    <span class="font-semibold text-green-600">
                                        ₱{{ number_format($company->gross_salary, 2) }}
                                    </span>
                                </div>

                                <div class="flex justify-between">
                                    <span class="text-gray-500">Frequency</span>
                                    <span>{{ ucfirst($company->frequency) }}</span>
                                </div>
 

                                <div class="flex justify-between">
                                    <span class="text-gray-500">Effective Date</span>
                                    <span>
                                        {{ $company->effective_date?->format('M d, Y') }}
                                    </span>
                                </div>

                            </div>

                            <div class="mt-5 pt-4 border-t">
                                <button
                                    @click="
                                        editCompany = {
                                            id: {{ $company->id }},
                                            name: @js($company->name),
                                            address: @js($company->address),
                                            email: @js($company->email),
                                            gross_salary: '{{ $company->gross_salary }}',
                                            frequency: '{{ $company->frequency }}',
                                            effective_date: '{{ $company->effective_date?->format('Y-m-d') }}'
                                            is_active: @js((bool) $company->is_active),
                                        };
                                        openEdit = true;
                                    "
                                    class="w-full px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600"
                                >
                                    Edit Company
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-8 text-gray-500">
                            No company yet.
                        </div>
                    @endforelse
                </div>





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

                <h2 class="text-lg font-semibold mb-4">Add Company</h2>

                <form method="POST" action="{{ route('companies.store') }}">
                    @csrf 
                    <!-- Company Name -->
                    <div class="mb-3">
                        <x-input-label for="name" value="Company Name" />
                        <x-text-input
                            id="name"
                            name="name"
                            class="w-full"
                            required
                        />
                    </div>

                    <!-- address-->
                    <div class="mb-3">
                        <x-input-label for="address" value="address" />
                        <x-text-input
                            id="address"
                            name="address" 
                            class="w-full"
                            required
                        />
                    </div>
 

                    <!-- Email -->
                    <div class="mb-3">
                        <x-input-label for="email" value="Email" />
                        <x-text-input
                            id="email"
                            name="email"
                            type="email"
                            class="w-full"
                            placeholder="company@example.com"
                            required
                        />
                    </div>
 
                    <div class="mb-3">
                        <x-input-label for="gross_salary" value="Salary" />
                        <x-text-input
                            id="gross_salary"
                            name="gross_salary"
                            type="number"
                            step="0.01"
                            class="w-full"
                            required
                        />
                    </div>

                    <!-- frequency -->
                    <div class="mb-3">
                        <x-input-label for="frequency" value="Pay Frequency" />
                        <select
                            id="frequency"
                            name="frequency"
                            class="w-full border-gray-300 rounded-md shadow-sm"
                        >
                            <option value="weekly">Weekly</option>
                            <option value="biweekly">Biweekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <x-input-label for="effective_date" value="" />
                        <x-text-input
                            id="effective_date"
                            name="effective_date"
                            type="date"
                            class="w-full"
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
                            Save Company
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
                    Edit Company
                </h2>
 
                <form
                    :action="'/companies/' + editCompany.id"
                    method="POST"
                >
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <x-input-label value="Company Name" />
                        <input
                            type="text"
                            name="name"
                            x-model="editCompany.name"
                            class="w-full border-gray-300 rounded-md"
                        >
                    </div>

                    <div class="mb-3">
                        <x-input-label value="Address" />
                        <input
                            type="text"
                            name="address"
                            x-model="editCompany.address"
                            class="w-full border-gray-300 rounded-md"
                        >
                    </div>

                    <div class="mb-3">
                        <x-input-label for="email" value="Email" />
            
                        <x-text-input
                            id="email"
                            name="email"
                            type="email"
                            class="w-full"
                            x-model="editCompany.email"
                            placeholder="company@example.com"
                            required
                        />
                    </div>

                    <div class="mb-3">
                        <x-input-label for="gross_salary" value="Gross Salary" />
                        <input 
                            id="gross_salary"
                            name="gross_salary"
                            type="number"
                            step="0.01"
                            x-model="editCompany.gross_salary"
                            class="w-full border-gray-300 rounded-md"
                        >
                    </div>

                    <div class="mb-3">
                        <x-input-label for="frequency" value="Frequency" />
                        <select
                            id="frequency"
                            name="frequency"
                            x-model="editCompany.frequency"
                            class="w-full border-gray-300 rounded-md shadow-sm"
                        >
                            <option value="weekly">Weekly</option>
                            <option value="biweekly">Biweekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>
 
                    <div class="mb-3">
                        <x-input-label for="effective_date" value="Effective Date" />
                        <x-text-input
                            id="effective_date"
                            name="effective_date"
                            type="date"
                            class="w-full" 
                            x-model="editCompany.effective_date"
                        />
                    </div>
                    <div class="mb-3">
                        <x-input-label for="is_active" value="Status" />

                        <select
                            id="is_active"
                            name="is_active"
                            x-model="editCompany.is_active"
                            class="w-full border-gray-300 rounded-md shadow-sm"
                        >
                            <option :value="true">Active</option>
                            <option :value="false">Inactive</option>
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
                            Update
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>


</x-app-layout>
