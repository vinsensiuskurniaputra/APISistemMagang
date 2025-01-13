@extends('layouts.admin')

@section('title', 'Edit Industry')

@section('content')
    <div class="space-y-6">
        <div class="bg-gray-800 rounded-lg shadow p-6">
            <form action="{{ route('admin.industries.update', $industry) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium">Industry Name</label>
                        <input type="text" name="name" id="name" value="{{ $industry->name }}" class="mt-1 block w-full rounded bg-gray-700 border-gray-600 text-white" required>
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium">City</label>
                        <input type="text" name="city" id="city" value="{{ $industry->city }}" class="mt-1 block w-full rounded bg-gray-700 border-gray-600 text-white" required>
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium">Address</label>
                        <textarea name="address" id="address" rows="3" class="mt-1 block w-full rounded bg-gray-700 border-gray-600 text-white" required>{{ $industry->address }}</textarea>
                    </div>

                    <div class="flex items-center space-x-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                            Update Industry
                        </button>
                        <a href="{{ route('admin.industries.index') }}" class="text-gray-400 hover:text-gray-300">Cancel</a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Student Internship List -->
        <div class="bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-xl font-semibold mb-4">Student Internships</h3>
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-700 text-gray-200">
                            <th class="px-4 py-2 text-left">NIM</th>
                            <th class="px-4 py-2 text-left">Name</th>
                            <th class="px-4 py-2 text-left">Start Date</th>
                            <th class="px-4 py-2 text-left">End Date</th>
                            <th class="px-4 py-2 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($industry->internships as $internship)
                            <tr class="border-b border-gray-700">
                                <td class="px-4 py-2">{{ $internship->student->user->username }}</td>
                                <td class="px-4 py-2">{{ $internship->student->user->name }}</td>
                                <td class="px-4 py-2">{{ $internship->start_date }}</td>
                                <td class="px-4 py-2">{{ $internship->end_date ?? '-' }}</td>
                                <td class="px-4 py-2 text-center">
                                    @if(!$internship->student->is_finished)
                                        <span class="px-2 py-1 bg-green-500/10 text-green-500 rounded-full text-xs">Active</span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-500/10 text-gray-500 rounded-full text-xs">Completed</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-2 text-center text-gray-400">No students currently interning</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
