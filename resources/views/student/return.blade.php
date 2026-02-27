@extends('layouts.student')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-white mb-2">Pengembalian Raport</h1>
            <p class="text-gray-400">Konfirmasi pengembalian raport yang sedang dipinjam.</p>
        </div>

        <!-- Tabs -->
        <div class="flex justify-center mb-8">
            <div class="bg-dark-800 p-1 rounded-xl inline-flex shadow-inner">
                <button onclick="switchTab('self')" id="tab-self"
                    class="px-6 py-2.5 rounded-lg text-sm font-bold transition-all bg-blue-600 text-white shadow-lg">
                    Diri Sendiri
                </button>
                <button onclick="switchTab('representative')" id="tab-representative"
                    class="px-6 py-2.5 rounded-lg text-sm font-bold text-gray-400 hover:text-white transition-all">
                    Wakilkan Teman
                </button>
            </div>
        </div>

        <!-- Self Return Section -->
        <div id="section-self" class="transition-all duration-300">
            @if ($activeLoan)
                <div class="bg-dark-800 border border-dark-700 rounded-2xl p-8 shadow-xl relative overflow-hidden group">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-3xl -mr-16 -mt-16 transition-all group-hover:bg-blue-500/20">
                    </div>

                    <div class="flex items-start gap-6 relative z-10">
                        <div class="bg-dark-700/50 p-4 rounded-xl border border-dark-600">
                            <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>

                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-white mb-1">Detail Peminjaman</h3>
                            <div class="flex items-center gap-2 mb-6">
                                <span
                                    class="px-2.5 py-0.5 rounded text-xs font-bold bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">
                                    STATUS: DIPINJAM
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-6 mb-6">
                                <div>
                                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Waktu Pinjam</p>
                                    <p class="text-white font-medium">
                                        {{ \Carbon\Carbon::parse($activeLoan->borrowed_at)->translatedFormat('d F Y, H:i') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Kelas</p>
                                    <p class="text-white font-medium">
                                        {{ $activeLoan->class_level }} {{ $activeLoan->major }} {{ $activeLoan->class_letter }}
                                    </p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Alasan</p>
                                    <p class="text-white font-medium italic">"{{ $activeLoan->reason }}"</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('student.return.store') }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-green-900/20 transition-all flex items-center justify-center gap-2 group-hover:scale-[1.02]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Konfirmasi Pengembalian
                        </button>
                    </form>
                </div>
            @else
                <div class="text-center py-12 bg-dark-800 rounded-2xl border border-dark-700 border-dashed">
                    <div class="bg-dark-700 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Tidak Ada Peminjaman</h3>
                    <p class="text-gray-400">Anda tidak sedang meminjam raport saat ini.</p>
                    <a href="{{ route('student.loan.create') }}"
                        class="inline-block mt-4 text-blue-400 hover:text-blue-300 font-medium hover:underline">
                        Buat Peminjaman Baru &rarr;
                    </a>
                </div>
            @endif
        </div>

        <!-- Representative Return Section -->
        <div id="section-representative" class="hidden transition-all duration-300">
            <div class="bg-dark-800 border border-dark-700 rounded-2xl p-8 shadow-xl">
                <h3 class="text-xl font-bold text-white mb-4">Cari Peminjaman Teman</h3>

                <div class="mb-6">
                    <label class="block text-gray-400 text-xs font-bold mb-2 uppercase" for="search_nis">NIS Teman</label>
                    <div class="flex gap-2">
                        <input type="text" id="search_nis"
                            class="flex-1 bg-dark-900 border border-dark-600 rounded-lg py-3 px-4 text-white focus:outline-none focus:border-blue-500 placeholder-gray-600 transition-colors"
                            placeholder="Masukkan NIS..." onkeypress="checkEnter(event)">
                        <button onclick="searchLoan()"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition-colors shadow-lg shadow-blue-900/20">
                            Cari
                        </button>
                    </div>
                    <p id="search_message" class="text-sm mt-2 font-medium"></p>
                </div>

                <!-- Found Loan Card -->
                <div id="found_loan_card" class="hidden bg-dark-900/50 rounded-xl p-6 border border-dark-600">
                    <div class="flex items-start gap-4 mb-6">
                        <div class="bg-blue-500/10 p-3 rounded-lg text-blue-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 id="found_name" class="text-lg font-bold text-white">Nama Siswa</h4>
                            <p id="found_class" class="text-gray-400 text-sm">Kelas</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                        <div>
                            <p class="text-gray-500 font-bold uppercase text-xs mb-1">Waktu Pinjam</p>
                            <p id="found_time" class="text-white">Time</p>
                        </div>
                        <div>
                            <p class="text-gray-500 font-bold uppercase text-xs mb-1">Alasan</p>
                            <p id="found_reason" class="text-white italic">Reason</p>
                        </div>
                    </div>

                    <form action="{{ route('student.return.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="loan_id" id="found_loan_id">
                        <button type="submit"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition-all flex items-center justify-center gap-2 shadow-lg shadow-green-900/20 hover:scale-[1.02]">
                            Kembalikan Raport Ini
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            // Update Buttons
            const btnSelf = document.getElementById('tab-self');
            const btnRep = document.getElementById('tab-representative');

            if (tab === 'self') {
                btnSelf.className = 'px-6 py-2.5 rounded-lg text-sm font-bold transition-all bg-blue-600 text-white shadow-lg';
                btnRep.className = 'px-6 py-2.5 rounded-lg text-sm font-bold text-gray-400 hover:text-white transition-all';
                document.getElementById('section-self').classList.remove('hidden');
                document.getElementById('section-representative').classList.add('hidden');
            } else {
                btnRep.className = 'px-6 py-2.5 rounded-lg text-sm font-bold transition-all bg-blue-600 text-white shadow-lg';
                btnSelf.className = 'px-6 py-2.5 rounded-lg text-sm font-bold text-gray-400 hover:text-white transition-all';
                document.getElementById('section-representative').classList.remove('hidden');
                document.getElementById('section-self').classList.add('hidden');
            }
        }

        function checkEnter(event) {
            if (event.key === "Enter") {
                searchLoan();
            }
        }

        function searchLoan() {
            const nis = document.getElementById('search_nis').value;
            const messageEl = document.getElementById('search_message');
            const cardEl = document.getElementById('found_loan_card');

            if (nis.length < 3) {
                messageEl.textContent = 'Masukkan NIS dengan benar.';
                messageEl.className = 'text-sm mt-2 font-medium text-red-400';
                return;
            }

            messageEl.textContent = 'Mencari...';
            messageEl.className = 'text-sm mt-2 font-medium text-blue-400';
            cardEl.classList.add('hidden');

            fetch(`{{ url('/student/search') }}/${nis}`)
                .then(response => response.json())
                .then(res => {
                    if (res.status === 'success') {
                        if (res.data.active_loan) {
                            // Student found AND has active loan
                            messageEl.textContent = 'Peminjaman ditemukan.';
                            messageEl.className = 'text-sm mt-2 font-medium text-green-400';

                            // Populate card
                            document.getElementById('found_name').textContent = res.data.name;
                            document.getElementById('found_class').textContent = res.data.active_loan.full_class;
                            document.getElementById('found_time').textContent = res.data.active_loan.borrowed_at;
                            document.getElementById('found_reason').textContent = `"${res.data.active_loan.reason}"`;
                            document.getElementById('found_loan_id').value = res.data.active_loan.id;

                            cardEl.classList.remove('hidden');
                        } else {
                            // Student found but NO active loan
                            messageEl.textContent = `Siswa ditemukan (${res.data.name}), namun tidak ada peminjaman aktif.`;
                            messageEl.className = 'text-sm mt-2 font-medium text-yellow-500';
                        }
                    } else {
                        // Student not found
                        messageEl.textContent = 'NIS tidak ditemukan.';
                        messageEl.className = 'text-sm mt-2 font-medium text-red-500';
                    }
                })
                .catch(err => {
                    console.error(err);
                    messageEl.textContent = 'Terjadi kesalahan sistem.';
                    messageEl.className = 'text-sm mt-2 font-medium text-red-500';
                });
        }
    </script>
@endsection