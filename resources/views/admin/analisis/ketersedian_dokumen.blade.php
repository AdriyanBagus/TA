<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Ketersediaan Dokumen') }}
            </h2>

            {{-- Dropdown Filter Tahun Akademik --}}
            <form method="GET" action="{{ route('ketersediaan_dokumen') }}"
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
                <table id="dokumenTable" class="display min-w-full bg-white border border-gray-500">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border">Nama Prodi</th>
                            <th class="px-4 py-2 border">dokumen</th>
                            <th class="px-4 py-2 border">Nomor Dokumen</th>
                            <th class="px-1 py-2 border text-sm">Link Dokumen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ketersediaan_dokumen as $data)
                            <tr>
                                <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border">{{ $data->nama_user }}</td>
                                <td class="px-4 py-2 border">{{ $data->dokumen }}</td>
                                <td class="px-4 py-2 border">{{ $data->nomor_dokumen }}</td>
                                <td class="px-1 py-2 border text-sm">
                                    <a href="{{ $data->url }}" target="_blank" class="text-blue-500 hover:underline">
                                        Link
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


                @if($ketersediaan_dokumen->isEmpty())
                    <p class="text-center text-gray-500 mt-4">Tidak ada pengguna yang terdaftar.</p>
                @endif
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#dokumenTable').DataTable({
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
                    { orderable: false, targets: 0 } // Kolom "No" tidak bisa di-sort
                ]
            });
        });
    </script>

</x-app-layout>