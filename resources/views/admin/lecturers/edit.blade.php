@extends('layouts.admin')

@section('title', 'Edit Lecturer')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-300">Edit Lecturer</h1>
            <a href="{{ route('admin.lecturers.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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

        <form action="{{ route('admin.lecturers.update', $lecturer) }}" method="POST" class="bg-gray-800 shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-2 gap-6">
                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="name">
                        Full Name
                    </label>
                    <input type="text" name="name" id="name" 
                        class="bg-gray-700 text-white rounded w-full p-2.5" 
                        value="{{ old('name', $lecturer->user->name) }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input type="email" name="email" id="email" 
                        class="bg-gray-700 text-white rounded w-full p-2.5" 
                        value="{{ old('email', $lecturer->user->email) }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="username">
                        NIP
                    </label>
                    <input type="text" name="username" id="username" 
                        class="bg-gray-700 text-white rounded w-full p-2.5" 
                        value="{{ old('username', $lecturer->user->username) }}" required>
                </div>

                <div class="col-span-2">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img class="h-20 w-20 rounded-full object-cover" 
                                src="{{ $lecturer->user->profile_image }}" 
                                alt="{{ $lecturer->user->name }}'s profile">
                        </div>
                        <div class="text-gray-300 text-sm">
                            Current profile picture
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end mt-6">
                <button type="submit" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Lecturer
                </button>
            </div>
        </form>

        <div class="mt-6">
            <h2 class="text-xl font-bold text-gray-300 mb-4">Students Under Supervision</h2>
            <div class="bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead>
                            <tr class="bg-gray-700">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">NIM</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Class</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @forelse($lecturer->students as $student)
                                <tr class="hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-300">
                                        {{ $student->user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-300">
                                        {{ $student->user->username }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-300">
                                        {{ $student->class }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                        No students under supervision yet
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
