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

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

            <div class="float-right mb-5">   
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
                        <th class="px-4 py-2 text-left">Name</th>
                        <th class="px-4 py-2 text-right">Address</th>
                        <th class="px-4 py-2 text-right">Email</th>
                        <th class="px-4 py-2 text-right">Gross Salary</th>
                        <th class="px-4 py-2 text-center">Frequency</th>
                        <th class="px-4 py-2 text-center">Monthly</th>
                        <th class="px-4 py-2 text-center">Date</th>
                        <th class="px-4 py-2 text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($companies as $company)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2">
                                {{ $company->name }}
                            </td>
                            <td class="px-4 py-2 text-right">
                                {{ $company->address }}
                            </td>
                            <td class="px-4 py-2 text-right">
                                {{ $company->email }} 
                            </td>

                            <td class="px-4 py-2 text-right">
                                ₱{{ number_format($company->gross_salary, 2) }}
                            </td>

                     
                            <td class="px-4 py-2 text-right">
                                {{ $company->frequency }} 
                            </td>

                            <td class="px-4 py-2 text-right">
                                {{ $company->monthly }} 
                            </td> 

                            <td class="px-4 py-2 text-center">
                                {{ $company->effective_date?->format('M d, Y') }}
                            </td>
  
                            <td class="px-4 py-2 text-center">
                                <button
                                    @click="
                                        editCompany = {
                                            id: {{ $company->id }},
                                            name:  @js($company->name),
                                            address: @js($company->address),
                                            email: '{{ $company->email }}',
                                            gross_salary: '{{ $company->gross_salary }}',
                                            frequency: '{{ $company->frequency }}',
                                            effective_date: '{{ $company->effective_date?->format('Y-m-d') }}'
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
                                No company yet.
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
