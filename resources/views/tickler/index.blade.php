<x-app-layout>
    <x-slot name="header"> 
        <div class="flex flex-row justify-between"> 
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tickler') }}
            </h2> 
            <p class="text-center text-gray-500 font-bold "> <small>  {{ \Carbon\Carbon::now()->format('F d, Y') }}  </small></p>
        </div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">  
                    Hello world tickler
                </div>
            </div>
        </div>
    </div> 

</x-app-layout>