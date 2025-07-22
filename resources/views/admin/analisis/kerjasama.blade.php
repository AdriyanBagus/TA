<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kerjasama') }}
            </h2>

            {{-- Dropdown Filter Tahun Akademik --}}
            <form method="GET" action="{{ route('kerjasama_admin') }}"
                class="flex flex-col md:flex-row md:items-center gap-2">
                <label for="tahun" class="text-sm font-medium text-gray-700">Tahun Akademik:</label>
                <select name="tahun" id="tahun" onchange="this.form.submit()"
                    class="block w-64 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm text-gray-700 bg-white">
                    @foreach ($tahunList as $tahun)
                        <option value="{{ $tahun->id }}" {{ $tahunTerpilih == $tahun->id ? 'selected' : '' }}>
                            {{ $tahun->tahun }} {{ $tahun->is_active ? '(Aktif)' : '' }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('kerjasama.export.csv') }}" method="GET" class="mb-4">
                <input type="hidden" name="tahun" value="{{ $tahunTerpilih }}">
                <input type="hidden" name="user_id" value="{{ $userTerpilih }}">

                <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg shadow transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M12 12v9m0 0l-3.5-3.5M12 21l3.5-3.5M12 3v9" />
                    </svg>
                    Download CSV
                </button>
            </form>
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                <table id="kerjasamaTable" class="display min-w-full bg-white border border-gray-500">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border">Nama Prodi</th>
                            <th class="px-4 py-2 border">Lembaga Mitra</th>
                            <th class="px-4 py-2 border">Jenis Kerjasama</th>
                            <th class="px-4 py-2 border">Tingkat</th>
                            <th class="px-4 py-2 border">Judul Kerjasama</th>
                            <th class="px-4 py-2 border">Waktu Durasi</th>
                            <th class="px-4 py-2 border">Realisasi Kerjasama</th>
                            <th class="px-4 py-2 border">SPK</th>
                            <th class="px-4 py-2 border">URL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kerjasama as $data)
                            <tr>
                                <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border">{{ $data->nama_user }}</td>
                                <td class="px-4 py-2 border">{{ $data->lembaga_mitra }}</td>
                                <td class="px-4 py-2 border">{{ $data->jenis_kerjasama }}</td>
                                <td class="px-4 py-2 border">{{ $data->tingkat }}</td>
                                <td class="px-4 py-2 border">{{ $data->judul_kerjasama }}</td>
                                <td class="px-4 py-2 border">{{ $data->waktu_durasi }}</td>
                                <td class="px-4 py-2 border">{{ $data->realisasi_kerjasama }}</td>
                                <td class="px-4 py-2 border">{{ $data->spk }}</td>
                                <td class="px-1 py-2 border text-sm">
                                    <a href="{{ $data->url }}" target="_blank"
                                        class="text-blue-500 hover:underline">
                                        Link
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


                @if($kerjasama->isEmpty())
                    <p class="text-center text-gray-500 mt-4">Tidak ada pengguna yang terdaftar.</p>
                @endif
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#kerjasamaTable').DataTable({
                responsive: true,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Selanjutnya"
                    }
                }
            });
        });
    </script>

</x-app-layout>