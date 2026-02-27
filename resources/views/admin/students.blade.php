@extends('layouts.admin')

@section('content')
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-white">Manajemen Siswa</h1>
            <p class="text-gray-400">Kelola data siswa di sini.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar: Add & Import -->
        <div class="lg:col-span-1 space-y-8">
            <!-- Add Student Form -->
            <div class="bg-dark-800 border border-dark-700 rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-bold text-white mb-6 border-b border-dark-700 pb-4">Tambah Siswa Baru</h3>

                <form action="{{ route('admin.students') }}" method="POST">
                    @csrf

                    <div class="mb-5">
                        <label class="block text-gray-400 text-xs font-bold uppercase mb-2" for="nis">NIS</label>
                        <input
                            class="w-full bg-dark-900 border border-dark-700 rounded-lg py-3 px-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            id="nis" type="text" name="nis" required placeholder="Nomor Induk Siswa">
                    </div>

                    <div class="mb-5">
                        <label class="block text-gray-400 text-xs font-bold uppercase mb-2" for="name">Nama Lengkap</label>
                        <input
                            class="w-full bg-dark-900 border border-dark-700 rounded-lg py-3 px-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            id="name" type="text" name="name" required placeholder="Nama Siswa">
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg shadow-blue-900/20 transition-all transform hover:translate-y-[-1px]">
                        Simpan Data
                    </button>
                </form>
            </div>

            <!-- Import Student Form -->
            <div class="bg-dark-800 border border-dark-700 rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-bold text-white mb-6 border-b border-dark-700 pb-4">Import Siswa (Excel)</h3>

                <form action="{{ route('admin.students.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-5">
                        <label class="block text-gray-400 text-xs font-bold uppercase mb-2" for="file">File Excel (.xlsx,
                            .xls)</label>
                        <input
                            class="w-full bg-dark-900 border border-dark-700 rounded-lg py-2 px-4 text-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-600 file:text-white hover:file:bg-green-700 transition-all"
                            id="file" type="file" name="file" required accept=".xlsx, .xls">
                        <p class="text-gray-500 text-xs mt-2">Format: Kolom A (NIS), Kolom B (Nama)</p>
                    </div>

                    <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg shadow-green-900/20 transition-all transform hover:translate-y-[-1px]">
                        Import Data
                    </button>
                </form>
            </div>

            <!-- Hapus Massal Siswa -->
            <div class="bg-dark-800 border border-red-900/40 rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-bold text-white mb-1 border-b border-dark-700 pb-4">Hapus Massal Siswa</h3>
                <p class="text-gray-500 text-xs mb-5">Hapus semua siswa berdasarkan rentang NIS.</p>

                @if (session('success'))
                    <div class="mb-4 bg-green-500/10 border border-green-500/30 text-green-400 rounded-lg px-4 py-2 text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->has('nis_from') || $errors->has('nis_to'))
                    <div class="mb-4 bg-red-500/10 border border-red-500/30 text-red-400 rounded-lg px-4 py-2 text-sm">
                        {{ $errors->first('nis_from') }}{{ $errors->first('nis_to') }}
                    </div>
                @endif

                <form action="{{ route('admin.students.bulk_destroy') }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus semua siswa dengan NIS ' + document.getElementById('nis_from').value + ' s/d ' + document.getElementById('nis_to').value + '? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')

                    <div class="mb-4">
                        <label class="block text-gray-400 text-xs font-bold uppercase mb-2" for="nis_from">NIS Awal</label>
                        <input type="text" id="nis_from" name="nis_from" value="{{ old('nis_from') }}"
                            placeholder="Contoh: 10001"
                            class="w-full bg-dark-900 border border-dark-700 rounded-lg py-3 px-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all">
                    </div>

                    <div class="mb-5">
                        <label class="block text-gray-400 text-xs font-bold uppercase mb-2" for="nis_to">NIS Akhir</label>
                        <input type="text" id="nis_to" name="nis_to" value="{{ old('nis_to') }}" placeholder="Contoh: 10050"
                            class="w-full bg-dark-900 border border-dark-700 rounded-lg py-3 px-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all">
                    </div>

                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg shadow-red-900/20 transition-all transform hover:translate-y-[-1px] flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                        Hapus Siswa
                    </button>
                </form>
            </div>

        </div>

        <!-- Daftar Siswa -->
        <div class="lg:col-span-2 space-y-4">
            <!-- Checkbox Search -->
            <div class="bg-dark-800 border border-dark-700 rounded-xl p-4 shadow-sm">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" id="searchInput"
                        class="block w-full pl-10 pr-3 py-2 border border-dark-700 rounded-lg leading-5 bg-dark-900 text-gray-300 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out"
                        placeholder="Cari berdasarkan NIS atau Nama..." autofocus>
                </div>
            </div>

            <div id="studentsTableContainer"
                class="bg-dark-800 border border-dark-700 rounded-xl shadow-sm overflow-hidden">
                @include('admin.students_table')
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closeEditModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-dark-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-dark-700">
                <form id="editForm" action="" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <h3 class="text-xl font-bold text-white mb-6 border-b border-dark-700 pb-2">Edit Siswa</h3>

                    <div class="mb-5">
                        <label class="block text-gray-400 text-xs font-bold uppercase mb-2" for="edit_nis">NIS</label>
                        <input
                            class="w-full bg-dark-900 border border-dark-700 rounded-lg py-3 px-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            id="edit_nis" type="text" name="nis" required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-400 text-xs font-bold uppercase mb-2" for="edit_name">Nama
                            Lengkap</label>
                        <input
                            class="w-full bg-dark-900 border border-dark-700 rounded-lg py-3 px-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            id="edit_name" type="text" name="name" required>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeEditModal()"
                            class="px-4 py-2 bg-dark-700 hover:bg-dark-600 text-white rounded-lg transition-colors">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors shadow-lg shadow-blue-900/20">Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Live Search Logic
        const searchInput = document.getElementById('searchInput');
        const tableContainer = document.getElementById('studentsTableContainer');
        let timeout = null;

        searchInput.addEventListener('keyup', function () {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                const query = this.value;
                fetch(`{{ route('admin.students') }}?search=${query}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.text())
                    .then(html => {
                        tableContainer.innerHTML = html;
                    });
            }, 300); // 300ms debounce
        });

        function openEditModal(id, nis, name) {
            const form = document.getElementById('editForm');
            form.action = `/admin/students/${id}`;

            document.getElementById('edit_nis').value = nis;
            document.getElementById('edit_name').value = name;

            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
@endsection