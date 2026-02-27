@extends('layouts.admin')

@section('content')
    <div class="mb-8">
        <div class="flex items-center gap-2 mb-2">
            <a href="{{ route('admin.classes.index') }}" class="text-gray-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-white">Tingkat {{ $level }}</h1>
        </div>
        <p class="text-gray-400">Pilih Jurusan atau tambahkan jurusan baru.</p>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-500/10 border border-green-500/30 text-green-400 rounded-xl px-5 py-3 text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <!-- Add Major Form -->
    <div class="bg-dark-800 border border-dark-700 rounded-xl p-6 mb-8 shadow-sm">
        <h3 class="text-lg font-bold text-white mb-4">Tambah Jurusan Baru</h3>
        <form action="{{ route('admin.classes.storeMajor', $level) }}" method="POST" class="flex gap-4">
            @csrf
            <input type="text" name="major" placeholder="Nama Jurusan (Contoh: Nautika Kapal Niaga)" required
                class="flex-1 bg-dark-900 border border-dark-700 rounded-lg py-3 px-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg shadow-blue-900/20 transition-all">
                Tambah
            </button>
        </form>
        @error('major')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- Majors Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($majors as $major)
            <div
                class="relative bg-dark-800 border border-dark-700 rounded-xl shadow-sm hover:bg-dark-700 transition-all group flex items-center justify-between">
                {{-- Navigate to major classes --}}
                <a href="{{ route('admin.classes.major', ['level' => $level, 'major' => $major]) }}"
                    class="flex-1 flex items-center justify-between p-6">
                    <div>
                        <h3 class="text-xl font-bold text-white group-hover:text-blue-400 transition-colors">{{ $major }}</h3>
                        <p class="text-gray-500 text-sm">Kelola Kelas</p>
                    </div>
                    <div
                        class="bg-dark-900 p-2 rounded-full text-gray-400 group-hover:text-blue-400 group-hover:bg-blue-500/10 transition-colors mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

                {{-- Delete major button --}}
                <form action="{{ route('admin.classes.destroyMajor', ['level' => $level, 'major' => $major]) }}" method="POST"
                    class="pr-4" onsubmit="return confirm('Hapus jurusan \" {{ $major }}\"? Semua kelas di jurusan ini akan ikut
                    terhapus.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="text-gray-500 hover:text-red-400 transition-colors p-2 rounded-lg hover:bg-red-500/10"
                        title="Hapus Jurusan">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                    </button>
                </form>
            </div>
        @empty
            <div
                class="col-span-full text-center py-12 text-gray-500 bg-dark-800/50 rounded-xl border border-dashed border-dark-700">
                Belum ada jurusan di tingkat ini.
            </div>
        @endforelse
    </div>
@endsection