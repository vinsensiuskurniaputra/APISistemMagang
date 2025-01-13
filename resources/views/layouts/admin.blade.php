<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Sitama Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Add Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gray-900 text-gray-100">
    <!-- Mobile Menu Button -->
    <button id="mobile-menu-button" class="fixed top-4 right-4 z-50 md:hidden bg-gray-800 text-white p-2 rounded-lg">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <aside id="sidebar"
        class="fixed top-0 left-0 h-screen w-64 bg-gray-800 border-r border-gray-700 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-40">
        <div class="p-6">
            <h1 class="text-2xl font-bold">📱 Sitama</h1>
            <p class="text-sm text-gray-400">Admin Dashboard</p>
        </div>
        <nav class="mt-6">
            <a href="{{ route('admin.dashboard') }}"
                class="block px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : '' }}">
                <i class="fas fa-home mr-2"></i> Dashboard
            </a>
            <a href="{{ route('admin.students.index') }}"
                class="block px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white">
                <i class="fas fa-user-graduate mr-2"></i> Student
            </a>
            <a href="{{ route('admin.lecturers.index') }}" class="block px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white">
                <i class="fas fa-chalkboard-teacher mr-2"></i> Lecturer
            </a>
            <a href="{{ route('admin.industries.index') }}" 
                class="block px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.industries.*') ? 'bg-gray-700 text-white' : '' }}">
                <i class="fas fa-industry mr-2"></i> Industry
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="md:ml-64 p-4 md:p-8 mt-16 md:mt-0">
        <!-- Top Navigation -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 space-y-4 md:space-y-0">
            <h2 class="text-2xl font-bold">@yield('title')</h2>
            <div class="flex items-center space-x-4">
                <span class="text-gray-400">{{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-600">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-500/10 border border-green-500 text-green-500 rounded p-4 mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-500/10 border border-red-500 text-red-500 rounded p-4 mb-6">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Stack for additional scripts -->
    @stack('scripts')

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const sidebar = document.getElementById('sidebar');
        let isSidebarOpen = false;

        mobileMenuButton.addEventListener('click', () => {
            isSidebarOpen = !isSidebarOpen;
            if (isSidebarOpen) {
                sidebar.classList.remove('-translate-x-full');
                mobileMenuButton.innerHTML = '<i class="fas fa-times"></i>';
            } else {
                sidebar.classList.add('-translate-x-full');
                mobileMenuButton.innerHTML = '<i class="fas fa-bars"></i>';
            }
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (isSidebarOpen && !sidebar.contains(e.target) && e.target !== mobileMenuButton) {
                sidebar.classList.add('-translate-x-full');
                mobileMenuButton.innerHTML = '<i class="fas fa-bars"></i>';
                isSidebarOpen = false;
            }
        });
    </script>
</body>

</html>
