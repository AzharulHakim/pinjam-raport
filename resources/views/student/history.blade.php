@extends('layouts.student')

@section('content')
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-white">Riwayat Peminjaman</h1>
            <p class="text-gray-400">Daftar semua peminjaman yang pernah Anda lakukan.</p>
        </div>
        <a href="{{ route('student.dashboard') }}"
            class="text-gray-400 hover:text-white flex items-center gap-2 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Kembali ke Dashboard
        </a>
    </div>

    <!-- History Table -->
    <div class="bg-dark-800 border border-dark-700 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-gray-400">
                <thead class="bg-dark-700 text-gray-200 uppercase text-xs font-bold">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">NIS</th>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Kelas</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dark-700">
                    @forelse ($loans as $index => $loan)
                        <tr class="hover:bg-dark-700/50 transition-colors">
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-mono text-sm">{{ $loan->student->nis }}</td>
                            <td class="px-6 py-4 font-medium text-white">{{ $loan->student->name }}</td>
                            <td class="px-6 py-4">{{ $loan->class_level }} {{ $loan->class_letter }}</td>
                            <td class="px-6 py-4 text-sm">
                                <div>{{ $loan->created_at->timezone('Asia/Jakarta')->translatedFormat('d M Y') }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $loan->created_at->timezone('Asia/Jakarta')->format('H:i') }} WIB</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Detail Button -->
                                    <button onclick="showDetail({{ $loan->id }})"
                                        class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg transition-colors"
                                        title="Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>

                                    <!-- Delete Button -->
                                    <form action="{{ route('student.history.destroy', $loan->id) }}" method="POST"
                                        onsubmit="deleteConfirm(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-lg transition-colors"
                                            title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Hidden Data for Modal -->
                        <div id="data-{{ $loan->id }}" class="hidden" data-nis="{{ $loan->student->nis }}"
                            data-name="{{ $loan->student->name }}"
                            data-date="{{ $loan->created_at->timezone('Asia/Jakarta')->translatedFormat('d M Y') }}"
                            data-time="{{ $loan->created_at->timezone('Asia/Jakarta')->format('H:i') }} WIB"
                            data-class="{{ $loan->class_level }} {{ $loan->class_letter }}" data-reason="{{ $loan->reason }}"
                            data-photo="{{ asset('storage/' . $loan->photo_path) }}" @if($loan->representative_id)
                                data-rep-name="{{ $loan->representative->name }}" data-rep-nis="{{ $loan->representative->nis }}"
                            @endif></div>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 mb-4 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <p>Belum ada riwayat peminjaman.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detailModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closeModal()"></div>

            <!-- Modal panel -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-dark-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-dark-700">
                <div class="bg-dark-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-xl leading-6 font-bold text-white mb-4 border-b border-dark-700 pb-2"
                                id="modal-title">
                                Detail Peminjaman
                            </h3>

                            <div class="space-y-4">
                                <div
                                    class="aspect-video w-full bg-dark-900 rounded-lg overflow-hidden border border-dark-700 flex items-center justify-center relative group">
                                    <img id="modal-photo" src="" alt="Bukti Foto" class="object-cover w-full h-full">
                                    <div
                                        class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <a id="modal-photo-link" href="" target="_blank"
                                            class="text-white text-sm font-medium hover:underline">Lihat Full Size</a>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-500 text-xs uppercase font-bold">Nama Siswa</p>
                                        <p class="text-white font-medium" id="modal-name">-</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500 text-xs uppercase font-bold">NIS</p>
                                        <p class="text-white font-medium font-mono" id="modal-nis">-</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500 text-xs uppercase font-bold">Kelas</p>
                                        <p class="text-white font-medium" id="modal-class">-</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500 text-xs uppercase font-bold">Waktu Peminjaman</p>
                                        <p class="text-white font-medium"><span id="modal-date"></span>, <span
                                                id="modal-time"></span></p>
                                    </div>
                                </div>

                                <div>
                                    <p class="text-gray-500 text-xs uppercase font-bold mb-1">Keperluan</p>
                                    <p class="text-gray-300 text-sm bg-dark-900 p-3 rounded-lg border border-dark-700"
                                        id="modal-reason">-</p>
                                </div>

                                <!-- Representative Info Section (Hidden by default) -->
                                <div id="modal-rep-section" class="hidden mt-2 pt-2 border-t border-dark-700">
                                    <p class="text-gray-500 text-xs uppercase font-bold mb-1">Diwakilkan Oleh</p>
                                    <p class="text-white font-medium"><span id="modal-rep-name"></span> (<span
                                            id="modal-rep-nis" class="font-mono text-gray-400"></span>)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-dark-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-dark-700">
                    <button type="button"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm"
                        onclick="closeModal()">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showDetail(id) {
            const dataDiv = document.getElementById(`data-${id}`);

            document.getElementById('modal-nis').textContent = dataDiv.dataset.nis;
            document.getElementById('modal-name').textContent = dataDiv.dataset.name;
            document.getElementById('modal-date').textContent = dataDiv.dataset.date;
            document.getElementById('modal-time').textContent = dataDiv.dataset.time;
            document.getElementById('modal-class').textContent = dataDiv.dataset.class;
            document.getElementById('modal-reason').textContent = dataDiv.dataset.reason;

            const photoUrl = dataDiv.dataset.photo;
            document.getElementById('modal-photo').src = photoUrl;
            document.getElementById('modal-photo-link').href = photoUrl;

            // Handle Representative Data
            const repName = dataDiv.dataset.repName;
            const repSection = document.getElementById('modal-rep-section');
            if (repName) {
                document.getElementById('modal-rep-name').textContent = repName;
                document.getElementById('modal-rep-nis').textContent = dataDiv.dataset.repNis;
                repSection.classList.remove('hidden');
            } else {
                repSection.classList.add('hidden');
            }

            document.getElementById('detailModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        // Close modal on escape key
        document.addEventListener('keydown', function (event) {
            if (event.key === "Escape") {
                closeModal();
            }
        });
    </script>
@endsection