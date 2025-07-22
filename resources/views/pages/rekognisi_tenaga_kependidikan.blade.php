<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-2 md:space-y-0">
            <div class="flex items-center space-x-4">
                <a href="javascript:history.back()"
                    class="inline-flex items-center bg-gray-100 hover:bg-gray-200 text-black-700 text-sm px-3 py-1.5 rounded-lg shadow-sm transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali
                </a>

                <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                    {{ __('Rekognisi Tenaga Kependidikan') }}
                </h2>
            </div>

            <div class="flex items-center space-x-4 mt-4">
                {{-- Dropdown Filter Tahun Akademik --}}
                <form method="GET" action="{{ route('pages.rekognisi_tenaga_kependidikan') }}"
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

                @if ($tahunTerpilih && $tahunList->where('id', $tahunTerpilih)->first()->is_active)
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('pages.rekognisi_tenaga_kependidikan.export') }}"
                            class="btn btn-success btn-sm">
                            Download CSV
                        </a>

                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Tambah
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                <table id="rekognisiTable" class="min-w-full bg-white border border-gray-500">
                    <thead>
                        <tr>
                        <tr>
                            <th class="px-2 py-2 border text-sm">No</th>
                            <th class="px-4 py-2 border text-sm">Nama</th>
                            <th class="px-4 py-2 border text-sm">Nama Kegiatan Rekognisi</th>
                            <th class="px-4 py-2 border text-sm">Tingkat</th>
                            <th class="px-4 py-2 border text-sm">Bahan Ajar</th>
                            <th class="px-4 py-2 border text-sm">Tahun Perolehan</th>
                            <th class="px-4 py-2 border text-sm">Url</th>
                            <th class="px-4 py-2 border text-sm">Action</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rekognisi_tenaga_kependidikan as $rekognisitenagapendidik)
                            <tr>
                                <td class="px-2 py-2 border text-sm">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $rekognisitenagapendidik->nama }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $rekognisitenagapendidik->nama_kegiatan_rekognisi }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $rekognisitenagapendidik->tingkat }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $rekognisitenagapendidik->bahan_ajar }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $rekognisitenagapendidik->tahun_perolehan }}</td>
                                <td class="px-4 py-2 border text-sm">
                                    <a href="{{ $rekognisitenagapendidik->url }}" target="_blank"
                                        class="text-blue-500 hover:underline">
                                        Link
                                    </a>
                                </td>
                                <td class="px-4 py-2 border text-sm">
                                    @if ($rekognisitenagapendidik->status == 'Diproses')
                                        <form
                                            action="{{ route('rekognisi_tenaga_kependidikan.validasi', $rekognisitenagapendidik->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="status" value="Disetujui">
                                            <button type="submit" class="btn btn-success btn-sm mb-1">Setujui</button>
                                        </form>
                                        <button type="button" class="btn btn-danger btn-sm mb-1"
                                            onclick="openTolakModal('{{ $rekognisitenagapendidik->id }}')">
                                            Tolak
                                        </button>
                                    @else
                                        {{ $rekognisitenagapendidik->status }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

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
                                    <div class=" bg-gray-500 rounded-full mr-2" style="width: 40px; height: 40px">
                                    </div>
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
        function openTolakModal(id) {
            const modal = new bootstrap.Modal(document.getElementById('validasiModal'));
            document.getElementById('validasiForm').action = `/rekognisitendik/${id}/validasi`;
            document.getElementById('rekognisi_id').value = id;
            document.getElementById('catatan').value = '';
            modal.show();
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#rekognisiTable').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50, 100],
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    paginate: {
                        next: "→",
                        previous: "←"
                    },
                    zeroRecords: "Data tidak ditemukan",
                },
                columnDefs: [{
                        orderable: false,
                        targets: 7
                    } // Nonaktifkan sorting kolom Action
                ]
            });
        });
    </script>
</x-app-layout>
