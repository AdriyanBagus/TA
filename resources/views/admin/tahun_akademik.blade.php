<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Tahun Akademik') }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-4xl mx-auto">
        {{-- Form Tambah Tahun Akademik --}}
        <div class="bg-white shadow-md rounded-xl p-6 mb-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-6">Tambah Tahun Akademik</h3>

            <form action="{{ route('tahun.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Input Tahun Akademik -->
                    <div>
                        <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1">Tahun Akademik</label>
                        <input type="text" name="tahun" id="tahun" placeholder="Contoh: 2024/2025 Genap" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <!-- Input Tanggal Mulai -->
                    <div>
                        <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                            Mulai</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <!-- Input Tanggal Batas -->
                    <div>
                        <label for="tanggal_batas_pengisian"
                            class="block text-sm font-medium text-gray-700 mb-1">Tanggal Batas</label>
                        <input type="date" name="tanggal_batas_pengisian" id="tanggal_batas_pengisian" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>


                <div class="text-left">
                    <button type="submit"
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-lg shadow transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>


        {{-- Daftar Tahun Akademik --}}
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Daftar Tahun Akademik</h3>

            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2">Tahun</th>
                        <th class="px-4 py-2">Tanggal Mulai</th>
                        <th class="px-4 py-2">Batas Pengisian</th>
                        <th class="px-4 py-2 text-center">Status</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tahunList as $tahun)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $tahun->tahun }}</td>
                            <td class="px-4 py-2">
                                {{ \Carbon\Carbon::parse($tahun->tanggal_mulai)->format('d-m-Y') }}
                            </td>
                            <td class="px-4 py-2">
                                {{ \Carbon\Carbon::parse($tahun->tanggal_batas_pengisian)->format('d-m-Y') }}
                            </td>
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
                                    <form action="{{ route('tahun.setAktif', $tahun->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit"
                                            class="bg-indigo-600 text-white text-sm px-3 py-1 rounded hover:bg-indigo-700 transition">
                                            Set Aktif
                                        </button>
                                    </form>

                                    <form action="{{ route('tahun.destroy', $tahun->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus tahun ini?');"
                                        class="inline-block mt-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 text-white text-sm px-3 py-1 rounded hover:bg-red-700 transition">
                                            Hapus
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