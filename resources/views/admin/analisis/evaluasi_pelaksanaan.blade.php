<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Evaluasi Pelaksanaan') }}
            </h2>

            {{-- Dropdown Filter Tahun Akademik --}}
            <form method="GET" action="{{ route('evaluasi_pelaksanaan') }}"
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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                <table id="evaluasiTable" class="display min-w-full bg-white border border-gray-500">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border">Nama Prodi</th>
                            <th class="px-4 py-2 border">Nomor PTK</th>
                            <th class="px-4 py-2 border">Kategori PTK</th>
                            <th class="px-4 py-2 border">Rencana Penyelesaian</th>
                            <th class="px-4 py-2 border">Realisasi Perbaikan</th>
                            <th class="px-4 py-2 border">Penanggung Jawab</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($evaluasi_pelaksanaan as $data)
                            <tr>
                                <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border">{{ $data->nama_user }}</td>
                                <td class="px-4 py-2 border">{{ $data->nomor_ptk }}</td>
                                <td class="px-4 py-2 border">{{ $data->kategori_ptk }}</td>
                                <td class="px-4 py-2 border">{{ $data->rencana_penyelesaian }}</td>
                                <td class="px-4 py-2 border">{{ $data->realisasi_perbaikan }}</td>
                                <td class="px-4 py-2 border">{{ $data->penanggungjawab_perbaikan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($evaluasi_pelaksanaan->isEmpty())
                    <p class="text-center text-gray-500 mt-4">Tidak ada pengguna yang terdaftar.</p>
                @endif
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#evaluasiTable').DataTable({
                responsive: true,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Selanjutnya"
                    }
                },
                columnDefs: [
                    { orderable: false, targets: 0 } // Kolom "No" tidak bisa diurutkan
                ]
            });
        });
    </script>

</x-app-layout>