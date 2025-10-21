<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Beban Kinerja Dosen') }}
            </h2>

            {{-- Dropdown Filter Tahun Akademik --}}
            <form method="GET" action="{{ route('beban_kinerja_dosen') }}"
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

                <label for="prodi_id" class="text-sm font-medium text-gray-700">Nama Prodi:</label>
                <select name="prodi_id" id="prodi_id" onchange="this.form.submit()"
                    class="w-64 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm text-gray-700 bg-white">
                    <option value="">Semua Prodi</option>
                    @foreach($prodi as $item)
                        <option value="{{ $item->id }}" {{ $prodiTerpilih == $item->id ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>

            </form>
        </div>
    </x-slot>


    <div class="py-4">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('beban_kinerja_dosen.export.csv') }}" method="GET" class="mb-4">
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
                <table id="bebanKinerjaTable" class="min-w-full bg-white border border-gray-500 border-collapse">
                    <thead>
                        <tr>
                            <th class="border px-2 py-2 text-sm">No</th>
                            <th class="border px-4 py-2 text-sm">Nama Prodi</th>
                            <th class="border px-4 py-2 text-sm">Nama Dosen</th>
                            <th class="border px-4 py-2 text-sm">NIDN</th>
                            <th class="border px-4 py-2 text-sm">Prodi Sendiri</th>
                            <th class="border px-4 py-2 text-sm">Prodi Lain</th>
                            <th class="border px-4 py-2 text-sm">Prodi Diluar PT</th>
                            <th class="border px-4 py-2 text-sm">Penelitian</th>
                            <th class="border px-4 py-2 text-sm">PKM</th>
                            <th class="border px-4 py-2 text-sm">Penunjang</th>
                            <th class="border px-4 py-2 text-sm">Jumlah SKS</th>
                            <th class="border px-4 py-2 text-sm">Rata-rata SKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($beban_kinerja_dosen as $data)
                            <tr>
                                <td class="border text-sm px-1 py-2">{{ $loop->iteration }}</td>
                                <td class="border text-sm px-4 py-2">{{ $data->nama_prodi }}</td>
                                <td class="border text-sm px-4 py-2">{{ $data->nama }}</td>
                                <td class="border text-sm px-4 py-2">{{ $data->nidn }}</td>
                                <td class="border text-sm px-4 py-2">{{ number_format($data->ps_sendiri, 4) + 0 }}</td>
                                <td class="border text-sm px-4 py-2">{{ number_format($data->ps_lain, 4) + 0 }}</td>
                                <td class="border text-sm px-4 py-2">{{ number_format($data->ps_diluar_pt, 4) + 0 }}</td>
                                <td class="border text-sm px-4 py-2">{{ number_format($data->penelitian, 4) + 0 }}</td>
                                <td class="border text-sm px-4 py-2">{{ number_format($data->pkm, 4) + 0 }}</td>
                                <td class="border text-sm px-4 py-2">{{ number_format($data->penunjang, 4) + 0 }}</td>
                                <td class="border text-sm px-4 py-2">{{ number_format($data->jumlah_sks, 4) + 0 }}</td>
                                <td class="border text-sm px-4 py-2">{{ number_format($data->rata_rata_sks, 4) + 0 }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

                @if ($beban_kinerja_dosen->isEmpty())
                    <p class="text-center text-gray-500 mt-4">Tidak ada pengguna yang terdaftar.</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="py-4">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Komentar</h3>
                <form action="{{ route('admin.komentar') }}" method="POST">
                    @csrf
                    <input type="hidden" name="nama_tabel" value="{{ $tabel }}">

                    <div class="mb-3">
                        <label for="prodi_id" class="form-label">Pilih Prodi:</label>
                        <select class="form-select" id="prodi_id" name="prodi_id" required>
                            <option value="">Pilih Prodi</option>
                            @foreach($prodi as $prodi)
                                <option value="{{ $prodi->id }}">{{ $prodi->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="komentar" class="form-label">Komentar:</label>
                        <textarea class="form-control" id="komentar" name="komentar" rows="3" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Kirim</button>
                </form>
                <ul class="list-group mb-4 py-4">
                    @if($komentar->isNotEmpty())
                        @foreach($komentar as $value)
                            <li class="list-group-item d-flex justify-content-between align-items-start align-items-center">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Prodi: {{ $value->user->name }}</div>
                                    <div>Komentar: {{ $value->komentar }}</div>
                                    <small class="text-muted">Ditambahkan pada: {{ $value->created_at }}</small>
                                </div>
                                <form action="{{ route('admin.komentar.destroy', $value->id) }}" method="POST"
                                    class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger ms-3 delete-btn" title="Hapus Komentar">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>

                            </li>
                        @endforeach
                    @else
                        <li class="list-group-item text-center text-muted">Belum ada komentar.</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function () {
            $('#bebanKinerjaTable').DataTable({
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