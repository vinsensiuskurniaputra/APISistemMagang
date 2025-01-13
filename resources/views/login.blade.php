<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sitama</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-900 h-screen flex items-center justify-center">
    <div class="bg-gray-800 p-8 rounded-lg shadow-xl w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white">Welcome Admin</h1>
            <p class="text-gray-400 mt-2">Please login to your account</p>
        </div>

        @if($errors->any())
            <div class="bg-red-500/10 border border-red-500 text-red-500 rounded p-4 mb-6">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="space-y-6">
                <div>
                    <label class="text-gray-300 block mb-2" for="username">Username</label>
                    <input type="text" id="username" name="username" 
                           class="w-full px-4 py-3 rounded bg-gray-700 border border-gray-600 text-white focus:outline-none focus:border-blue-500"
                           required>
                </div>

                <div>
                    <label class="text-gray-300 block mb-2" for="password">Password</label>
                    <input type="password" id="password" name="password" 
                           class="w-full px-4 py-3 rounded bg-gray-700 border border-gray-600 text-white focus:outline-none focus:border-blue-500"
                           required>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center text-gray-300">
                        <input type="checkbox" name="remember" class="mr-2">
                        Remember me
                    </label>
                </div>

                <button type="submit" 
                        class="w-full bg-red-500 text-white py-3 rounded hover:bg-red-600 transition-colors">
                    Login
                </button>
            </div>
        </form>
    </div>
</body>
</html>
