@extends('layouts.admin')

@section('title', 'Industries')

@section('content')
    <div class="bg-gray-800 rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold">Industry List</h3>
            <a href="{{ route('admin.industries.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Add Industry
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-700 text-gray-200">
                        <th class="px-4 py-2 text-left">Name</th>
                        <th class="px-4 py-2 text-left">City</th>
                        <th class="px-4 py-2 text-left">Address</th>
                        <th class="px-4 py-2 text-center">Students</th>
                        <th class="px-4 py-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($industries as $industry)
                        <tr class="border-b border-gray-700">
                            <td class="px-4 py-2">{{ $industry->name }}</td>
                            <td class="px-4 py-2">{{ $industry->city }}</td>
                            <td class="px-4 py-2">{{ $industry->address }}</td>
                            <td class="px-4 py-2 text-center">{{ $industry->internships_count }}</td>
                            <td class="px-4 py-2 text-center space-x-2">
                                <a href="{{ route('admin.industries.edit', $industry) }}"
                                    class="text-blue-500 hover:text-blue-600">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.industries.destroy', $industry) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600"
                                        onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-2 text-center text-gray-400">No industries found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $industries->links() }}
        </div>
    </div>
@endsection
