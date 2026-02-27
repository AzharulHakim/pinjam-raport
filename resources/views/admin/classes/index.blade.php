@extends('layouts.admin')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-white">Manajemen Kelas</h1>
        <p class="text-gray-400">Pilih Tingkat Kelas untuk melihat jurusan.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($levels as $level)
            <a href="{{ route('admin.classes.level', $level) }}"
                class="bg-dark-800 border border-dark-700 rounded-xl p-8 hover:bg-dark-700 transition-all group flex flex-col items-center justify-center min-h-[200px] shadow-sm hover:shadow-blue-900/10">
                <div class="text-5xl font-bold text-white mb-2 group-hover:text-blue-400 transition-colors">{{ $level }}</div>
                <div class="text-gray-400 font-medium">Tingkat Kelas</div>
            </a>
        @endforeach
    </div>
@endsection