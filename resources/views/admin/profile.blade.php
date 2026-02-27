@extends('layouts.admin')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-white">Profil Admin</h1>
        <p class="text-gray-400">Kelola akun dan keamanan admin.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- ===== GANTI PASSWORD SENDIRI ===== --}}
        <div class="bg-dark-800 border border-dark-700 rounded-xl p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-6 border-b border-dark-700 pb-4">
                <div class="w-9 h-9 rounded-lg bg-blue-600/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Ganti Password Saya</h3>
                    <p class="text-gray-500 text-xs">Akun: {{ Auth::user()->name }} ({{ Auth::user()->email }})</p>
                </div>
            </div>

            <form action="{{ route('admin.profile.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-400 text-xs font-bold uppercase mb-2" for="current_password">
                        Password Saat Ini
                    </label>
                    <input type="password" id="current_password" name="current_password"
                        class="w-full bg-dark-900 border @error('current_password') border-red-500 @else border-dark-700 @enderror rounded-lg py-3 px-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                        placeholder="Masukkan password saat ini">
                    @error('current_password')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-400 text-xs font-bold uppercase mb-2" for="new_password">
                        Password Baru
                    </label>
                    <input type="password" id="new_password" name="new_password"
                        class="w-full bg-dark-900 border @error('new_password') border-red-500 @else border-dark-700 @enderror rounded-lg py-3 px-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                        placeholder="Minimal 6 karakter">
                    @error('new_password')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-400 text-xs font-bold uppercase mb-2" for="new_password_confirmation">
                        Konfirmasi Password Baru
                    </label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                        class="w-full bg-dark-900 border border-dark-700 rounded-lg py-3 px-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                        placeholder="Ulangi password baru">
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg shadow-blue-900/20 transition-all">
                    Simpan Password Baru
                </button>
            </form>
        </div>

        {{-- ===== TAMBAH ADMIN BARU ===== --}}
        <div class="bg-dark-800 border border-dark-700 rounded-xl p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-6 border-b border-dark-700 pb-4">
                <div class="w-9 h-9 rounded-lg bg-green-600/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Tambah Admin Baru</h3>
                    <p class="text-gray-500 text-xs">Buat akun admin tambahan</p>
                </div>
            </div>

            <form action="{{ route('admin.profile.admins.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-400 text-xs font-bold uppercase mb-2" for="admin_name">Nama</label>
                    <input type="text" id="admin_name" name="name" value="{{ old('name') }}"
                        class="w-full bg-dark-900 border @error('name') border-red-500 @else border-dark-700 @enderror rounded-lg py-3 px-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 transition-all"
                        placeholder="Nama Admin">
                    @error('name')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-400 text-xs font-bold uppercase mb-2" for="admin_username">Username</label>
                    <input type="text" id="admin_username" name="username" value="{{ old('username') }}"
                        class="w-full bg-dark-900 border @error('username') border-red-500 @else border-dark-700 @enderror rounded-lg py-3 px-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 transition-all"
                        placeholder="username_admin">
                    @error('username')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-400 text-xs font-bold uppercase mb-2"
                        for="admin_password">Password</label>
                    <input type="password" id="admin_password" name="password"
                        class="w-full bg-dark-900 border @error('password') border-red-500 @else border-dark-700 @enderror rounded-lg py-3 px-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 transition-all"
                        placeholder="Minimal 6 karakter">
                    @error('password')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-400 text-xs font-bold uppercase mb-2"
                        for="admin_password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="admin_password_confirmation" name="password_confirmation"
                        class="w-full bg-dark-900 border border-dark-700 rounded-lg py-3 px-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 transition-all"
                        placeholder="Ulangi password">
                </div>

                <button type="submit"
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg shadow-green-900/20 transition-all">
                    Tambah Admin
                </button>
            </form>
        </div>
    </div>

    {{-- ===== DAFTAR ADMIN LAIN ===== --}}
    <div class="mt-8 bg-dark-800 border border-dark-700 rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-dark-700 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-yellow-600/20 flex items-center justify-center">
                <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z">
                    </path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-white">Daftar Admin Lain</h3>
                <p class="text-gray-500 text-xs">Reset password atau hapus akun admin lain</p>
            </div>
        </div>

        @if ($admins->isEmpty())
            <div class="px-6 py-12 text-center text-gray-500">
                Belum ada admin lain. Tambahkan menggunakan form di atas.
            </div>
        @else
            <table class="w-full text-left text-gray-400">
                <thead class="bg-dark-700 text-gray-200 uppercase text-xs font-bold">
                    <tr>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Username</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dark-700">
                    @foreach ($admins as $admin)
                        <tr class="hover:bg-dark-700/50 transition-colors" id="admin-row-{{ $admin->id }}">
                            <td class="px-6 py-4 font-semibold text-white">{{ $admin->name }}</td>
                            <td class="px-6 py-4">{{ $admin->email }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Reset Password Button --}}
                                    <button type="button"
                                        onclick="openResetModal({{ $admin->id }}, '{{ addslashes($admin->name) }}')"
                                        class="text-xs bg-yellow-600/20 hover:bg-yellow-600/40 text-yellow-400 font-semibold px-3 py-1.5 rounded-lg transition-all">
                                        Reset Password
                                    </button>

                                    {{-- Delete Admin --}}
                                    <form action="{{ route('admin.profile.admins.destroy', $admin->id) }}"
                                        method="POST"
                                        onsubmit="deleteConfirm(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-xs bg-red-600/20 hover:bg-red-600/40 text-red-400 font-semibold px-3 py-1.5 rounded-lg transition-all">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- ===== MODAL RESET PASSWORD ADMIN LAIN ===== --}}
    <div id="resetModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" onclick="closeResetModal()"></div>

            <div
                class="relative bg-dark-800 rounded-2xl border border-dark-700 shadow-xl w-full max-w-md p-6 z-10 transform transition-all">

                <h3 class="text-xl font-bold text-white mb-1">Reset Password Admin</h3>
                <p id="resetModalSubtitle" class="text-gray-500 text-sm mb-6"></p>

                <form id="resetForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-400 text-xs font-bold uppercase mb-2">Password Baru</label>
                        <input type="password" name="new_password" id="reset_new_password"
                            class="w-full bg-dark-900 border border-dark-700 rounded-lg py-3 px-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition-all"
                            placeholder="Minimal 6 karakter" required minlength="6">
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-400 text-xs font-bold uppercase mb-2">Konfirmasi Password
                            Baru</label>
                        <input type="password" name="new_password_confirmation" id="reset_confirm_password"
                            class="w-full bg-dark-900 border border-dark-700 rounded-lg py-3 px-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition-all"
                            placeholder="Ulangi password" required>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeResetModal()"
                            class="px-4 py-2 bg-dark-700 hover:bg-dark-600 text-white rounded-lg transition-colors">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-bold rounded-lg transition-colors shadow-lg shadow-yellow-900/20">
                            Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openResetModal(adminId, adminName) {
            const baseUrl = "{{ url('admin/profile/admins') }}";
            document.getElementById('resetForm').action = `${baseUrl}/${adminId}/reset-password`;
            document.getElementById('resetModalSubtitle').textContent = `Atur password baru untuk: ${adminName}`;
            document.getElementById('reset_new_password').value = '';
            document.getElementById('reset_confirm_password').value = '';
            document.getElementById('resetModal').classList.remove('hidden');
        }

        function closeResetModal() {
            document.getElementById('resetModal').classList.add('hidden');
        }
    </script>
@endsection
