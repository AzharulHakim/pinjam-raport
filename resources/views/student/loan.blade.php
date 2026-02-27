@extends('layouts.student')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-white">Formulir Peminjaman</h1>
            <p class="text-gray-400">Isi data lengkap untuk mengajukan peminjaman raport.</p>
        </div>

        <form id="loanForm" action="{{ route('student.loan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Step 1: Data Siswa & Alasan -->
            <div id="step1">
                <div class="bg-dark-800 border border-dark-700 rounded-xl p-6 shadow-sm mb-6">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                        <span
                            class="bg-blue-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">1</span>
                        Informasi Peminjaman
                    </h3>

                    <!-- Representative Toggle -->
                    <div class="mb-6 p-4 bg-dark-900/50 rounded-lg border border-dark-700">
                        <label class="block text-gray-400 text-xs font-bold mb-3 uppercase">Peminjaman Untuk</label>
                        <div class="flex space-x-6">
                            <label class="flex items-center cursor-pointer group">
                                <input type="radio" name="is_representative" value="0" checked
                                    class="w-4 h-4 text-blue-600 bg-dark-700 border-gray-600 focus:ring-blue-500 focus:ring-2"
                                    onchange="toggleRepresentative(false)">
                                <span class="ml-2 text-gray-300 group-hover:text-white transition-colors">Diri
                                    Sendiri</span>
                            </label>
                            <label class="flex items-center cursor-pointer group">
                                <input type="radio" name="is_representative" value="1"
                                    class="w-4 h-4 text-blue-600 bg-dark-700 border-gray-600 focus:ring-blue-500 focus:ring-2"
                                    onchange="toggleRepresentative(true)">
                                <span class="ml-2 text-gray-300 group-hover:text-white transition-colors">Orang Lain
                                    (Wakilkan)</span>
                            </label>
                        </div>
                    </div>

                    <!-- User Info (Always Visible) -->
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-500 text-xs font-bold mb-2 uppercase">NIS</label>
                            <input type="text" id="current_user_nis" value="{{ Auth::guard('student')->user()->nis }}"
                                readonly
                                class="w-full bg-dark-700 text-gray-400 py-2.5 px-4 rounded-lg border border-dark-600 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-gray-500 text-xs font-bold mb-2 uppercase">Nama Lengkap</label>
                            <input type="text" value="{{ Auth::guard('student')->user()->name }}" readonly
                                class="w-full bg-dark-700 text-gray-400 py-2.5 px-4 rounded-lg border border-dark-600 cursor-not-allowed">
                        </div>
                    </div>

                    <!-- Borrower Class Info (Always Visible) -->
                    <div id="borrower_class_info" class="mb-6 border-b border-dark-700 pb-6">
                        <h4 class="text-sm font-bold text-gray-300 mb-4 uppercase">Kelas Peminjam</h4>
                        <div class="mb-4">
                            <label class="block text-gray-400 text-xs font-bold mb-2 uppercase"
                                for="borrower_class_level">Tingkat
                                Kelas</label>
                            <select name="borrower_class_level" id="borrower_class_level"
                                class="w-full bg-dark-900 text-white border border-dark-600 rounded-lg py-2.5 px-4 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none appearance-none"
                                required onchange="loadMajors('borrower')">
                                <option value="" class="text-gray-500">Pilih Tingkat</option>
                                @foreach($levels as $lvl)
                                    <option value="{{ $lvl }}">Kelas {{ $lvl }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-400 text-xs font-bold mb-2 uppercase"
                                for="borrower_major">Jurusan</label>
                            <select name="borrower_major" id="borrower_major" disabled
                                class="w-full bg-dark-900 text-white border border-dark-600 rounded-lg py-2.5 px-4 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none appearance-none disabled:opacity-50 disabled:cursor-not-allowed"
                                required onchange="loadClasses('borrower')">
                                <option value="">Pilih Tingkat Terlebih Dahulu</option>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label class="block text-gray-400 text-xs font-bold mb-2 uppercase"
                                for="borrower_class_letter">Kelas
                                (A-C)</label>
                            <select name="borrower_class_letter" id="borrower_class_letter" disabled
                                class="w-full bg-dark-900 text-white border border-dark-600 rounded-lg py-2.5 px-4 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none appearance-none disabled:opacity-50 disabled:cursor-not-allowed"
                                required>
                                <option value="">Pilih Jurusan Terlebih Dahulu</option>
                            </select>
                        </div>
                    </div>

                    <!-- Representative Input (Hidden by default) -->
                    <div id="representative_input" class="mb-6 hidden">
                        <h4 class="text-sm font-bold text-blue-400 mb-4 uppercase">Informasi Siswa Yang Diwakilkan</h4>
                        <div class="mb-4">
                            <label class="block text-gray-400 text-xs font-bold mb-2 uppercase" for="representative_nis">NIS
                                Teman</label>
                            <input type="text" name="representative_nis" id="representative_nis"
                                class="w-full bg-dark-900 text-white border border-dark-600 rounded-lg py-2.5 px-4 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none placeholder-gray-600"
                                placeholder="Masukkan NIS Teman...">
                            <div id="nis_search_result" class="mt-2 text-sm font-medium"></div>
                        </div>

                        <!-- Representative Class Info (Target Student) -->
                        <div id="target_class_info" class="mt-4">
                            <div class="mb-4">
                                <label class="block text-gray-400 text-xs font-bold mb-2 uppercase"
                                    for="target_class_level">Tingkat Kelas Teman</label>
                                <select name="target_class_level" id="target_class_level" disabled
                                    class="w-full bg-dark-900 text-white border border-dark-600 rounded-lg py-2.5 px-4 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none appearance-none disabled:opacity-50 disabled:cursor-not-allowed"
                                    onchange="loadMajors('target')">
                                    <option value="" class="text-gray-500">Pilih Tingkat</option>
                                    @foreach($levels as $lvl)
                                        <option value="{{ $lvl }}">Kelas {{ $lvl }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-400 text-xs font-bold mb-2 uppercase"
                                    for="target_major">Jurusan Teman</label>
                                <select name="target_major" id="target_major" disabled
                                    class="w-full bg-dark-900 text-white border border-dark-600 rounded-lg py-2.5 px-4 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none appearance-none disabled:opacity-50 disabled:cursor-not-allowed"
                                    onchange="loadClasses('target')">
                                    <option value="">Pilih Tingkat Terlebih Dahulu</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-400 text-xs font-bold mb-2 uppercase"
                                    for="target_class_letter">Kelas Teman (A-C)</label>
                                <select name="target_class_letter" id="target_class_letter" disabled
                                    class="w-full bg-dark-900 text-white border border-dark-600 rounded-lg py-2.5 px-4 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none appearance-none disabled:opacity-50 disabled:cursor-not-allowed">
                                    <option value="">Pilih Jurusan Terlebih Dahulu</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="block text-gray-400 text-xs font-bold mb-2 uppercase" for="reason">Alasan
                            Peminjaman</label>
                        <textarea name="reason" id="reason" rows="3"
                            class="w-full bg-dark-900 text-white border border-dark-600 rounded-lg py-2.5 px-4 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none placeholder-gray-600"
                            required placeholder="Contoh: Mengurus adminitrasi beasiswa..."></textarea>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <a href="{{ route('student.dashboard') }}"
                        class="text-gray-400 hover:text-white text-sm font-medium transition-colors">Batal</a>
                    <button type="button" onclick="nextStep()"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-8 rounded-lg shadow-lg shadow-blue-900/20 transition-all transform hover:translate-x-1 flex items-center gap-2">
                        Lanjut
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Step 2: Bukti Foto -->
            <div id="step2" class="hidden">
                <div class="bg-dark-800 border border-dark-700 rounded-xl p-6 shadow-sm mb-6">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                        <span
                            class="bg-blue-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">2</span>
                        Bukti Dokumentasi
                    </h3>

                    <div class="mb-6">
                        <label class="block text-gray-400 text-xs font-bold mb-3 uppercase" for="photo">Ambil Foto Selfie
                            dengan Raport</label>

                        <div
                            class="flex flex-col items-center justify-center w-full bg-dark-900/50 rounded-xl border-2 border-dashed border-dark-600 p-4">
                            <!-- Video Element -->
                            <div
                                class="relative w-full max-w-sm aspect-[3/4] bg-black rounded-lg overflow-hidden shadow-lg mb-4">
                                <video id="camera-stream" autoplay playsinline class="w-full h-full object-cover"></video>
                                <canvas id="photo-canvas" class="hidden"></canvas>
                                <img id="photo-preview" class="hidden w-full h-full object-cover absolute top-0 left-0"
                                    alt="Hasil Foto">
                            </div>

                            <!-- Controls -->
                            <div class="flex gap-4">
                                <button type="button" id="start-camera"
                                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded-lg flex items-center gap-2 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Buka Kamera
                                </button>
                                <button type="button" id="capture-photo" disabled
                                    class="bg-green-600 hover:bg-green-700 text-white text-sm font-bold py-2 px-4 rounded-lg flex items-center gap-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Ambil Foto
                                </button>
                                <button type="button" id="retake-photo"
                                    class="hidden bg-gray-600 hover:bg-gray-700 text-white text-sm font-bold py-2 px-4 rounded-lg flex items-center gap-2 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                        </path>
                                    </svg>
                                    Ulangi
                                </button>
                            </div>

                            <input type="hidden" name="photo_base64" id="photo_base64" required>
                            <p id="camera-error" class="text-red-500 text-xs mt-2 hidden"></p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <button type="button" onclick="prevStep()"
                        class="text-gray-400 hover:text-white font-medium py-2 px-4 transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                        Kembali
                    </button>
                    <button type="submit" id="submit-loan" disabled
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg shadow-blue-900/20 transition-all transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                        Ajukan Peminjaman
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Camera Logic
        const video = document.getElementById('camera-stream');
        const canvas = document.getElementById('photo-canvas');
        const photoPreview = document.getElementById('photo-preview');
        const startBtn = document.getElementById('start-camera');
        const captureBtn = document.getElementById('capture-photo');
        const retakeBtn = document.getElementById('retake-photo');
        const photoInput = document.getElementById('photo_base64');
        const errorMsg = document.getElementById('camera-error');
        const submitBtn = document.getElementById('submit-loan');
        let stream = null;

        startBtn.addEventListener('click', async () => {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' } });
                video.srcObject = stream;
                video.play();
                startBtn.classList.add('hidden');
                captureBtn.disabled = false;
                captureBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                errorMsg.classList.add('hidden');
            } catch (err) {
                console.error("Error accessing camera: ", err);
                errorMsg.textContent = "Gagal mengakses kamera. Pastikan izin kamera diberikan.";
                errorMsg.classList.remove('hidden');
            }
        });

        captureBtn.addEventListener('click', () => {
            if (!stream) return;

            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            const dataUrl = canvas.toDataURL('image/jpeg');
            photoInput.value = dataUrl;
            photoPreview.src = dataUrl;

            video.classList.add('hidden');
            photoPreview.classList.remove('hidden');

            captureBtn.classList.add('hidden');
            retakeBtn.classList.remove('hidden');
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');

            // Stop stream to save battery/resource
            // stream.getTracks().forEach(track => track.stop());
        });

        retakeBtn.addEventListener('click', () => {
            photoInput.value = '';
            photoPreview.classList.add('hidden');
            video.classList.remove('hidden');
            captureBtn.classList.remove('hidden');
            retakeBtn.classList.add('hidden');
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');

            // Resume stream if stopped (commented out stopping above for smoother retake)
            if (video.srcObject) {
                video.play();
            }
        });

        // Dependent Dropdown Logic
        function loadMajors(type) {
            const level = document.getElementById(type + '_class_level').value;
            const majorSelect = document.getElementById(type + '_major');
            const classSelect = document.getElementById(type + '_class_letter');

            // Reset Major and Class
            majorSelect.innerHTML = '<option value="">Sedang memuat...</option>';
            classSelect.innerHTML = '<option value="">Pilih Jurusan Terlebih Dahulu</option>';
            classSelect.disabled = true;

            if (!level) {
                majorSelect.innerHTML = '<option value="">Pilih Tingkat Terlebih Dahulu</option>';
                majorSelect.disabled = true;
                return;
            }

            majorSelect.disabled = false;

            fetch(`{{ route('student.getMajors') }}?level=${level}`)
                .then(response => response.json())
                .then(data => {
                    let options = '<option value="">Pilih Jurusan</option>';
                    data.forEach(major => {
                        options += `<option value="${major}">${major}</option>`;
                    });
                    majorSelect.innerHTML = options;
                });
        }

        function loadClasses(type) {
            const level = document.getElementById(type + '_class_level').value;
            const major = document.getElementById(type + '_major').value;
            const classSelect = document.getElementById(type + '_class_letter');

            classSelect.innerHTML = '<option value="">Sedang memuat...</option>';

            if (!major) {
                classSelect.innerHTML = '<option value="">Pilih Jurusan Terlebih Dahulu</option>';
                classSelect.disabled = true;
                return;
            }

            classSelect.disabled = false;

            fetch(`{{ route('student.getClasses') }}?level=${level}&major=${encodeURIComponent(major)}`)
                .then(response => response.json())
                .then(data => {
                    let options = '<option value="">Pilih Kelas</option>';
                    data.forEach(letter => {
                        options += `<option value="${letter}">${letter}</option>`;
                    });
                    classSelect.innerHTML = options;
                });
        }

        function nextStep() {
            const isRepresentative = document.querySelector('input[name="is_representative"]:checked').value === '1';

            // Validate Borrower Fields (Always Required)
            const borrowerClass = document.getElementById('borrower_class_level').value;
            const borrowerMajor = document.getElementById('borrower_major').value;
            const borrowerLetter = document.getElementById('borrower_class_letter').value;

            if (!borrowerClass || !borrowerMajor || !borrowerLetter) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Peminjam Belum Lengkap',
                    text: 'Harap lengkapi data kelas peminjam.',
                    background: '#1e1e1e', color: '#fff', confirmButtonColor: '#3b82f6'
                });
                return;
            }

            if (isRepresentative) {
                // Validate Target/Friend Fields
                const targetClass = document.getElementById('target_class_level').value;
                const targetMajor = document.getElementById('target_major').value;
                const targetLetter = document.getElementById('target_class_letter').value;
                const representativeNis = document.getElementById('representative_nis').value;
                const currentUserNis = document.getElementById('current_user_nis').value;

                if (!representativeNis || representativeNis.length < 3) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Teman Belum Lengkap',
                        text: 'Mohon isi NIS siswa yang diwakilkan.',
                        background: '#1e1e1e', color: '#fff', confirmButtonColor: '#3b82f6'
                    });
                    return;
                }

                if (representativeNis === currentUserNis) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Tidak Bisa Mewakilkan Diri Sendiri',
                        text: 'Anda tidak dapat menggunakan opsi "Wakilkan" untuk meminjam atas nama sendiri. Silakan pilih opsi "Diri Sendiri".',
                        background: '#1e1e1e', color: '#fff', confirmButtonColor: '#3b82f6'
                    });
                    return;
                }


                if (!targetClass || !targetMajor || !targetLetter) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Teman Belum Lengkap',
                        text: 'Harap lengkapi data kelas teman yang diwakilkan.',
                        background: '#1e1e1e', color: '#fff', confirmButtonColor: '#3b82f6'
                    });
                    return;
                }
            }

            // Validate Reason
            const reason = document.getElementById('reason').value;
            if (!reason) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Alasan Belum Diisi',
                    text: 'Harap isi alasan peminjaman.',
                    background: '#1e1e1e', color: '#fff', confirmButtonColor: '#3b82f6'
                });
                return;
            }

            document.getElementById('step1').classList.add('hidden');
            document.getElementById('step2').classList.remove('hidden');
        }

        function prevStep() {
            document.getElementById('step2').classList.add('hidden');
            document.getElementById('step1').classList.remove('hidden');
        }



        function toggleRepresentative(isRepresentative) {
            const inputDiv = document.getElementById('representative_input');
            const nisInput = document.getElementById('representative_nis');

            // Target fields IDs
            const targetFields = ['target_class_level', 'target_major', 'target_class_letter'];

            if (isRepresentative) {
                inputDiv.classList.remove('hidden');
                nisInput.required = true;

                // Enable Target fields logic (Borrower fields always enabled)
                // BUT only level should be enabled initially if they were reset.
                // However, we can just enable the level select. The others depend on it.
                // Or better, we respect the current state if they already selected something?
                // Simplest approach: just enable the Level select. If it has value, the others might be valid or disabled.
                // But `disabled` attribute on HTML prevents interaction.

                // Only enable the LEVEL field. The others will be enabled by the loadMajors/loadClasses logic
                document.getElementById('target_class_level').disabled = false;

                // If level is already selected (re-enabling), we might want to check other fields
                if (document.getElementById('target_class_level').value) {
                    document.getElementById('target_major').disabled = false;
                }
                if (document.getElementById('target_major').value) {
                    document.getElementById('target_class_letter').disabled = false;
                }

            } else {
                inputDiv.classList.add('hidden');
                nisInput.required = false;
                nisInput.value = '';
                document.getElementById('nis_search_result').innerHTML = '';

                // Disable all Target fields
                targetFields.forEach(id => document.getElementById(id).disabled = true);
            }
        }

        const nisInput = document.getElementById('representative_nis');
        const resultDiv = document.getElementById('nis_search_result');
        const currentUserNis = document.getElementById('current_user_nis').value;
        let timeout = null;

        nisInput.addEventListener('input', function () {
            clearTimeout(timeout);
            const nis = this.value;

            if (nis.length < 3) {
                resultDiv.innerHTML = '';
                return;
            }

            if (nis === currentUserNis) {
                resultDiv.innerHTML = `<span class="text-red-500 flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg> Tidak bisa mewakilkan diri sendiri</span>`;
                return;
            }

            timeout = setTimeout(() => {
                fetch(`{{ url('/student/search') }}/${nis}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            resultDiv.innerHTML = `<span class="text-green-500 flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Nama: ${data.data.name}</span>`;
                        } else {
                            resultDiv.innerHTML = `<span class="text-red-500 flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> NIS tidak ditemukan</span>`;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        resultDiv.innerHTML = `<span class="text-red-500">(Terjadi kesalahan)</span>`;
                    });
            }, 500); // Debounce 500ms
        });
    </script>
@endsection