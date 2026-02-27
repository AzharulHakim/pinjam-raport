@extends('layouts.admin')

@section('content')
    <div class="mb-8">
        <div class="flex items-center gap-2 mb-2">
            <a href="{{ route('admin.classes.level', $level) }}" class="text-gray-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-white">{{ $level }} - {{ $major }}</h1>
        </div>
        <p class="text-gray-400">Kelola daftar kelas.</p>
    </div>

    <!-- Add Class Form -->
    <div class="bg-dark-800 border border-dark-700 rounded-xl p-6 mb-8 shadow-sm">
        <h3 class="text-lg font-bold text-white mb-4">Tambah Kelas Baru</h3>
        <form action="{{ route('admin.classes.storeClass', ['level' => $level, 'major' => $major]) }}" method="POST"
            class="flex gap-4">
            @csrf
            <input type="text" name="class_letter" placeholder="Nama Kelas (Contoh: A, B, C, atau 1, 2)" required
                class="flex-1 bg-dark-900 border border-dark-700 rounded-lg py-3 px-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg shadow-blue-900/20 transition-all">
                Tambah
            </button>
        </form>
        @error('class_letter')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- Classes List -->
    <div class="bg-dark-800 border border-dark-700 rounded-xl overflow-hidden shadow-sm">
        <table class="w-full text-left text-gray-400">
            <thead class="bg-dark-700 text-gray-200 uppercase text-xs font-bold">
                <tr>
                    <th class="px-6 py-4">Nama Kelas</th>

                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-dark-700">
                @php /** @var \Illuminate\Database\Eloquent\Collection<\App\Models\SchoolClass> $classes */ @endphp
                @forelse ($classes as $class)
                    <tr class="hover:bg-dark-700/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-white">
                            {{ $class->level }} {{ $class->major }} {{ $class->class_letter }}
                        </td>

                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.classes.destroy', $class->id) }}" method="POST"
                                onsubmit="return confirm('Hapus kelas ini? Siswa di kelas ini mungkin akan kehilangan data kelas.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-400 hover:text-red-300 hover:underline text-sm font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-12 text-center text-gray-500">
                            Belum ada kelas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection