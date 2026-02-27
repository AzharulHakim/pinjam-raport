<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Sistem Peminjaman Raport</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        dark: {
                            900: '#121212',
                            800: '#1e1e1e',
                            700: '#2d2d2d',
                            600: '#3d3d3d',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-dark-900 flex items-center justify-center h-screen text-gray-200">
    <div class="bg-dark-800 p-8 rounded-2xl shadow-2xl w-full max-w-md border border-dark-700">
        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-red-600 mb-4 shadow-lg shadow-red-900/20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                    </path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-white">Admin Login</h2>
            <p class="text-gray-400 text-sm mt-2">Masuk ke panel administrator</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-900/20 border border-red-900/50 text-red-400 px-4 py-3 rounded-lg mb-6 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/login/admin') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-gray-400 text-xs font-bold mb-2 uppercase tracking-wide"
                    for="email">Username/Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </span>
                    <input
                        class="w-full bg-dark-900 text-white border border-dark-600 rounded-lg py-2.5 pl-10 pr-4 focus:border-red-500 focus:ring-1 focus:ring-red-500 focus:outline-none placeholder-gray-600 transition-colors"
                        id="email" type="text" name="email" required placeholder="admin">
                </div>
            </div>

            <div>
                <label class="block text-gray-400 text-xs font-bold mb-2 uppercase tracking-wide"
                    for="password">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </span>
                    <input
                        class="w-full bg-dark-900 text-white border border-dark-600 rounded-lg py-2.5 pl-10 pr-4 focus:border-red-500 focus:ring-1 focus:ring-red-500 focus:outline-none placeholder-gray-600 transition-colors"
                        id="password" type="password" name="password" required placeholder="••••••••">
                </div>
            </div>

            <button
                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg shadow-red-900/20 transition-all transform hover:translate-y-[-1px] focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-dark-800"
                type="submit">
                Sign In
            </button>
        </form>
    </div>
</body>

</html>