<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Tahun Akademik') }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-4xl mx-auto">
        {{-- Form Tambah Tahun Akademik --}}
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Tambah Tahun Akademik</h3>
            <form action="{{ route('tahun.store') }}" method="POST" class="flex gap-4 items-center">
                @csrf
                <input type="text" name="tahun" placeholder="Contoh: 2024/2025 Genap" required
                       class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Tambah
                </button>
            </form>
        </div>

        {{-- Daftar Tahun Akademik --}}
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Daftar Tahun Akademik</h3>

            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2">Tahun</th>
                        <th class="px-4 py-2 text-center">Status</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tahunList as $tahun)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $tahun->tahun }}</td>
                            <td class="px-4 py-2 text-center">
                                @if($tahun->is_active)
                                    <span class="inline-block bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-block bg-gray-100 text-gray-800 text-sm px-3 py-1 rounded-full">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-center">
                                @if(!$tahun->is_active)
                                    <form action="{{ route('tahun.setAktif', $tahun->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="bg-indigo-600 text-white text-sm px-3 py-1 rounded hover:bg-indigo-700 transition">
                                            Set Aktif
                                        </button>
                                    </form>
                                @else
                                    <span class="text-sm text-gray-500 italic">Sedang Aktif</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    @if($tahunList->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center py-4 text-gray-500 italic">
                                Belum ada data tahun akademik.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Berhasil ditambahkan',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
    @if (session('success-edit'))
        <script>
            Swal.fire({
                title: 'Berhasil Diaktifkan',
                text: '{{ session('success-edit') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
</x-app-layout>