@extends('layouts.admin')

@section('title', 'Lecturers Management')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('admin.lecturers.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 ml-auto rounded">
            Add New Lecturer
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-gray-800 shadow-md rounded-lg">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead>
                            <tr class="bg-gray-700">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Profile</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">NIP</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Students Count</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @foreach($lecturers as $lecturer)
                                <tr class="hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover" 
                                                 src="{{ $lecturer->user->profile_image }}" 
                                                 alt="{{ $lecturer->user->name }}'s profile">
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-300">{{ $lecturer->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $lecturer->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-300">
                                        {{ $lecturer->user->username }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-300">
                                        {{ $lecturer->students->count() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.lecturers.edit', $lecturer) }}" class="text-blue-500 hover:text-blue-700 mr-4">Edit</a>
                                        <form class="inline-block" action="{{ route('admin.lecturers.destroy', $lecturer) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $lecturers->links() }}
    </div>
</div>
@endsection
