@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-6">
        <!-- Stats Cards -->
        <div class="bg-gray-800 rounded-lg p-4 md:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm md:text-base">Total Students</p>
                    <h3 class="text-xl md:text-2xl font-bold">{{ $dashboardData['totalStudents'] }}</h3>
                </div>
                <div class="bg-blue-500/20 text-blue-500 p-2 md:p-3 rounded-full">
                    <i class="fas fa-user-graduate text-lg md:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-lg p-4 md:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm md:text-base">Total Guidances</p>
                    <h3 class="text-xl md:text-2xl font-bold">{{ $dashboardData['activeInternships'] }}</h3>
                </div>
                <div class="bg-green-500/20 text-green-500 p-2 md:p-3 rounded-full">
                    <i class="fas fa-comments text-lg md:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-lg p-4 md:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm md:text-base">Total Lecturers</p>
                    <h3 class="text-xl md:text-2xl font-bold">{{ $dashboardData['totalLecturers'] }}</h3>
                </div>
                <div class="bg-purple-500/20 text-purple-500 p-2 md:p-3 rounded-full">
                    <i class="fas fa-chalkboard-teacher text-lg md:text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-gray-800 rounded-lg p-4 md:p-6 overflow-x-auto">
        <h3 class="text-lg md:text-xl font-bold mb-4">Recent Activity</h3>
        <div class="space-y-4">
            @foreach($dashboardData['recentActivities'] as $activity)
                <div class="flex flex-col md:flex-row md:items-center justify-between p-4 bg-gray-700/50 rounded-lg">
                    <div class="flex items-center space-x-4 mb-2 md:mb-0">
                        <div class="bg-{{ $activity['color'] }}-500/20 text-{{ $activity['color'] }}-500 p-2 md:p-3 rounded-full">
                            <i class="fas fa-{{ $activity['icon'] }}"></i>
                        </div>
                        <div>
                            <p class="font-semibold">{{ $activity['title'] }}</p>
                            <p class="text-sm text-gray-400">{{ $activity['description'] }}</p>
                        </div>
                    </div>
                    <span class="text-sm text-gray-400">{{ $activity['time'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
@endsection
