<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Publikasi Karya Ilmiah') }}
            </h2>

            {{-- Dropdown Filter Tahun Akademik --}}
            <form method="GET" action="{{ route('publikasi_karya_ilmiah') }}"
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

                <label for="user_id" class="text-sm font-medium text-gray-700">Nama Prodi:</label>
                <select name="user_id" id="user_id" onchange="this.form.submit()"
                    class="w-64 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm text-gray-700 bg-white">
                    <option value="">Semua Prodi</option>
                    @foreach($prodi as $item)
                        <option value="{{ $item->id }}" {{ $userTerpilih == $item->id ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
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
                    Download Data
                </button>
            </form>
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table id="publikasiTable" class="min-w-full bg-white border border-gray-500 text-sm"
                        style="table-layout: fixed;">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-2 py-1 border w-12">No</th>
                                <th class="px-2 py-1 border w-32">Nama Dosen</th>
                                <th class="px-2 py-1 border w-48">Judul Penelitian</th>
                                <th class="px-2 py-1 border w-48">Judul Publikasi</th>
                                <th class="px-2 py-1 border w-32">Dosen</th>
                                <th class="px-2 py-1 border w-32">Mahasiswa</th>
                                <th class="px-2 py-1 border w-40">Dipublikasikan</th>
                                <th class="px-2 py-1 border w-32">Penerbit</th>
                                <th class="px-2 py-1 border w-24">Jenis</th>
                                <th class="px-2 py-1 border w-24">Tingkat</th>
                                <th class="px-2 py-1 border w-32">Penyusun</th>
                                <th class="px-2 py-1 border w-24">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($publikasi_karya_ilmiah as $data)
                                @php
                                    $detail = json_decode($data->detail_publikasi, true);
                                    $dipublikasikan = '-';

                                    switch ($data->jenis) {
                                        case 'Jurnal':
                                            $dipublikasikan = $detail['nama_jurnal'] ?? '-';
                                            break;
                                        case 'Seminar':
                                            $dipublikasikan = $detail['nama_konferensi'] ?? ($detail['penyelenggara_seminar'] ?? '-');
                                            break;
                                        case 'Prosiding':
                                            $dipublikasikan = $detail['nama_acara'] ?? '-';
                                            break;
                                        case 'Buku':
                                            $dipublikasikan = $detail['penerbit_buku'] ?? '-';
                                            break;
                                        case 'Book Chapter':
                                            $dipublikasikan = $detail['judul_buku_induk'] ?? '-';
                                            break;
                                        case 'Media Massa':
                                            $dipublikasikan = $detail['nama_media'] ?? '-';
                                            break;
                                        default:
                                            $dipublikasikan = $detail['nama_penerbit'] ?? '-';
                                            break;
                                    }
                                @endphp

                                <tr>
                                    <td class="px-2 py-1 border text-center">{{ $loop->iteration }}</td>
                                    <td class="px-2 py-1 border break-words">{{ $data->nama_user }}</td>
                                    <td class="px-2 py-1 border break-words">{{ $data->judul_penelitian }}</td>
                                    <td class="px-2 py-1 border break-words">{{ $data->judul_publikasi }}</td>
                                    <td class="px-2 py-1 border break-words">{{ $data->nama_author }}</td>
                                    <td class="px-2 py-1 border break-words">{{ $data->mahasiswa ?? '-' }}</td>
                                    <td class="px-2 py-1 border break-words">{{ $dipublikasikan }}</td>
                                    <td class="px-2 py-1 border break-words">{{ $data->penerbit ?? '-' }}</td>
                                    <td class="px-2 py-1 border">{{ $data->jenis }}</td>
                                    <td class="px-2 py-1 border">{{ $data->tingkat }}</td>
                                    <td class="px-2 py-1 border break-words">{{ $data->penyusun ?? '-' }}</td>
                                    <td class="px-2 py-1 border">{{ $data->status ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                @if($publikasi_karya_ilmiah->isEmpty())
                    <p class="text-center text-gray-500 mt-4">Tidak ada data publikasi karya ilmiah.</p>
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
            $('#publikasiTable').DataTable({
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