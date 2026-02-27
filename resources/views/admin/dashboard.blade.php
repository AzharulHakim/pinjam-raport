@extends('layouts.admin')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-white">Dashboard Admin</h1>
        <p class="text-gray-400">Ringkasan aktivitas dan statistik sistem.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Stat Card -->
        <div class="bg-dark-800 border border-dark-700 rounded-xl p-6 shadow-sm flex items-center">
            <div class="p-3 mr-4 bg-blue-600/20 text-blue-500 rounded-lg">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-400">Total Siswa</p>
                <p class="text-2xl font-bold text-white">{{ $totalStudents }}</p>
            </div>
        </div>

        <!-- Stat Card: Active Loans -->
        <div class="bg-dark-800 border border-dark-700 rounded-xl p-6 shadow-sm flex items-center">
            <div class="p-3 mr-4 bg-yellow-600/20 text-yellow-500 rounded-lg">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-400">Sedang Dipinjam</p>
                <p class="text-2xl font-bold text-white">{{ $totalActiveLoans }}</p>
            </div>
        </div>
        
        <!-- Add more stats here similar to above if available -->
    </div>

    <!-- Recent Loans Table -->
    <div class="bg-dark-800 border border-dark-700 rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-dark-700 bg-dark-800/50">
            <h3 class="text-lg font-bold text-white">Aktivitas Peminjaman</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-gray-400">
                <thead class="bg-dark-700 text-gray-200 uppercase text-xs font-bold">
                    <tr>
                        <th class="px-6 py-3">Nama Siswa</th>
                        <th class="px-6 py-3">Kelas</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dark-700">
                    @forelse ($todayLoans as $loan)
                        <tr class="hover:bg-dark-700/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-white">{{ $loan->student->name }}</td>
                            <td class="px-6 py-4">{{ $loan->class_level }} {{ $loan->major }} {{ $loan->class_letter }}</td>
                            <td class="px-6 py-4">
                                @if($loan->status == 'borrowed')
                                    <span class="px-2 py-1 text-xs font-bold rounded bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">Dipinjam</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-bold rounded bg-green-500/10 text-green-500 border border-green-500/20">Dikembalikan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($loan->created_at->isToday())
                                    {{ $loan->created_at->timezone('Asia/Jakarta')->format('H:i') }}
                                @else
                                    {{ $loan->created_at->diff(now())->format('%h jam %a hari yang lalu') }}
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                Tidak ada aktivitas peminjaman hari ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection