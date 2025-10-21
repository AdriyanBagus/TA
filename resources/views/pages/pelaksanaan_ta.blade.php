<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-2 md:space-y-0">
            <div class="flex items-center space-x-4">
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center bg-gray-100 hover:bg-gray-200 text-black-700 text-sm px-3 py-1.5 rounded-lg shadow-sm transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali
                </a>

                <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                    {{ __('Pelaksanaa TA') }}
                </h2>
            </div>

            <div class="flex items-center space-x-4 mt-4">
                {{-- Dropdown Filter Tahun Akademik --}}
                <form method="GET" action="{{ route('pages.pelaksanaan_ta') }}"
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

                <div class="flex items-center space-x-4">
                    <a href="{{ route('pages.pelaksanaan_ta.export') }}" class="btn btn-success btn-sm"
                        onclick="return confirm('Apakah Anda yakin ingin mendownload CSV?')">
                        Download CSV
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                <table class="min-w-full bg-white border border-gray-500 border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-2 py-2 text-sm">No</th>
                            <th class="border px-4 py-2 text-sm">Nama</th>
                            <th class="border px-4 py-2 text-sm">NIDN</th>
                            {{-- <th class="border px-4 py-2 text-sm">Bimbingan Mahasiswa PS Sendiri</th> --}}
                            <th class="border px-4 py-2 text-sm">Jumlah Bimbingan PS Sendiri</th>
                            {{-- <th class="border px-4 py-2 text-sm">Bimbingan Mahasiswa PS Lain</th> --}}
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
                                {{-- <td class="border px-4 py-2 text-sm">
                                    @if ($item->bimbingan_mahasiswa_ps_sendiri)
                                        <ul class="list-disc list-inside">
                                            @foreach (explode(',', $item->bimbingan_mahasiswa_ps_sendiri) as $mhs)
                                                <li>{{ trim($mhs) }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td> --}}
                                <td class="border px-4 py-2 text-sm text-center">
                                    {{ $item->rata_rata_jumlah_bimbingan_ps_sendiri }}</td>
                                {{-- <td class="border px-4 py-2 text-sm">
                                    @if ($item->bimbingan_mahasiswa_ps_lain)
                                        <ul class="list-disc list-inside">
                                            @foreach (explode(',', $item->bimbingan_mahasiswa_ps_lain) as $mhs)
                                                <li>{{ trim($mhs) }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td> --}}
                                <td class="border px-4 py-2 text-sm text-center">
                                    {{ $item->rata_rata_jumlah_bimbingan_ps_lain }}</td>
                                <td class="border px-4 py-2 text-sm text-center">
                                    {{ $item->rata_rata_jumlah_bimbingan_seluruh_ps }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="border px-4 py-2 text-center text-gray-500">Data tidak
                                    ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{-- @if ($pelaksanaan_ta->isEmpty())
                    <p class="text-center text-gray-500 mt-4">Data tidak ada.</p>
                @endif --}}
            </div>
        </div>
    </div>

    {{-- Komentar --}}
    <div class="py-4">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                <h3 class="text-lg font-bold mb-3">Komentar</h3>
                <ul>
                    @if ($komentar->isNotEmpty())
                        @foreach ($komentar as $item)
                            <li class="mb-4 p-3 border rounded-md shadow-sm">
                                <div class="flex items-center mb-1">
                                    <div class=" bg-gray-500 rounded-full mr-2" style="width: 40px; height: 40px"></div>
                                    <div>
                                        <p class="font-semibold text-sm">Admin</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $item->created_at->format('d F Y - H:i') }} WIB</p>
                                    </div>
                                </div>
                                <div class="text-sm mt-1 whitespace-pre-line">
                                    {!! nl2br(e($item->komentar)) !!}
                                </div>
                            </li>
                        @endforeach
                    @else
                        <p class="text-center text-gray-500 mt-4">Belum ada komentar.</p>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('exampleModal').addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; // Button yang memicu modal
            const recipient = button.getAttribute('data-whatever'); // Ambil data dari button
            const modalTitle = this.querySelector('.modal-title');
            const modalBodyInput = this.querySelector('.modal-body input');

            modalTitle.textContent = 'Tambah Pelaksanaan TA ';
            // modalBodyInput.value = recipient;
        });
    </script>
    <script>
        $(document).ready(function() {
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
