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

                @if($tahunTerpilih && $tahunList->where('id', $tahunTerpilih)->first()->is_active)
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('pages.rekognisi_tenaga_kependidikan.export') }}" class="btn btn-success btn-sm">
                            Download CSV
                        </a>

                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
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
                <table class="min-w-full bg-white border border-gray-500">
                    <thead>
                        <tr>
                            <th class="px-2 py-2 border text-sm">No</th>
                            <th class="px-4 py-2 border text-sm">Nama</th>
                            <th class="px-4 py-2 border text-sm">Nama Kegiatan Rekognisi</th>
                            <th class="px-4 py-2 border text-sm">Tingkat</th>
                            <th class="px-4 py-2 border text-sm">Bahan Ajar</th>
                            <th class="px-4 py-2 border text-sm">Tahun Perolehan</th>
                            <th class="px-4 py-2 border text-sm">Url</th>
                            <th class="px-4 py-2 border text-sm">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rekognisi_tenaga_kependidikan as $rekognisitenagapendidik)
                            <tr>
                                <td class="px-1 py-2 border text-sm">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $rekognisitenagapendidik->nama }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $rekognisitenagapendidik->nama_kegiatan_rekognisi }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $rekognisitenagapendidik->tingkat }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $rekognisitenagapendidik->bahan_ajar }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $rekognisitenagapendidik->tahun_perolehan }}</td>
                                <td class="px-1 py-2 border text-sm">
                                    <a href="{{ $rekognisitenagapendidik->url }}" target="_blank"
                                        class="text-blue-500 hover:underline">
                                        Link
                                    </a>
                                </td>
                                <td class="px-1 py-3 border flex flex-col items-center space-y-2 text-sm">
                                    <!-- Tombol Edit -->
                                    <button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal{{ $rekognisitenagapendidik->id }}">
                                        Edit
                                    </button>

                                    <!-- Tombol Delete -->
                                    <form action="{{ route('pages.rekognisi_tenaga_kependidikan.destroy', $rekognisitenagapendidik->id) }}"
                                        method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                                </td>
                            </tr>

                            <div class="modal fade" id="exampleModal{{ $rekognisitenagapendidik->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Rekognisi Tenaga Kependidikan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('pages.rekognisi_tenaga_kependidikan.update', $rekognisitenagapendidik->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" hidden name="id"
                                                    value="{{ $rekognisitenagapendidik->id }}">

                                                <div class="mb-3">
                                                    <label for="nama" class="form-label">Nama:</label>
                                                    <input type="text" class="form-control" id="nama"
                                                        name="nama" value="{{ $rekognisitenagapendidik->nama }}"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nama_kegiatan_rekognisi" class="form-label">Nama Kegiatan Rekognisi:</label>
                                                    <textarea class="form-control" id="nama_kegiatan_rekognisi" name="nama_kegiatan_rekognisi">{{ $rekognisitenagapendidik->nama_kegiatan_rekognisi }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label>Tingkat</label>
                                                    <select class="form-control" name="tingkat">
                                                        <option value="Internasional"
                                                            {{ $rekognisitenagapendidik->tingkat == 'Internasional' ? 'selected' : '' }}>
                                                            Internasional</option>
                                                        <option value="Nasional"
                                                            {{ $rekognisitenagapendidik->tingkat == 'Nasional' ? 'selected' : '' }}>
                                                            Nasional</option>
                                                        <option value="Lokal"
                                                            {{ $rekognisitenagapendidik->tingkat == 'Lokal' ? 'selected' : '' }}>
                                                            Lokal</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Bahan Ajar</label>
                                                    <select class="form-control" name="bahan_ajar">
                                                        <option value="PPT"
                                                            {{ $rekognisitenagapendidik->bahan_ajar == 'PPT' ? 'selected' : '' }}>
                                                            PPT</option>
                                                        <option value="Modul Praktikum"
                                                            {{ $rekognisitenagapendidik->bahan_ajar == 'Modul Praktikum' ? 'selected' : '' }}>
                                                            Modul Praktikum</option>
                                                        <option value="Monograf"
                                                            {{ $rekognisitenagapendidik->bahan_ajar == 'Monograf' ? 'selected' : '' }}>
                                                            Monograf</option>
                                                        <option value="Diktat"
                                                            {{ $rekognisitenagapendidik->bahan_ajar == 'Diktat' ? 'selected' : '' }}>
                                                            Diktat</option>
                                                        <option value="Buku Ajar"
                                                            {{ $rekognisitenagapendidik->bahan_ajar == 'Buku Ajar' ? 'selected' : '' }}>
                                                            Buku Ajar</option>
                                                        <option value="Modul Pembelajaran"
                                                            {{ $rekognisitenagapendidik->bahan_ajar == 'Modul Pembelajaran' ? 'selected' : '' }}>
                                                            Modul Pembelajaran</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tahun_perolehan" class="form-label">Tahun Perolehan:</label>
                                                    <input type="text" class="form-control" id="tahun_perolehan"
                                                        name="tahun_perolehan" value="{{ $rekognisitenagapendidik->tahun_perolehan }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="url" class="form-label">Url:</label>
                                                    <textarea class="form-control" id="url" name="url">{{ $rekognisitenagapendidik->url }}</textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Update</button>
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
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Rekognisi Tenaga Kependidikan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('pages.rekognisi_tenaga_kependidikan.add') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama:</label>
                                        <input type="text" class="form-control" id="nama"
                                            name="nama" value="{{ old('nama') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama_kegiatan_rekognisi" class="form-label">Nama Kegiatan Rekognisi:</label>
                                        <textarea class="form-control" id="nama_kegiatan_rekognisi" name="nama_kegiatan_rekognisi">{{ old('nama_kegiatan_rekognisi') }}</textarea>
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
                                            <option value="Lokal"
                                                {{ old('tingkat') == 'Lokal' ? 'selected' : '' }}>
                                                Lokal</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Bahan Ajar</label>
                                        <select class="form-control" name="bahan_ajar">
                                            <option value="PPT"
                                                {{ old('bahan_ajar') == 'PPT' ? 'selected' : '' }}>
                                                PPT</option>
                                            <option value="Modul Praktikum"
                                                {{ old('bahan_ajar') == 'Modul Praktikum' ? 'selected' : '' }}>
                                                Modul Praktikum</option>
                                            <option value="Monograf"
                                                {{ old('bahan_ajar') == 'Monograf' ? 'selected' : '' }}>
                                                Monograf</option>
                                            <option value="Diktat"
                                                {{ old('bahan_ajar') == 'Diktat' ? 'selected' : '' }}>
                                                Diktat</option>
                                            <option value="Buku Ajar"
                                                {{ old('bahan_ajar') == 'Buku Ajar' ? 'selected' : '' }}>
                                                Buku Ajar</option>
                                            <option value="Modul Pembelajaran"
                                                {{ old('bahan_ajar') == 'Modul Pembelajaran' ? 'selected' : '' }}>
                                                Modul Pembelajaran</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tahun_perolehan" class="form-label">Tahun Perolehan:</label>
                                        <input type="text" class="form-control" id="tahun_perolehan"
                                            name="tahun_perolehan" value="{{ old('tahun_perolehan') }}">
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

                @if ($rekognisi_tenaga_kependidikan->isEmpty())
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

            modalTitle.textContent = 'Tambah Rekognisi Tenaga Kependidikan ';
            // modalBodyInput.value = recipient;
        });
    </script>
</x-app-layout>
