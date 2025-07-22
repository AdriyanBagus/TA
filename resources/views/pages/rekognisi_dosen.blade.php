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
                    {{ __('Rekognisi Dosen') }}
                </h2>
            </div>

            <div class="flex items-center space-x-4 mt-4">
                {{-- Dropdown Filter Tahun Akademik --}}
                <form method="GET" action="{{ route('pages.rekognisi_dosen') }}"
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
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6 pt-3">
                <table id="rekognisiTable" class="min-w-full bg-white border border-gray-500">
                    <thead>
                        <tr>
                            <th class="border border-gray-500 px-2 py-2 text-sm">No</th>
                            <th class="border border-gray-500 px-2 py-2 text-sm">Nama</th>
                            <th class="border border-gray-500 px-2 py-2 text-sm">NIDN</th>
                            <th class="border border-gray-500 px-2 py-2 text-sm">Nama Kegiatan Rekognisi</th>
                            <th class="border border-gray-500 px-2 py-2 text-sm">Tingkat</th>
                            <th class="border border-gray-500 px-2 py-2 text-sm">Bahan Ajar</th>
                            <th class="border border-gray-500 px-2 py-2 text-sm">Tahun Perolehan</th>
                            <th class="border border-gray-500 px-2 py-2 text-sm">Url</th>
                            {{-- <th class="border border-gray-500 px-2 py-2 text-sm">Status</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rekognisi_dosen as $rekognisidosen)
                            <tr>
                                <td class="border border-gray-500 px-2 py-2 text-sm">{{ $loop->iteration }}</td>
                                <td class="border border-gray-500 px-2 py-2 text-sm">{{ $rekognisidosen->nama }}</td>
                                <td class="border border-gray-500 px-2 py-2 text-sm">{{ $rekognisidosen->nidn }}</td>
                                <td class="border border-gray-500 px-2 py-2 text-sm">{{ $rekognisidosen->nama_kegiatan_rekognisi }}</td>
                                <td class="border border-gray-500 px-2 py-2 text-sm">{{ $rekognisidosen->tingkat }}</td>
                                <td class="border border-gray-500 px-2 py-2 text-sm">{{ $rekognisidosen->bahan_ajar }}</td>
                                <td class="border border-gray-500 px-2 py-2 text-sm">{{ $rekognisidosen->tahun_perolehan }}</td>
                                <td class="border border-gray-500 px-2 py-2 text-sm">
                                    <a href="{{ $rekognisidosen->url ?? '#' }}" target="_blank"
                                        class="text-blue-500 hover:underline">
                                        Link
                                    </a>
                                </td>
                                {{-- <td class="text-center border border-gray-500 px-2 py-2 text-sm">
                                    <div class="flex flex-col">
                                        @if ($rekognisidosen->status == 'Diproses')
                                            <form action="{{ route('rekognisi.validasi', $rekognisidosen->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="status" value="Disetujui">
                                                <button type="submit" class="btn btn-success btn-sm mb-1">Setujui</button>
                                            </form>

                                            <button type="button" class="btn btn-danger btn-sm mb-1"
                                                onclick="openTolakModal('{{ $rekognisidosen->id }}')">
                                                Tolak
                                            </button>
                                        @else
                                        {{ $rekognisidosen->status }}
                                    @endif
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Modal Validasi -->
                {{-- <div class="modal fade" id="validasiModal" tabindex="-1" aria-labelledby="validasiModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="" id="validasiForm">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Alasan Penolakan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <input type="hidden" name="status" value="Ditolak">
                                    <input type="hidden" name="id" id="rekognisi_id">

                                    <div class="mb-3">
                                        <label for="catatan">Catatan (Wajib diisi):</label>
                                        <textarea name="catatan" id="catatan" class="form-control" rows="4" required></textarea>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Kirim Penolakan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

    <div class="py-4">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                <h3 class="text-lg font-bold mb-3">Komentar</h3>
                <ul>
                    @if ($komentar->isNotEmpty())
                        @foreach ($komentar as $komentar)
                            <li class="mb-2">
                                <p class="text-sm">Nama: {{ $komentar->user->name }}</p>
                                <p class="text-sm">Komentar: {{ $komentar->komentar }}</p>
                                <p class="text-sm">Ditambahkan pada: {{ $komentar->created_at }}</p>
                                <hr>
                            </li>
                        @endforeach
                    @else
                        <p class="text-center text-gray-500 mt-4">Belum ada komentar.</p>
                    @endif
                </ul>

                <form action="{{ route('pages.komentar') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" hidden name="nama_tabel" value="{{ $tabel }}">
                        <select name="prodi_id" id="">
                            <option value="">Pilih Dosen</option>
                            @foreach ($dosen as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <label for="komentar" class="form-label">Komentar:</label>
                        <textarea class="form-control" id="komentar" name="komentar" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </form>
            </div>

        </div>
    </div>
    <script>
        function openTolakModal(id) {
            const modal = new bootstrap.Modal(document.getElementById('validasiModal'));
            document.getElementById('validasiForm').action = `/rekognisidosen/${id}/validasi`;
            document.getElementById('rekognisi_id').value = id;
            document.getElementById('catatan').value = '';
            modal.show();
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#rekognisiTable').DataTable({
                pageLength: 5,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    zeroRecords: "Data tidak ditemukan",
                    info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                    infoEmpty: "Data kosong",
                    infoFiltered: "(difilter dari _MAX_ total data)"
                }
            });
        });
    </script>
</x-app-layout>
