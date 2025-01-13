@extends('layouts.admin')

@section('title', 'Add New Lecturer')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-300">Add New Lecturer</h1>
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

        <form action="{{ route('admin.lecturers.store') }}" method="POST" class="bg-gray-800 shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
            @csrf
            
            <div class="grid grid-cols-2 gap-6">
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
                        NIP
                    </label>
                    <input type="text" name="username" id="username" 
                        class="bg-gray-700 text-white rounded w-full p-2.5" 
                        value="{{ old('username') }}" required>
                </div>
            </div>

            <div class="flex items-center justify-end mt-6">
                <button type="submit" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Create Lecturer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
