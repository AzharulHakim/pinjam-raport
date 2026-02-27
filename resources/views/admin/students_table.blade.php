<table class="w-full text-left text-gray-400">
    <thead class="bg-dark-700 text-gray-200 uppercase text-xs font-bold">
        <tr>
            <th class="px-6 py-4">No</th>
            <th class="px-6 py-4">NIS</th>
            <th class="px-6 py-4">Nama</th>
            <th class="px-6 py-4 text-center">Aksi</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-dark-700">
        @forelse ($students as $index => $student)
            <tr class="hover:bg-dark-700/50 transition-colors">
                <td class="px-6 py-4 font-mono text-sm text-gray-400">
                    {{ $students->firstItem() + $index }}
                </td>
                <td class="px-6 py-4 font-mono text-sm text-gray-400">
                    {{ $student->nis }}
                </td>
                <td class="px-6 py-4">
                    <div class="font-medium text-white">{{ $student->name }}</div>
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="flex items-center justify-center gap-2">
                        <!-- Edit Button -->
                        <button
                            onclick="openEditModal({{ $student->id }}, '{{ $student->nis }}', '{{ addslashes($student->name) }}')"
                            class="text-blue-400 hover:text-blue-300 bg-blue-500/10 hover:bg-blue-500/20 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors border border-blue-500/20">
                            Edit
                        </button>

                        <!-- Delete Button -->
                        <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST"
                            onsubmit="deleteConfirm(event)" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-red-400 hover:text-red-300 bg-red-500/10 hover:bg-red-500/20 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors border border-red-500/20">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                    <div class="flex flex-col items-center justify-center">
                        <svg class="w-12 h-12 mb-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        <p>Belum ada data siswa.</p>
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

@if ($students->hasPages())
    <div class="px-6 py-4 border-t border-dark-700 bg-dark-800">
        {{ $students->links() }}
    </div>
@endif