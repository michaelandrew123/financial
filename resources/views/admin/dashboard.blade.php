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
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    {{ __('Admin Panel') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    {{ __('Manage your portfolio content and system records.') }}
                </p>
            </div>

            <div class="text-right">
                <p class="text-sm text-gray-500">
                    Welcome back,
                </p>
                <p class="text-xl font-bold text-purple-600">
                    {{ auth()->user()->first_name }}
                </p>
            </div>
        </div>
    </x-slot>
  
    <div   
        class="py-12"
        x-data="{
            tab: 'seminar',
            showModal: false,
            modalType: null,
            stillInRole: false, 
            endDate: '',
            init() {
                this.$watch('stillInRole', value => {
                    if (value) {
                        this.endDate = '';
                    }
                });
            }
        }"> 
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Dashboard Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- Seminar -->
                <button
                    @click="tab = 'seminar'"
                    :class="tab === 'seminar' ? 'ring-2 ring-purple-500' : ''"
                    class="bg-white rounded-lg shadow hover:shadow-lg transition duration-200 p-6 border border-gray-100 text-left">

                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-purple-600">
                            Seminar
                        </h3>

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-8 w-8 text-purple-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 14l9-5-9-5-9 5 9 5z" />
                        </svg>
                    </div>

                    <p class="mt-3 text-sm text-gray-500">
                        Manage seminars, training sessions, and certifications.
                    </p>
                </button>

                <!-- Work Experience -->
                <button
                    @click="tab = 'work'"
                    :class="tab === 'work' ? 'ring-2 ring-blue-500' : ''"
                    class="bg-white rounded-lg shadow hover:shadow-lg transition duration-200 p-6 border border-gray-100 text-left">

                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-blue-600">
                            Work Experience
                        </h3>

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-8 w-8 text-blue-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M20 13V7a2 2 0 00-2-2h-3V4a2 2 0 00-2-2h-2a2 2 0 00-2 2v1H6a2 2 0 00-2 2v6" />
                        </svg>
                    </div>

                    <p class="mt-3 text-sm text-gray-500">
                        Manage employment history and professional experience.
                    </p>
                </button>

                <!-- School Experience -->
                <button
                    @click="tab = 'school'"
                    :class="tab === 'school' ? 'ring-2 ring-green-500' : ''"
                    class="bg-white rounded-lg shadow hover:shadow-lg transition duration-200 p-6 border border-gray-100 text-left">

                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-green-600">
                            School Experience
                        </h3>

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-8 w-8 text-green-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 14l9-5-9-5-9 5 9 5z" />
                        </svg>
                    </div>

                    <p class="mt-3 text-sm text-gray-500">
                        Manage educational background and academic achievements.
                    </p>
                </button>


                
                <!-- Skills -->
                <button
                    @click="tab = 'skillCategory'"
                    :class="tab === 'skillCategory' ? 'ring-2 ring-yellow-500' : ''"
                    class="bg-white rounded-lg shadow hover:shadow-lg transition duration-200 p-6 border border-gray-100 text-left">

                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-yellow-600">
                            Skill Category
                        </h3>

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-8 w-8 text-yellow-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>

                    <p class="mt-3 text-sm text-gray-500">
                        Manage technical skills, tools, and competencies.
                    </p>
                </button>




                <!-- Skills -->
                <button
                    @click="tab = 'skill'"
                    :class="tab === 'skill' ? 'ring-2 ring-orange-500' : ''"
                    class="bg-white rounded-lg shadow hover:shadow-lg transition duration-200 p-6 border border-gray-100 text-left">

                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-orange-600">
                            Skills
                        </h3>

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-8 w-8 text-orange-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>

                    <p class="mt-3 text-sm text-gray-500">
                        Manage technical skills, tools, and competencies.
                    </p>
                </button>



            </div>

            <!-- Content Panel -->
            <div class="mt-8">

                <!-- Seminar Panel -->
                <div x-show="tab === 'seminar'" x-transition
                    class="bg-white rounded-lg shadow p-6">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-purple-600">
                            Seminar Management
                        </h3>

                       
                        <button
                            @click="showModal=true; modalType='seminar'"
                            class="bg-purple-600 text-white px-4 py-2 rounded-lg">
                            Add Seminar
                        </button>
                    </div>

                    <div class="overflow-x-auto">

                    @if(isset($seminars) && $seminars->count() > 0)
                        <table class="min-w-full border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left">Title</th>
                                    <th class="px-4 py-3 text-left">Organizer</th>
                                    <th class="px-4 py-3 text-left">Start Date</th>
                                    <th class="px-4 py-3 text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($seminars as $seminar)
                                <tr>
                                    <td class="px-4 py-3">{{$seminar->title}}</td>
                                    <td class="px-4 py-3">{{$seminar->organizer}}</td>
                                    <td class="px-4 py-3">
                                    {{
                                        $seminar->start_date?->format('M d, Y')
                                    }}
                                    </td>
                                    <td class="px-4 py-3"> 
                                        <form
                                            method="POST" 
                                            action="{{ route('seminar.delete', $seminar->id) }}"
                                        >
                                            @csrf
                                            @method('DELETE') 
                                            <button
                                                type="submit"
                                                class="px-3 py-1 rounded bg-red-600 text-white hover:bg-red-700" 
                                            >Delete</button>
                                        </form> 
                                    </td>
                                </tr>
                                @endforeach 
                            </tbody>
                        </table>   
                        @else
                            Seminar records will be displayed here.
                        @endif
                    </div>

                </div>

                <!-- Work Experience Panel -->
                <div x-show="tab === 'work'" x-transition
                    class="bg-white rounded-lg shadow p-6">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-blue-600">
                            Work Experience Management
                        </h3>

                        <button
                            @click="showModal=true; modalType='work'"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Add Work Experience
                        </button>
                    </div>

                    <div class="text-gray-500 overflow-x-auto">
                        @if(isset($experiences) && $experiences->count() > 0)
                            <table class="min-w-full border border-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left">Position</th>
                                        <th class="px-4 py-3 text-left">company</th>
                                        <th class="px-4 py-3 text-left">Location</th> 
                                        <th class="px-4 py-3 text-left">Description</th>
                                        <th class="px-4 py-3 text-left">Start_date</th>
                                        <th class="px-4 py-3 text-left">End_date</th>
                                        <th class="px-4 py-3 text-left">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($experiences as $experience)
                                    <tr>
                                        <td class="px-4 py-3">{{$experience->position}}</td>
                                        <td class="px-4 py-3">{{$experience->company}}</td>
                                        <td class="px-4 py-3">{{$experience->location}}</td> 
                                        <td class="px-4 py-3">{{ \Illuminate\Support\Str::limit($experience->description, 100) }}</td>
                                        <td class="px-4 py-3">{{$experience->start_date?->format('M d, Y') }}</td>
                                        <td class="px-4 py-3"> {{ $experience->still_in_role ? 'Present' : $experience->end_date?->format('M d, Y') }}</td> 
                                        <td class="px-4 py-3">  
                                            ---
                                            <!-- <form
                                                method="POST" 
                                                action="{{ route('seminar.delete', $seminar->id) }}"
                                            >
                                                @csrf
                                                @method('DELETE') 
                                                <button
                                                    type="submit"
                                                    class="px-3 py-1 rounded bg-red-600 text-white hover:bg-red-700" 
                                                >Delete</button>
                                            </form>  -->
                                        </td>
                                    </tr>
                                    @endforeach 
                                </tbody>
                            </table> 
                        @else
                            Work experience records will be displayed here.
                        @endif
                    </div>

                </div>

                <!-- School Experience Panel -->
                <div x-show="tab === 'school'" x-transition
                    class="bg-white rounded-lg shadow p-6">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-green-600">
                            School Experience Management
                        </h3>

                        <button
                            @click="showModal=true; modalType='school'"
                            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                            Add School Record
                        </button>
                    </div>

                    <div class="text-gray-500 overflow-x-auto">
                        @if(isset($schoolExperiences) && $schoolExperiences->count() > 0)
                            <table class="min-w-full border border-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left">Company</th>
                                        <th class="px-4 py-3 text-left">Department</th>
                                        <th class="px-4 py-3 text-left">Location</th>
                                        <th class="px-4 py-3 text-left">Event</th>
                                        <th class="px-4 py-3 text-left">Description</th>
                                        <th class="px-4 py-3 text-left">Start_date</th>
                                        <th class="px-4 py-3 text-left">End_date</th>
                                        <th class="px-4 py-3 text-left">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($schoolExperiences as $schoolExperience)
                                    <tr>
                                        <td class="px-4 py-3">{{$schoolExperience->company}}</td>
                                        <td class="px-4 py-3">{{$schoolExperience->department}}</td>
                                        <td class="px-4 py-3">{{$schoolExperience->location}}</td>
                                        <td class="px-4 py-3">{{$schoolExperience->event}}</td>
                                        <td class="px-4 py-3">{{ \Illuminate\Support\Str::limit($schoolExperience->description, 100) }}</td>
                                        <td class="px-4 py-3">{{$schoolExperience->start_date?->format('M d, Y') }}</td>
                                        <td class="px-4 py-3">{{$schoolExperience->end_date?->format('M d, Y') }}</td> 
                                        <td class="px-4 py-3">  
                                            ---
                                            <!-- <form
                                                method="POST" 
                                                action="{{ route('seminar.delete', $seminar->id) }}"
                                            >
                                                @csrf
                                                @method('DELETE') 
                                                <button
                                                    type="submit"
                                                    class="px-3 py-1 rounded bg-red-600 text-white hover:bg-red-700" 
                                                >Delete</button>
                                            </form>  -->
                                        </td>
                                    </tr>
                                    @endforeach 
                                </tbody>
                            </table> 
                        @else
                            Educational records will be displayed here.
                        @endif

                        
                    </div>

                </div>

                <!-- Skills Panel -->
                <div x-show="tab === 'skill'" x-transition
                    class="bg-white rounded-lg shadow p-6">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-orange-600">
                            Skills Management
                        </h3>

                        <button
                            @click="showModal=true; modalType='skill'"
                            class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700">
                            Add Skill
                        </button>
                    </div>

                    <div class="text-gray-500 overflow-x-auto"> 
                        @if(isset($skills) && $skills->count() > 0)
                            <table class="min-w-full border border-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left">Name</th>
                                        <th class="px-4 py-3 text-left">Skill Level</th>
                                        <th class="px-4 py-3 text-left">Experience Years</th>
                                        <th class="px-4 py-3 text-left">Experience Months</th> 
                                        <th class="px-4 py-3 text-left">Category</th> 
                                        <th class="px-4 py-3 text-left">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($skills as $skill)
                                    <tr>
                                        <td class="px-4 py-3">{{$skill->name}}</td>
                                        <td class="px-4 py-3">{{$skill->skill_level}}</td>
                                        <td class="px-4 py-3">{{$skill->experience_years}}</td>
                                        <td class="px-4 py-3">{{$skill->experience_months}}</td> 
                                        <td class="px-4 py-3">{{$skill->skillCategory?->name}}</td> 
                                        <td class="px-4 py-3">  
                                            ---
                                            <!-- <form
                                                method="POST" 
                                                action="{{ route('seminar.delete', $seminar->id) }}"
                                            >
                                                @csrf
                                                @method('DELETE') 
                                                <button
                                                    type="submit"
                                                    class="px-3 py-1 rounded bg-red-600 text-white hover:bg-red-700" 
                                                >Delete</button>
                                            </form>  -->
                                        </td>
                                    </tr>
                                    @endforeach 
                                </tbody>
                            </table> 
                        @else
                            Skills and competencies will be displayed here.
                        @endif
                    </div>

                </div>


                <!-- Skills Category Panel -->
                <div x-show="tab === 'skillCategory'" x-transition
                    class="bg-white rounded-lg shadow p-6">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-yellow-600">
                            Skill Category Management
                        </h3>

                        <button
                            @click="showModal=true; modalType='skillCategory'"
                            class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700">
                            Add Skill
                        </button>
                    </div>

                    <div class="text-gray-500 overflow-x-auto">


                        @if(isset($skillCategories) && $skillCategories->count() > 0)
                            <table class="min-w-full border border-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left">Name</th> 
                                        <th class="px-4 py-3 text-left">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($skillCategories as $skillCategory)
                                    <tr>
                                        <td class="px-4 py-3">{{$skillCategory->name}}</td> 
                                        <td class="px-4 py-3">  
                                            ----
                                            <!-- <form
                                                method="POST" 
                                                action="{{ route('seminar.delete', $seminar->id) }}"
                                            >
                                                @csrf
                                                @method('DELETE') 
                                                <button
                                                    type="submit"
                                                    class="px-3 py-1 rounded bg-red-600 text-white hover:bg-red-700" 
                                                >Delete</button>
                                            </form>  -->
                                        </td>
                                    </tr>
                                    @endforeach 
                                </tbody>
                            </table> 
                        @else
                            Skills Category will be displayed here.
                        @endif 
                    </div>

                </div>



            </div>

        </div>

 
        
        <!-- REUSABLE MODAL -->
        <div
            x-show="showModal"
            x-cloak
            class="fixed inset-0 z-50 overflow-y-auto">

            <!-- Overlay -->
            <div
                class="fixed inset-0 bg-black bg-opacity-50"
                @click="showModal = false">
            </div>

            <!-- Modal -->
            <div class="flex items-center justify-center min-h-screen p-4 z-10 relative">

                <div
                    @click.stop
                    class="bg-white rounded-lg shadow-xl w-full max-w-2xl">

                    <!-- Header -->
                    <div class="flex justify-between items-center border-b p-6">

                        <h3 class="text-xl font-bold">

                            <span x-show="modalType === 'seminar'">
                                Add Seminar
                            </span>

                            <span x-show="modalType === 'work'">
                                Add Work Experience
                            </span>

                            <span x-show="modalType === 'school'">
                                Add School Experience
                            </span>


                            <span x-show="modalType === 'skillCategory'">
                                Add Category Skill
                            </span>
                            <span x-show="modalType === 'skill'">
                                Add Skill
                            </span>

                        </h3>
                        
                        <button
                            @click="showModal = false"
                            class="text-gray-500 text-xl">
                            ×
                        </button>

                    </div>

                    <!-- BODY -->

                  <!-- SEMINAR FORM -->
                  <form
                        x-show="modalType === 'seminar'"
                        action="{{ route('seminar.store') }}"
                        method="POST">

                        @csrf

                        <div class="p-6 space-y-4">

                            <input
                                type="text"
                                name="title"
                                placeholder="Seminar Title"
                                class="w-full rounded border-gray-300">

                            <input
                                type="text"
                                name="organizer"
                                placeholder="Organizer"
                                class="w-full rounded border-gray-300">

                            <input
                                type="date"
                                name="start_date"
                                class="w-full rounded border-gray-300">

                        </div>

                        <div class="border-t p-6 text-right">
                            <button
                                class="bg-purple-600 text-white px-4 py-2 rounded">
                                Save Seminar
                            </button>
                        </div>

                    </form>

                    <!-- WORK FORM -->
                    <form
                        x-show="modalType === 'work'"  
          
                        action="{{ route('work-experience.store') }}"
                        method="POST">

                        @csrf

                        <div class="p-6 space-y-4">
 
                            <input
                                type="text"
                                name="position"
                                placeholder="Job Title"
                                class="w-full rounded border-gray-300">


                            <input
                                type="text"
                                name="company"
                                placeholder="Company Name"
                                class="w-full rounded border-gray-300">
 
                            <input
                                type="text"
                                name="location"
                                placeholder="Company Location"
                                class="w-full rounded border-gray-300">

                            <input
                                type="date"
                                name="start_date"
                                class="w-full rounded border-gray-300"> 
                            
                            <!-- Checkbox -->
                            <div class="flex items-center gap-2">
                                <x-checkbox
                                    id="still_in_role"
                                    name="still_in_role"     
                                    x-model="stillInRole"    
                                    value="0"
                                />
                                <!-- @change="if (stillInRole) endDate = ''" -->
                                <label for="still_in_role" class="text-sm text-gray-700">
                                    I currently work here
                                </label> 
                            </div>
                            <!-- stillInRole: <span x-text="stillInRole"></span><br>
                            endDate: <span x-text="endDate"></span> -->
                            <!-- End Date -->
                            <div x-show="!stillInRole" x-transition>
                     
                                <input
                                    type="date"
                                    name="end_date" 
                                    x-model="endDate"
                                    class="w-full rounded border-gray-300">
                            </div>

                                
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
                        </div>

                        <div class="border-t p-6 text-right">
                            <button
                                class="bg-blue-600 text-white px-4 py-2 rounded">
                                Save Work Experience
                            </button>
                        </div>

                    </form>

                    <!-- SCHOOL FORM -->
                    <form
                        x-show="modalType === 'school'"
                        action="{{ route('school-experience.store') }}"
                        method="POST">

                        @csrf

                        <div class="p-6 space-y-4">
                             
 
                            <div class="mb-3">
                                <x-input-label value="Company Name" />
                                <x-text-input 
                                    type="text" 
                                    name="Company Name" 
                                    class="w-full" 
                                    required 
                                    autofocus />
                            </div>
                            <div class="mb-3">
                                <x-input-label value="Department" />
                                <x-text-input 
                                    type="text" 
                                    name="Department" 
                                    class="w-full" 
                                    required 
                                    autofocus />
                            </div> 
                            
                            <div class="mb-3">
                                <x-input-label value="Location" />
                                <x-text-input 
                                    type="text" 
                                    name="location" 
                                    class="w-full" 
                                    required 
                                    autofocus />
                            </div> 
 
                            <div class="mb-3">
                                <x-input-label value="Event" />
                                <x-text-input 
                                    type="text" 
                                    name="event" 
                                    class="w-full" 
                                    required 
                                    autofocus />
                            </div>  

                            <div class="mb-3">
                                <x-input-label value="Start Date" />
                                <x-text-input 
                                    type="date" 
                                    name="start_date" 
                                    class="w-full" 
                                    required 
                                    autofocus />
                            </div>  
                            <div class="mb-3">
                                <x-input-label value="End Date" />
                                <x-text-input 
                                    type="date" 
                                    name="end_date" 
                                    class="w-full" 
                                    required 
                                    autofocus />
                            </div>   
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
                        </div>

                        <div class="border-t p-6 text-right">
                            <button
                                class="bg-green-600 text-white px-4 py-2 rounded">
                                Save School Record
                            </button>
                        </div>

                    </form>




                    
                    <!-- SKILL CATEGORY FORM -->
                    <form
                        x-show="modalType === 'skillCategory'"
                        action="{{ route('skill-category.store') }}"
                        method="POST">

                        @csrf 
                        <div class="p-6 space-y-4">
                            <div class="mb-3">
                                <x-input-label value="Skill Name" />
                                <x-text-input 
                                    type="text" 
                                    name="name" 
                                    class="w-full" 
                                    required 
                                    autofocus />
                            </div>     
                        </div> 
                        <div class="border-t p-6 text-right">
                            <button
                                class="bg-yellow-600 text-white px-4 py-2 rounded">
                                Save Category Skill
                            </button>
                        </div>

                    </form>



                    <!-- SKILL FORM -->
                    <form
                        x-show="modalType === 'skill'"
                        action="{{ route('skill.store') }}"
                        method="POST">

                        @csrf

                        <div class="p-6 space-y-4">
                            <div class="mb-3">

                                <x-input-label value="Skill Name" />
                                <x-text-input 
                                    type="text"
                                    name="name" 
                                    class="w-full"  
                                    required 
                                    autofocus /> 
 
                            </div> 
                            
                            <div class="mb-3">
                                <select name="skill_level" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" required>
                                    <option value="">Select Level</option>
                                    <option value="Beginner">Beginner</option>
                                    <option value="Intermediate">Intermediate</option>
                                    <option value="Advanced">Advanced</option>
                                    <option value="Expert">Expert</option>
                                </select> 
                            </div> 
                            <div class="mb-3">
                                <x-input-label for="skill_category_id" value="Parent Category" />
                                <select
                                    id="skill_category_id"
                                    name="skill_category_id"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                    required
                                >
                                    <option value="">Select a category</option>

                                    @foreach ($skillCategories as $category)
                                        <option
                                            value="{{ $category->id }}"
                                            {{ old('skill_category_id') == $category->id ? 'selected' : '' }}
                                        >
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
          

                                <x-input-error :messages="$errors->get('skill_category_id')" class="mt-2" />
                            </div> 
                            <div class="mb-3">
                                <x-input-label value="Experience Years" />
                                <x-text-input 
                                    type="number"
                                    name="experience_years" 
                                    class="w-full" 
                                    min="0"
                                    required 
                                    autofocus />
                            </div>   
                            <div class="mb-3">
                                <x-input-label value="Experience Months" />
                                <x-text-input 
                                    type="number"
                                    name="experience_months" 
                                    min="0" max="11"
                                    class="w-full" 
                                    required 
                                    autofocus />
                            </div>    
                        </div>

                        <div class="border-t p-6 text-right">
                            <button
                                class="bg-orange-600 text-white px-4 py-2 rounded">
                                Save Skill
                            </button>
                        </div>

                    </form>


                    


                </div>

            </div>

        </div>


    </div>

</x-app-layout>