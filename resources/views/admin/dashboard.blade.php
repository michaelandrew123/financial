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
            modalType: null
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
                        <table class="min-w-full border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left">Title</th>
                                    <th class="px-4 py-3 text-left">Date</th>
                                    <th class="px-4 py-3 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="px-4 py-3">Sample Seminar</td>
                                    <td class="px-4 py-3">2025-01-01</td>
                                    <td class="px-4 py-3">
                                        Edit | Delete
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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

                    <div class="text-gray-500">
                        Work experience records will be displayed here.
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

                    <div class="text-gray-500">
                        Educational records will be displayed here.
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

                    <div class="text-gray-500">
                        Skills and competencies will be displayed here.
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
                                name="seminar_date"
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
                                name="company_name"
                                placeholder="Company Name"
                                class="w-full rounded border-gray-300">

                            <input
                                type="text"
                                name="position"
                                placeholder="Position"
                                class="w-full rounded border-gray-300">

                            <input
                                type="date"
                                name="start_date"
                                class="w-full rounded border-gray-300">

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

                            <input
                                type="text"
                                name="school_name"
                                placeholder="School Name"
                                class="w-full rounded border-gray-300">

                            <input
                                type="text"
                                name="course"
                                placeholder="Course"
                                class="w-full rounded border-gray-300">

                        </div>

                        <div class="border-t p-6 text-right">
                            <button
                                class="bg-green-600 text-white px-4 py-2 rounded">
                                Save School Record
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

                            <input
                                type="text"
                                name="skill_name"
                                placeholder="Skill Name"
                                class="w-full rounded border-gray-300">

                            <select
                                name="skill_level"
                                class="w-full rounded border-gray-300">

                                <option>Beginner</option>
                                <option>Intermediate</option>
                                <option>Advanced</option>
                                <option>Expert</option>

                            </select>

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