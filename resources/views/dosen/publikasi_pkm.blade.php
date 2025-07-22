<x-app-layout>
    {{-- Menambahkan 'tongkat sihir' (Alpine.js) di awal --}}
    <script src="//unpkg.com/alpinejs" defer></script>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-2 md:space-y-0">
            <div class="flex items-center space-x-4">
                <a href="{{ route('dosen.dashboard') }}"
                    class="inline-flex items-center bg-gray-100 hover:bg-gray-200 text-black-700 text-sm px-3 py-1.5 rounded-lg shadow-sm transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali
                </a>
                <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                    {{ __('Publikasi PKM') }}
                </h2>
            </div>

            <div class="flex items-center space-x-4 mt-4">
                <form method="GET" action="{{ route('dosen.publikasi_pkm') }}"
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
                    <a href="{{ route('dosen.publikasi_pkm.export') }}" class="btn btn-success btn-sm"
                        onclick="return confirm('Apakah Anda yakin ingin mendownload CSV?')">
                        Download CSV
                    </a>
                    @if ($tahunTerpilih && $tahunList->where('id', $tahunTerpilih)->first()->is_active)
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#tambahPublikasiModal">
                            Tambah
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-3">
                <table class="min-w-full bg-white border border-gray-500">
                    <thead>
                        <tr>
                            <th class="px-2 py-2 border text-sm">No</th>
                            <th class="px-4 py-2 border text-sm">Judul PKM</th>
                            <th class="px-4 py-2 border text-sm">Judul Publikasi</th>
                            <th class="px-4 py-2 border text-sm">Nama Author</th>
                            <th class="px-4 py-2 border text-sm">Jenis</th>
                            <th class="px-4 py-2 border text-sm">Tingkat</th>
                            <th class="px-4 py-2 border text-sm">Detail Publikasi</th>
                            <th class="px-4 py-2 border text-sm">URL</th>
                            <th class="px-4 py-2 border text-sm text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($publikasi_pkm as $publikasi)
                            <tr>
                                <td class="px-2 py-2 border text-sm">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2 border text-sm">{{ $publikasi->judul_pkm }}</td>
                                <td class="px-3 py-2 border text-sm">{{ $publikasi->judul_publikasi }}</td>
                                <td class="px-4 py-2 border text-sm">{!! nl2br(e($publikasi->nama_author)) !!}</td>
                                <td class="px-4 py-2 border text-sm">{{ $publikasi->jenis }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $publikasi->tingkat }}</td>
                                <td class="px-4 py-2 border text-sm">
                                    @if (!empty($publikasi->detail_publikasi))
                                        @foreach ($publikasi->detail_publikasi as $key => $value)
                                            @if (!empty($value))
                                                <div class="text-xs">
                                                    {{-- Gemi's Fix: Menambahkan aturan khusus untuk ISBN --}}
                                                    @if ($key === 'isbn')
                                                        <strong class="uppercase">{{ $key }}:</strong>
                                                        {{ $value }}
                                                    @else
                                                        <strong
                                                            class="capitalize">{{ str_replace('_', ' ', $key) }}:</strong>
                                                        {{ $value }}
                                                    @endif
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-2 py-2 border text-sm">
                                    @if ($publikasi->url)
                                        <a href="{{ $publikasi->url }}" target="_blank"
                                            class="text-blue-500 hover:underline">Link</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-1 py-3 border flex flex-col items-center space-y-2">
                                    <button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $publikasi->id }}">Edit</button>
                                    <form action="{{ route('dosen.publikasi_pkm.destroy', $publikasi->id) }}"
                                        method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">Tidak ada data yang diinput.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- == MODAL EDIT DENGAN STRUKTUR YANG SUDAH DIPERBAIKI == -->
    @foreach ($publikasi_pkm as $publikasi)
        <div class="modal fade" id="editModal{{ $publikasi->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" x-data="{ jenis: '{{ $publikasi->jenis }}' }">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Publikasi PKM</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('dosen.publikasi_pkm.update', $publikasi->id) }}"
                            method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Inputan yang selalu ada --}}
                            <div class="mb-3"><label class="form-label">Judul Penelitian:</label>
                                <textarea class="form-control" name="judul_pkm" required>{{ $publikasi->judul_pkm }}</textarea>
                            </div>
                            <div class="mb-3"><label class="form-label">Judul Publikasi:</label>
                                <textarea class="form-control" name="judul_publikasi" required>{{ $publikasi->judul_publikasi }}</textarea>
                            </div>
                            <div class="mb-3"><label class="form-label">Nama Author:</label>
                                <textarea class="form-control" name="nama_author" required>{{ $publikasi->nama_author ?? '' }}</textarea>
                            </div>

                            {{-- Dropdown Jenis yang memicu 'sihir' --}}
                            <div class="form-group mb-3">
                                <label>Jenis</label>
                                <select class="form-control" name="jenis" x-model="jenis" required>
                                    <option value="Jurnal">Jurnal</option>
                                    <option value="Buku">Buku</option>
                                    <option value="Prosiding">Prosiding</option>
                                    <option value="Seminar">Seminar</option>
                                    <option value="Book Chapter">Book Chapter</option>
                                    <option value="Media Massa">Media Massa</option>
                                </select>
                            </div>

                            {{-- Kumpulan Inputan Ajaib --}}
                            <div x-show="jenis === 'Jurnal'">
                                <div class="mb-3"><label class="form-label">Nama Jurnal:</label><input
                                        type="text" class="form-control" name="detail[nama_jurnal]"
                                        value="{{ $publikasi->detail_publikasi['nama_jurnal'] ?? '' }}"></div>
                                <div class="mb-3"><label class="form-label">Volume/Nomor Jurnal:</label><input
                                        type="text" class="form-control" name="detail[volume_nomor_jurnal]"
                                        value="{{ $publikasi->detail_publikasi['volume_nomor_jurnal'] ?? '' }}"></div>
                                <div class="mb-3"><label class="form-label">Link/DOI Jurnal:</label><input
                                        type="text" class="form-control" name="detail[link_doi_jurnal]"
                                        value="{{ $publikasi->detail_publikasi['link_doi_jurnal'] ?? '' }}"></div>
                            </div>
                            <div x-show="jenis === 'Buku'">
                                <div class="mb-3"><label class="form-label">Nama Penerbit:</label><input
                                        type="text" class="form-control" name="detail[nama_penerbit]"
                                        value="{{ $publikasi->detail_publikasi['nama_penerbit'] ?? '' }}"></div>
                                <div class="mb-3"><label class="form-label">Tahun Terbit:</label><input
                                        type="text" class="form-control" name="detail[tahun_terbit]"
                                        value="{{ $publikasi->detail_publikasi['tahun_terbit'] ?? '' }}"></div>
                                <div class="mb-3"><label class="form-label">ISBN:</label><input type="text"
                                        class="form-control" name="detail[isbn]"
                                        value="{{ $publikasi->detail_publikasi['isbn'] ?? '' }}"></div>
                            </div>
                            <div x-show="jenis === 'Prosiding'">
                                <div class="mb-3"><label class="form-label">Nama Konferensi/Seminar:</label><input
                                        type="text" class="form-control" name="detail[nama_konferensi]"
                                        value="{{ $publikasi->detail_publikasi['nama_konferensi'] ?? '' }}"></div>
                                <div class="mb-3"><label class="form-label">Penyelenggara:</label><input
                                        type="text" class="form-control" name="detail[penyelenggara]"
                                        value="{{ $publikasi->detail_publikasi['penyelenggara'] ?? '' }}"></div>
                                <div class="mb-3"><label class="form-label">Tanggal Pelaksanaan:</label><input
                                        type="date" class="form-control" name="detail[tanggal_pelaksanaan]"
                                        value="{{ $publikasi->detail_publikasi['tanggal_pelaksanaan'] ?? '' }}"></div>
                            </div>
                            <div x-show="jenis === 'Seminar'">
                                <div class="mb-3"><label class="form-label">Nama Acara:</label><input
                                        type="text" class="form-control" name="detail[nama_acara]"
                                        value="{{ $publikasi->detail_publikasi['nama_acara'] ?? '' }}"></div>
                                <div class="mb-3"><label class="form-label">Peran:</label><input type="text"
                                        class="form-control" name="detail[peran]"
                                        value="{{ $publikasi->detail_publikasi['peran'] ?? '' }}"></div>
                                <div class="mb-3"><label class="form-label">Penyelenggara:</label><input
                                        type="text" class="form-control" name="detail[penyelenggara_seminar]"
                                        value="{{ $publikasi->detail_publikasi['penyelenggara_seminar'] ?? '' }}">
                                </div>
                            </div>
                            <div x-show="jenis === 'Book Chapter'">
                                <div class="mb-3"><label class="form-label">Judul Buku Induk:</label><input
                                        type="text" class="form-control" name="detail[judul_buku_induk]"
                                        value="{{ $publikasi->detail_publikasi['judul_buku_induk'] ?? '' }}"></div>
                                <div class="mb-3"><label class="form-label">Nama Editor:</label><input
                                        type="text" class="form-control" name="detail[nama_editor]"
                                        value="{{ $publikasi->detail_publikasi['nama_editor'] ?? '' }}"></div>
                                <div class="mb-3"><label class="form-label">Nama Penerbit:</label><input
                                        type="text" class="form-control" name="detail[penerbit_buku]"
                                        value="{{ $publikasi->detail_publikasi['penerbit_buku'] ?? '' }}"></div>
                            </div>
                            <div x-show="jenis === 'Media Massa'">
                                <div class="mb-3"><label class="form-label">Nama Media:</label><input
                                        type="text" class="form-control" name="detail[nama_media]"
                                        value="{{ $publikasi->detail_publikasi['nama_media'] ?? '' }}"></div>
                                <div class="mb-3"><label class="form-label">Tanggal Tayang:</label><input
                                        type="date" class="form-control" name="detail[tanggal_tayang]"
                                        value="{{ $publikasi->detail_publikasi['tanggal_tayang'] ?? '' }}"></div>
                                <div class="mb-3"><label class="form-label">Link Berita:</label><input
                                        type="text" class="form-control" name="detail[link_berita]"
                                        value="{{ $publikasi->detail_publikasi['link_berita'] ?? '' }}"></div>
                            </div>

                            <div class="form-group mb-3"><label>Tingkat</label><select class="form-control"
                                    name="tingkat">
                                    <option value="Internasional"
                                        {{ $publikasi->tingkat == 'Internasional' ? 'selected' : '' }}>Internasional
                                    </option>
                                    <option value="Nasional"
                                        {{ $publikasi->tingkat == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                    <option value="Lokal" {{ $publikasi->tingkat == 'Lokal' ? 'selected' : '' }}>
                                        Lokal</option>
                                </select></div>
                            <div class="mb-3"><label class="form-label">URL Dokumen Pendukung:</label>
                                <textarea class="form-control" name="url" placeholder="https://drive.google.com/">{{ $publikasi->url }}</textarea>
                            </div>

                            <div class="modal-footer"><button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button><button type="submit"
                                    class="btn btn-primary">Edit</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- == MODAL TAMBAH DENGAN SIHIR BARU == -->
    <div class="modal fade" id="tambahPublikasiModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Publikasi PKM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('dosen.publikasi_pkm.add') }}" method="POST"
                        x-data="{ jenis: '' }">
                        @csrf

                        <div class="mb-3"><label class="form-label">Judul Penelitian:</label>
                            <textarea class="form-control" name="judul_pkm" required>{{ old('judul_pkm') }}</textarea>
                        </div>
                        <div class="mb-3"><label class="form-label">Judul Publikasi:</label>
                            <textarea class="form-control" name="judul_publikasi" required>{{ old('judul_publikasi') }}</textarea>
                        </div>
                        <div class="mb-3"><label class="form-label">Nama Author:</label>
                            <textarea class="form-control" name="nama_author" placeholder="Nama Dosen dan Mahasiswa (jika ada)" required>{{ old('nama_author') }}</textarea>
                        </div>

                        <div class="form-group mb-3"><label>Jenis</label><select class="form-control" name="jenis"
                                x-model="jenis" required>
                                <option value="" disabled selected>-- Pilih Jenis Publikasi --</option>
                                <option value="Jurnal">Jurnal</option>
                                <option value="Buku">Buku</option>
                                <option value="Prosiding">Prosiding</option>
                                <option value="Seminar">Seminar</option>
                                <option value="Book Chapter">Book Chapter</option>
                                <option value="Media Massa">Media Massa</option>
                            </select></div>

                        <div x-show="jenis === 'Jurnal'">
                            <div class="mb-3"><label class="form-label">Nama Jurnal:</label><input type="text"
                                    class="form-control" name="detail[nama_jurnal]"
                                    value="{{ old('detail.nama_jurnal') }}"></div>
                            <div class="mb-3"><label class="form-label">Volume/Nomor Jurnal:</label><input
                                    type="text" class="form-control" name="detail[volume_nomor_jurnal]"
                                    value="{{ old('detail.volume_nomor_jurnal') }}"></div>
                            <div class="mb-3"><label class="form-label">Link/DOI Jurnal:</label><input
                                    type="text" class="form-control" name="detail[link_doi_jurnal]"
                                    value="{{ old('detail.link_doi_jurnal') }}"></div>
                        </div>
                        <div x-show="jenis === 'Buku'">
                            <div class="mb-3"><label class="form-label">Nama Penerbit:</label><input type="text"
                                    class="form-control" name="detail[nama_penerbit]"
                                    value="{{ old('detail.nama_penerbit') }}"></div>
                            <div class="mb-3"><label class="form-label">Tahun Terbit:</label><input type="text"
                                    class="form-control" name="detail[tahun_terbit]"
                                    value="{{ old('detail.tahun_terbit') }}"></div>
                            <div class="mb-3"><label class="form-label">ISBN:</label><input type="text"
                                    class="form-control" name="detail[isbn]" value="{{ old('detail.isbn') }}"></div>
                        </div>
                        <div x-show="jenis === 'Prosiding'">
                            <div class="mb-3"><label class="form-label">Nama Konferensi/Seminar:</label><input
                                    type="text" class="form-control" name="detail[nama_konferensi]"
                                    value="{{ old('detail.nama_konferensi') }}"></div>
                            <div class="mb-3"><label class="form-label">Penyelenggara:</label><input type="text"
                                    class="form-control" name="detail[penyelenggara]"
                                    value="{{ old('detail.penyelenggara') }}"></div>
                            <div class="mb-3"><label class="form-label">Tanggal Pelaksanaan:</label><input
                                    type="date" class="form-control" name="detail[tanggal_pelaksanaan]"
                                    value="{{ old('detail.tanggal_pelaksanaan') }}"></div>
                        </div>
                        <div x-show="jenis === 'Seminar'">
                            <div class="mb-3"><label class="form-label">Nama Acara:</label><input type="text"
                                    class="form-control" name="detail[nama_acara]"
                                    value="{{ old('detail.nama_acara') }}"></div>
                            <div class="mb-3"><label class="form-label">Peran:</label><input type="text"
                                    class="form-control" name="detail[peran]" value="{{ old('detail.peran') }}">
                            </div>
                            <div class="mb-3"><label class="form-label">Penyelenggara:</label><input type="text"
                                    class="form-control" name="detail[penyelenggara_seminar]"
                                    value="{{ old('detail.penyelenggara_seminar') }}"></div>
                        </div>
                        <div x-show="jenis === 'Book Chapter'">
                            <div class="mb-3"><label class="form-label">Judul Buku Induk:</label><input
                                    type="text" class="form-control" name="detail[judul_buku_induk]"
                                    value="{{ old('detail.judul_buku_induk') }}"></div>
                            <div class="mb-3"><label class="form-label">Nama Editor:</label><input type="text"
                                    class="form-control" name="detail[nama_editor]"
                                    value="{{ old('detail.nama_editor') }}"></div>
                            <div class="mb-3"><label class="form-label">Nama Penerbit:</label><input type="text"
                                    class="form-control" name="detail[penerbit_buku]"
                                    value="{{ old('detail.penerbit_buku') }}"></div>
                        </div>
                        <div x-show="jenis === 'Media Massa'">
                            <div class="mb-3"><label class="form-label">Nama Media:</label><input type="text"
                                    class="form-control" name="detail[nama_media]"
                                    value="{{ old('detail.nama_media') }}"></div>
                            <div class="mb-3"><label class="form-label">Tanggal Tayang:</label><input
                                    type="date" class="form-control" name="detail[tanggal_tayang]"
                                    value="{{ old('detail.tanggal_tayang') }}"></div>
                            <div class="mb-3"><label class="form-label">Link Berita:</label><input type="text"
                                    class="form-control" name="detail[link_berita]"
                                    value="{{ old('detail.link_berita') }}"></div>
                        </div>

                        <div class="form-group mb-3"><label>Tingkat</label><select class="form-control"
                                name="tingkat">
                                <option value="Internasional">Internasional</option>
                                <option value="Nasional">Nasional</option>
                                <option value="Lokal">Lokal</option>
                            </select></div>
                        <div class="mb-3"><label class="form-label">URL Dokumen Pendukung:</label>
                            <textarea class="form-control" name="url" placeholder="https://drive.google.com/">{{ old('url') }}</textarea>
                        </div>

                        <div class="modal-footer"><button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Close</button><button type="submit"
                                class="btn btn-primary">Tambah</button></div>
                    </form>
                </div>
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
                                <div class="text-sm mt-1 whitespace-pre-line">{!! nl2br(e($item->komentar)) !!}</div>
                            </li>
                        @endforeach
                    @else
                        <p class="text-center text-gray-500 mt-4">Belum ada komentar.</p>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
