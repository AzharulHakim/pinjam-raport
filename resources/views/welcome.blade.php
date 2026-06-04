<!DOCTYPE html>
<html lang="id" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Peminjaman Raport - Selamat Datang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        dark: {
                            950: '#09090b',
                            900: '#121212',
                            800: '#1a1a1a',
                            700: '#262626',
                            600: '#333333',
                        }
                    },
                    animation: {
                        'pulse-slow': 'pulse 8s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #09090b;
        }
        .glow-blue:hover {
            box-shadow: 0 0 30px rgba(37, 99, 235, 0.2);
            border-color: rgba(37, 99, 235, 0.4);
        }
        .glow-red:hover {
            box-shadow: 0 0 30px rgba(220, 38, 38, 0.2);
            border-color: rgba(220, 38, 38, 0.4);
        }
    </style>
</head>

<body class="text-gray-200 min-h-screen flex flex-col justify-between overflow-x-hidden relative selection:bg-blue-600/30 selection:text-blue-200">
    
    <!-- Ambient Background Glows -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-600/10 rounded-full blur-[100px] pointer-events-none animate-pulse-slow"></div>
    <div class="absolute bottom-10 right-1/4 w-96 h-96 bg-red-600/10 rounded-full blur-[100px] pointer-events-none animate-pulse-slow"></div>

    <!-- Header / Navbar -->
    <header class="w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between z-10">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-red-600 flex items-center justify-center shadow-lg shadow-blue-500/10">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <span class="font-extrabold text-lg tracking-wider bg-clip-text text-transparent bg-gradient-to-r from-white via-gray-200 to-gray-400">
                PINJAM RAPORT
            </span>
        </div>
        <div class="text-xs text-gray-500 bg-dark-800/50 backdrop-blur-md px-3 py-1.5 rounded-full border border-dark-700/50">
            v1.0.0
        </div>
    </header>

    <!-- Main Content -->
    <main class="w-full max-w-5xl mx-auto px-6 py-12 flex-grow flex flex-col justify-center items-center z-10">
        
        <!-- Hero Section -->
        <div class="text-center max-w-2xl mx-auto mb-16 animate-float">
            <span class="px-4 py-1.5 rounded-full text-xs font-semibold tracking-wider text-blue-400 bg-blue-500/10 border border-blue-500/20 uppercase">
                Sistem Peminjaman Raport
            </span>
            <h1 class="text-4xl md:text-5xl font-extrabold mt-6 tracking-tight text-white leading-tight">
                Selamat Datang di <br>
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 via-indigo-200 to-red-400">
                    Sistem Layanan Raport
                </span>
            </h1>
            <p class="text-gray-400 mt-4 text-base md:text-lg leading-relaxed">
                Silakan pilih salah satu portal di bawah ini untuk mengakses sistem peminjaman dan pengembalian raport sekolah.
            </p>
        </div>

        <!-- Selection Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-4xl">
            
            <!-- Siswa Selection Card -->
            <div class="bg-dark-800/40 backdrop-blur-md border border-dark-700 rounded-3xl p-8 flex flex-col justify-between transition-all duration-300 hover:-translate-y-2 glow-blue group relative overflow-hidden">
                <!-- Background Accent Glow -->
                <div class="absolute -right-16 -top-16 w-32 h-32 bg-blue-600/10 rounded-full blur-2xl group-hover:bg-blue-600/20 transition-all duration-300"></div>
                
                <div>
                    <!-- Icon Wrapper -->
                    <div class="w-14 h-14 rounded-2xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center mb-8 shadow-inner shadow-blue-500/5 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>

                    <!-- Card Header -->
                    <h2 class="text-2xl font-bold text-white mb-3">Portal Siswa</h2>
                    
                    <!-- Card Description -->
                    <p class="text-gray-400 text-sm leading-relaxed mb-8">
                        Gunakan portal ini jika Anda adalah siswa yang ingin melakukan peminjaman raport, mengembalikan raport, atau melihat riwayat peminjaman raport pribadi Anda.
                    </p>
                </div>

                <!-- CTA Button -->
                <a href="{{ route('login.student') }}" class="w-full py-4 px-6 rounded-2xl bg-blue-600 hover:bg-blue-500 text-white font-semibold text-center flex items-center justify-center gap-2 transition-all duration-300 shadow-lg shadow-blue-900/30 hover:shadow-blue-500/20 group-hover:translate-x-1">
                    <span>Masuk sebagai Siswa</span>
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                    </svg>
                </a>
            </div>

            <!-- Admin Selection Card -->
            <div class="bg-dark-800/40 backdrop-blur-md border border-dark-700 rounded-3xl p-8 flex flex-col justify-between transition-all duration-300 hover:-translate-y-2 glow-red group relative overflow-hidden">
                <!-- Background Accent Glow -->
                <div class="absolute -right-16 -top-16 w-32 h-32 bg-red-600/10 rounded-full blur-2xl group-hover:bg-red-600/20 transition-all duration-300"></div>

                <div>
                    <!-- Icon Wrapper -->
                    <div class="w-14 h-14 rounded-2xl bg-red-500/10 border border-red-500/20 flex items-center justify-center mb-8 shadow-inner shadow-red-500/5 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"></path>
                        </svg>
                    </div>

                    <!-- Card Header -->
                    <h2 class="text-2xl font-bold text-white mb-3">Portal Admin</h2>
                    
                    <!-- Card Description -->
                    <p class="text-gray-400 text-sm leading-relaxed mb-8">
                        Gunakan portal ini jika Anda adalah petugas atau administrator yang mengelola data siswa, administrasi kelas, verifikasi transaksi peminjaman, serta memantau laporan.
                    </p>
                </div>

                <!-- CTA Button -->
                <a href="{{ route('login.admin') }}" class="w-full py-4 px-6 rounded-2xl bg-red-600 hover:bg-red-500 text-white font-semibold text-center flex items-center justify-center gap-2 transition-all duration-300 shadow-lg shadow-red-900/30 hover:shadow-red-500/20 group-hover:translate-x-1">
                    <span>Masuk sebagai Admin</span>
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                    </svg>
                </a>
            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer class="w-full max-w-7xl mx-auto px-6 py-8 border-t border-dark-800/40 flex flex-col md:flex-row items-center justify-between gap-4 z-10">
        <p class="text-xs text-gray-500 text-center md:text-left">
            &copy; 2026 Sistem Peminjaman Raport by Azharul Hakim.
        </p>
        <div class="flex items-center gap-6">
            <span class="text-xs text-gray-500">Dikembangkan untuk PKL UMK</span>
        </div>
    </footer>

</body>

</html>
