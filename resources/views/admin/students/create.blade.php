@extends('layouts.admin')

@section('title', 'Add New Student')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-300">Add New Student</h1>
            <a href="{{ route('admin.students.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to List
            </a>
        </div>

        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.students.store') }}" method="POST" class="bg-gray-800 shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
            @csrf
            
            <div class="grid grid-cols-2 gap-6">
                <!-- User Information -->
                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="name">
                        Full Name
                    </label>
                    <input type="text" name="name" id="name" 
                        class="bg-gray-700 text-white rounded w-full p-2.5" 
                        value="{{ old('name') }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input type="email" name="email" id="email" 
                        class="bg-gray-700 text-white rounded w-full p-2.5" 
                        value="{{ old('email') }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="username">
                        Username/NIM
                    </label>
                    <input type="text" name="username" id="username" 
                        class="bg-gray-700 text-white rounded w-full p-2.5" 
                        value="{{ old('username') }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="class">
                        Class
                    </label>
                    <input type="text" name="class" id="class" 
                        class="bg-gray-700 text-white rounded w-full p-2.5" 
                        value="{{ old('class') }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="academic_year">
                        Academic Year
                    </label>
                    <input type="text" name="academic_year" id="academic_year" 
                        class="bg-gray-700 text-white rounded w-full p-2.5" 
                        value="{{ old('academic_year') }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="study_program_id">
                        Study Program
                    </label>
                    <select name="study_program_id" id="study_program_id" 
                        class="bg-gray-700 text-white rounded w-full p-2.5" required>
                        <option value="">Select Study Program</option>
                        @foreach($studyPrograms as $program)
                            <option value="{{ $program->id }}" {{ old('study_program_id') == $program->id ? 'selected' : '' }}>
                                {{ $program->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="lecturer_id">
                        Supervisor Lecturer
                    </label>
                    <select name="lecturer_id" id="lecturer_id" 
                        class="bg-gray-700 text-white rounded w-full p-2.5" required>
                        <option value="">Select Lecturer</option>
                        @foreach($lecturers as $lecturer)
                            <option value="{{ $lecturer->id }}" {{ old('lecturer_id') == $lecturer->id ? 'selected' : '' }}>
                                {{ $lecturer->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="industry_id">
                        Industry
                    </label>
                    <select name="industry_id" id="industry_id" 
                        class="bg-gray-700 text-white rounded w-full p-2.5">
                        <option value="">Select Industry</option>
                        @foreach($industries as $industry)
                            <option value="{{ $industry->id }}" {{ old('industry_id') == $industry->id ? 'selected' : '' }}>
                                {{ $industry->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="start_date">
                        Internship Start Date
                    </label>
                    <input type="date" name="start_date" id="start_date" 
                        class="bg-gray-700 text-white rounded w-full p-2.5" 
                        value="{{ old('start_date') }}">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="end_date">
                        Internship End Date
                    </label>
                    <input type="date" name="end_date" id="end_date" 
                        class="bg-gray-700 text-white rounded w-full p-2.5" 
                        value="{{ old('end_date') }}">
                </div>
            </div>

            <div class="flex items-center justify-end mt-6">
                <button type="submit" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Create Student
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
