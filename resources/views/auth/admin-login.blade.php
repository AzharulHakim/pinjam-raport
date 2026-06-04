<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Sistem Peminjaman Raport</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
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

<body class="bg-dark-900 flex items-center justify-center min-h-screen text-gray-200 py-12 px-4">
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
                <div class="relative" x-data="{ showPassword: false }">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </span>
                    <input
                        class="w-full bg-dark-900 text-white border border-dark-600 rounded-lg py-2.5 pl-10 pr-10 focus:border-red-500 focus:ring-1 focus:ring-red-500 focus:outline-none placeholder-gray-600 transition-colors"
                        id="password" :type="showPassword ? 'text' : 'password'" name="password" required placeholder="••••••••">
                    
                    <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-300 focus:outline-none z-10">
                        <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.43 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <button
                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg shadow-red-900/20 transition-all transform hover:translate-y-[-1px] focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-dark-800"
                type="submit">
                Sign In
            </button>
        </form>

        <!-- Tombol Kembali ke Landing Page -->
        <div class="mt-6 text-center border-t border-dark-700 pt-4">
            <a href="{{ route('home') }}" class="text-xs text-gray-400 hover:text-red-500 transition-colors inline-flex items-center gap-1.5 focus:outline-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</body>

</html>