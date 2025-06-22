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
                    {{ __('Publikasi Karya Ilmiah') }}
                </h2>
            </div>

            <div class="flex items-center space-x-4 mt-4">
                {{-- Dropdown Filter Tahun Akademik --}}
                <form method="GET" action="{{ route('pages.publikasi_karya_ilmiah') }}"
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
                        <a href="{{ route('pages.publikasi_karya_ilmiah.export') }}" class="btn btn-success btn-sm">
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
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-3">
                <table class="min-w-full bg-white border border-gray-500">
                    <thead>
                        <tr>
                            <th class="px-2 py-2 border text-sm">No</th>
                            <th class="px-4 py-2 border text-sm">Judul Penelitian</th>
                            <th class="px-4 py-2 border text-sm">Judul Publikasi</th>
                            <th class="px-4 py-2 border text-sm">Nama Author</th>
                            <th class="px-4 py-2 border text-sm">Nama Jurnal</th>
                            <th class="px-4 py-2 border text-sm">Jenis</th>
                            <th class="px-4 py-2 border text-sm">Tingkat</th>
                            <th class="px-4 py-2 border text-sm">Url</th>
                            <th class="px-4 py-2 border text-sm">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($publikasi_karya_ilmiah as $publikasi)
                            <tr>
                                <td class="px-2 py-2 border text-sm">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2 border text-sm">{{ $publikasi->judul_penelitian }}</td>
                                <td class="px-3 py-2 border text-sm">{{ $publikasi->judul_publikasi }}</td>
                                <td class="px-4 py-2 border text-sm">{!! nl2br(e($publikasi->nama_author)) !!}</td>
                                <td class="px-4 py-2 border text-sm">{{ $publikasi->nama_jurnal }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $publikasi->jenis }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $publikasi->tingkat }}</td>
                                <td class="px-2 py-2 border text-sm">
                                    <a href="{{ $publikasi->url }}" target="_blank"
                                        class="text-blue-500 hover:underline">
                                        Link
                                    </a>
                                </td>
                                <td class="px-1 py-3 border flex flex-col items-center space-y-2">
                                    <!-- Tombol Edit -->
                                    <button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal{{ $publikasi->id }}">
                                        Edit
                                    </button>

                                    <!-- Tombol Delete -->
                                    <form action="{{ route('pages.publikasi_karya_ilmiah.destroy', $publikasi->id) }}"
                                        method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="exampleModal{{ $publikasi->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Publikasi Karya Ilmiah</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form
                                                action="{{ route('pages.publikasi_karya_ilmiah.update', $publikasi->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" hidden name="id"
                                                    value="{{ $publikasi->id }}">

                                                <div class="mb-3">
                                                    <label for="judul_penelitian" class="form-label">Judul
                                                        Penelitian:</label>
                                                    <textarea class="form-control" id="judul_penelitian" name="judul_penelitian" required>{{ $publikasi->judul_penelitian }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="judul_publikasi" class="form-label">Judul
                                                        Publikasi:</label>
                                                    <textarea class="form-control" id="judul_publikasi" name="judul_publikasi" required>{{ $publikasi->judul_publikasi }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nama_author" class="form-label">Nama Author:</label>
                                                    <textarea class="form-control" id="nama_author" name="nama_author" placeholder="Nama Dosen dan Mahasiswa(jika ada)"
                                                        required>{{ $publikasi->nama_author }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nama_jurnal" class="form-label">Nama Jurnal:</label>
                                                    <input type="text" class="form-control" id="nama_jurnal"
                                                        name="nama_jurnal" value="{{ $publikasi->nama_jurnal }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Jenis</label>
                                                    <select class="form-control" name="jenis">
                                                        <option value="Jurnal"
                                                            {{ $publikasi->jenis == 'Jurnal' ? 'selected' : '' }}>
                                                            Jurnal</option>
                                                        <option value="Prosiding"
                                                            {{ $publikasi->jenis == 'Prosiding' ? 'selected' : '' }}>
                                                            Prosiding</option>
                                                        <option value="Seminar"
                                                            {{ $publikasi->jenis == 'Seminar' ? 'selected' : '' }}>
                                                            Seminar</option>
                                                        <option value="Buku"
                                                            {{ $publikasi->jenis == 'Buku' ? 'selected' : '' }}>
                                                            Buku</option>
                                                        <option value="Book Chapter"
                                                            {{ $publikasi->jenis == 'Book Chapter' ? 'selected' : '' }}>
                                                            Book Chapter</option>
                                                        <option value="Media Massa"
                                                            {{ $publikasi->jenis == 'Media Massa' ? 'selected' : '' }}>
                                                            Media Massa</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Tingkat</label>
                                                    <select class="form-control" name="tingkat">
                                                        <option value="Internasional"
                                                            {{ $publikasi->tingkat == 'Internasional' ? 'selected' : '' }}>
                                                            Internasional</option>
                                                        <option value="Nasional"
                                                            {{ $publikasi->tingkat == 'Nasional' ? 'selected' : '' }}>
                                                            Nasional</option>
                                                        <option value="Lokal"
                                                            {{ $publikasi->tingkat == 'Lokal' ? 'selected' : '' }}>
                                                            Lokal</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="url" class="form-label">Url:</label>
                                                    <textarea class="form-control" id="url" name="url" placeholder="eg: https://drive.google.com/">{{ $publikasi->url }}</textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Edit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>

                {{-- Modal --}}
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Publikasi Karya Ilmiah</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('pages.publikasi_karya_ilmiah.add') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="judul_penelitian" class="form-label">Judul Penelitian:</label>
                                        <textarea class="form-control" id="judul_penelitian" name="judul_penelitian" required>{{ old('judul_penelitian') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="judul_publikasi" class="form-label">Judul Publikasi:</label>
                                        <textarea class="form-control" id="judul_publikasi" name="judul_publikasi" required>{{ old('judul_publikasi') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama_author" class="form-label">Nama Author:</label>
                                        <textarea class="form-control" id="nama_author" name="nama_author" placeholder="Nama Dosen dan Mahasiswa(jika ada)"
                                            required>{{ old('nama_author') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama_jurnal" class="form-label">Nama Jurnal:</label>
                                        <input type="text" class="form-control" id="nama_jurnal"
                                            name="nama_jurnal" value="{{ old('nama_jurnal') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Jenis</label>
                                        <select class="form-control" name="jenis">
                                            <option value="Jurnal" {{ old('jenis') == 'Jurnal' ? 'selected' : '' }}>
                                                Jurnal</option>
                                            <option value="Prosiding"
                                                {{ old('jenis') == 'Prosiding' ? 'selected' : '' }}>
                                                Prosiding</option>
                                            <option value="Seminar" {{ old('jenis') == 'Seminar' ? 'selected' : '' }}>
                                                Seminar</option>
                                            <option value="Buku" {{ old('jenis') == 'Buku' ? 'selected' : '' }}>
                                                Buku</option>
                                            <option value="Book Chapter"
                                                {{ old('jenis') == 'Book Chapter' ? 'selected' : '' }}>
                                                Book Chapter</option>
                                            <option value="Media Massa"
                                                {{ old('jenis') == 'Media Massa' ? 'selected' : '' }}>
                                                Media Massa</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Tingkat</label>
                                        <select class="form-control" name="tingkat">
                                            <option value="Internasional"
                                                {{ old('tingkat') == 'Internasional' ? 'selected' : '' }}>
                                                Internasional</option>
                                            <option value="Nasional"
                                                {{ old('tingkat') == 'Nasional' ? 'selected' : '' }}>
                                                Nasional</option>
                                            <option value="Lokal" {{ old('tingkat') == 'Lokal' ? 'selected' : '' }}>
                                                Lokal</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="url" class="form-label">Url:</label>
                                        <textarea class="form-control" id="url" name="url" placeholder="eg: https://drive.google.com/">{{ old('url') }}</textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End Modal --}}

                @if ($publikasi_karya_ilmiah->isEmpty())
                    <p class="text-center text-gray-500 mt-4">Tidak ada data yang diinput.</p>
                @endif
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
        document.getElementById('exampleModal').addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; // Button yang memicu modal
            const recipient = button.getAttribute('data-whatever'); // Ambil data dari button
            const modalTitle = this.querySelector('.modal-title');
            const modalBodyInput = this.querySelector('.modal-body input');

            modalTitle.textContent = 'Tambah Publikasi Karya Ilmiah ';
            // modalBodyInput.value = recipient;
        });
    </script>
</x-app-layout>
