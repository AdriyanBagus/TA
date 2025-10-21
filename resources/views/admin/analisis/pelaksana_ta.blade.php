<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Pelaksanaan TA') }}
            </h2>

            {{-- Dropdown Filter Tahun Akademik --}}
            <form method="GET" action="{{ route('pelaksana_ta') }}"
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
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('pelaksana_ta.export.csv') }}" method="GET" class="mb-4">
                <input type="hidden" name="tahun" value="{{ $tahunTerpilih }}">


                <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg shadow transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M12 12v9m0 0l-3.5-3.5M12 21l3.5-3.5M12 3v9" />
                    </svg>
                    Download Data
                </button>
            </form>
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                <table class="min-w-full bg-white border border-gray-500 border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-2 py-2 text-sm">No</th>
                            <th class="border px-4 py-2 text-sm">Nama</th>
                            <th class="border px-4 py-2 text-sm">NIDN</th>
                            <th class="border px-4 py-2 text-sm">Jumlah Bimbingan PS Sendiri</th>
                            <th class="border px-4 py-2 text-sm">Jumlah Bimbingan PS Lain</th>
                            <th class="border px-4 py-2 text-sm">Jumlah Bimbingan Seluruh PS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pelaksanaan_ta as $item)
                            <tr>
                                <td class="border px-2 py-2 text-sm text-center">{{ $loop->iteration }}</td>
                                <td class="border px-4 py-2 text-sm">{{ $item->nama }}</td>
                                <td class="border px-4 py-2 text-sm">{{ $item->nidn }}</td>
                                <td class="border px-4 py-2 text-sm text-center">
                                    {{ $item->rata_rata_jumlah_bimbingan_ps_sendiri }}
                                </td>
                                <td class="border px-4 py-2 text-sm text-center">
                                    {{ $item->rata_rata_jumlah_bimbingan_ps_lain }}
                                </td>
                                <td class="border px-4 py-2 text-sm text-center">
                                    {{ $item->rata_rata_jumlah_bimbingan_seluruh_ps }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border px-4 py-2 text-center text-gray-500">
                                    Data tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#pelaksanaanTable').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50, 100],
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    }
                }
            });
        });
    </script>
</x-app-layout>