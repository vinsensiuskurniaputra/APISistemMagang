@extends('layouts.admin')

@section('title', 'Add Industry')

@section('content')
    <div class="bg-gray-800 rounded-lg shadow p-6">
        <form action="{{ route('admin.industries.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium">Industry Name</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full rounded bg-gray-700 border-gray-600 text-white" required>
                </div>

                <div>
                    <label for="city" class="block text-sm font-medium">City</label>
                    <input type="text" name="city" id="city" class="mt-1 block w-full rounded bg-gray-700 border-gray-600 text-white" required>
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium">Address</label>
                    <textarea name="address" id="address" rows="3" class="mt-1 block w-full rounded bg-gray-700 border-gray-600 text-white" required></textarea>
                </div>

                <div class="flex items-center space-x-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Save Industry
                    </button>
                    <a href="{{ route('admin.industries.index') }}" class="text-gray-400 hover:text-gray-300">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
