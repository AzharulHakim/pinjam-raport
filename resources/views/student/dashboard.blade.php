@extends('layouts.student')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-white">Dashboard</h1>
        <p class="text-gray-400">Ringkasan aktivitas peminjaman raport Anda.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Profile Card -->
        <div class="bg-dark-800 border border-dark-700 rounded-xl p-6 shadow-sm">
            <div class="flex items-center space-x-4">
                <div
                    class="h-12 w-12 rounded-lg bg-blue-600/20 flex items-center justify-center text-blue-500 font-bold text-xl">
                    {{ substr($student->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white">{{ $student->name }}</h2>
                    <div class="flex items-center text-sm text-gray-400 mt-1">
                        <span
                            class="bg-dark-700 text-gray-300 px-2 py-0.5 rounded text-xs mr-2 border border-dark-600">NIS</span>
                        {{ $student->nis }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Card -->
        <div class="bg-dark-800 border border-dark-700 rounded-xl p-6 shadow-sm relative overflow-hidden">
            @if ($activeLoan)
                <div class="absolute top-0 right-0 p-3">
                    <span class="flex h-3 w-3 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                    </span>
                </div>
                <h3 class="text-sm font-medium text-gray-400 uppercase tracking-wider mb-2">Status Saat Ini</h3>
                <p class="text-red-400 font-bold text-lg mb-1">Sedang Dipinjam</p>
                <p class="text-sm text-gray-500">{{ $activeLoan->class_level }} {{ $activeLoan->major }}
                    {{ $activeLoan->class_letter }}</p>
                @if ($activeLoan->representative_id)
                    <p class="text-xs text-red-400 mt-2 bg-red-500/10 inline-block px-2 py-1 rounded">Dipinjam oleh:
                        {{ $activeLoan->representative->name }}</p>
                @endif
            @else
                <h3 class="text-sm font-medium text-gray-400 uppercase tracking-wider mb-2">Status Saat Ini</h3>
                <p class="text-green-500 font-bold text-lg mb-1">Aman</p>
                <p class="text-sm text-gray-500">Tidak ada peminjaman aktif</p>
            @endif
        </div>

    </div>

    <!-- Active Loan Full Alert (If Needed for Details) -->
    @if ($activeLoan)
        <div class="mb-8 bg-red-900/20 border border-red-900/50 rounded-xl p-6">
            <div class="flex items-start gap-4">
                <div class="p-3 bg-red-900/30 rounded-lg text-red-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-red-400">Peminjaman Aktif</h3>
                    <p class="text-gray-400 mt-1">Anda masih memiliki peminjaman raport yang belum selesai.</p>
                    <div class="mt-3 text-sm text-gray-500">
                        <p><span class="text-gray-400">Alasan:</span> "{{ $activeLoan->reason }}"</p>
                        <p class="mt-1"><span class="text-gray-400">Waktu:</span>
                            {{ $activeLoan->borrowed_at->timezone('Asia/Jakarta')->translatedFormat('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Action Buttons -->
    <h3 class="text-lg font-bold text-white mb-4">Menu Utama</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Loan Button -->
        <a href="{{ route('student.loan.create') }}"
            class="group block bg-dark-800 border border-dark-700 hover:border-blue-600 rounded-xl p-6 transition-all hover:bg-dark-700 relative overflow-hidden">
            <div
                class="absolute right-0 top-0 p-6 opacity-10 group-hover:opacity-20 transition group-hover:scale-110 transform">
                <svg class="w-24 h-24 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-blue-600/20 text-blue-500 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <h4 class="text-xl font-bold text-white mb-1">Pinjam Raport</h4>
                <p class="text-sm text-gray-400">Isi formulir untuk mengajukan peminjaman baru.</p>
            </div>
        </a>

        <!-- Return Button -->
        <a href="{{ route('student.loan.return_page') }}"
            class="group block bg-dark-800 border border-dark-700 hover:border-green-600 rounded-xl p-6 transition-all hover:bg-dark-700 relative overflow-hidden">
            <div
                class="absolute right-0 top-0 p-6 opacity-10 group-hover:opacity-20 transition group-hover:scale-110 transform">
                <svg class="w-24 h-24 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-green-600/20 text-green-500 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h4 class="text-xl font-bold text-white mb-1">Kembalikan Raport</h4>
                <p class="text-sm text-gray-400">Konfirmasi pengembalian raport yang dipinjam.</p>
            </div>
        </a>

    </div>
@endsection