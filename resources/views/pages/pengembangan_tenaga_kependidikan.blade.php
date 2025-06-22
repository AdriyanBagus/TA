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
                    {{ __('Pengembangan Tenaga Kependidikan') }}
                </h2>
            </div>

            <div class="flex items-center space-x-4 mt-4">
                {{-- Dropdown Filter Tahun Akademik --}}
                <form method="GET" action="{{ route('pages.pengembangan_tenaga_kependidikan') }}"
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
                    <a href="{{ route('pages.pengembangan_tenaga_kependidikan.export') }}" class="btn btn-success btn-sm" onclick="return confirm('Apakah Anda yakin ingin mendownload CSV?')">
                        Download CSV
                    </a>

                    @if($tahunTerpilih && $tahunList->where('id', $tahunTerpilih)->first()->is_active)
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Tambah
                        </button>
                    @endif
                </div>
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
                            <th class="px-4 py-2 border text-sm">NIPY</th>
                            <th class="px-4 py-2 border text-sm">Nama Kegiatan</th>
                            <th class="px-4 py-2 border text-sm">Waktu Pelaksanaan</th>
                            <th class="px-4 py-2 border text-sm">Jenis Kegiatan</th>
                            <th class="px-4 py-2 border text-sm">Url</th>
                            <th class="px-4 py-2 border text-sm">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengembangan_tenaga_kependidikan as $pengembangantendik)
                            <tr>
                                <td class="px-1 py-2 border text-sm">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $pengembangantendik->nama }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $pengembangantendik->nipy }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $pengembangantendik->nama_kegiatan }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $pengembangantendik->waktu_pelaksanaan }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $pengembangantendik->jenis_kegiatan }}</td>
                                <td class="px-1 py-2 border text-sm">
                                    <a href="{{ $pengembangantendik->url }}" target="_blank"
                                        class="text-blue-500 hover:underline">
                                        Link
                                    </a>
                                </td>
                                <td class="px-1 py-3 border flex flex-col items-center space-y-2 text-sm">
                                    <!-- Tombol Edit -->
                                    <button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal{{ $pengembangantendik->id }}">
                                        Edit
                                    </button>

                                    <!-- Tombol Delete -->
                                    <form action="{{ route('pages.pengembangan_tenaga_kependidikan.destroy', $pengembangantendik->id) }}"
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

                            <div class="modal fade" id="exampleModal{{ $pengembangantendik->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Pengembangan Dosen</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('pages.pengembangan_tenaga_kependidikan.update', $pengembangantendik->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" hidden name="id"
                                                    value="{{ $pengembangantendik->id }}">

                                                <div class="mb-3">
                                                    <label for="nama" class="form-label">Nama:</label>
                                                    <input type="text" class="form-control" id="nama"
                                                        name="nama" value="{{ $pengembangantendik->nama }}"
                                                        readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nipy" class="form-label">NIPY:</label>
                                                    <input type="text" class="form-control" id="nipy"
                                                        name="nipy" value="{{ $pengembangantendik->nipy }}"
                                                        readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nama_kegiatan" class="form-label">Nama Kegiatan:</label>
                                                    <textarea class="form-control" id="nama_kegiatan" name="nama_kegiatan" required>{{ $pengembangantendik->nama_kegiatan }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="waktu_pelaksanaan" class="form-label">Waktu:</label>
                                                    <input type="text" class="form-control" id="waktu_pelaksanaan"
                                                        name="waktu_pelaksanaan" value="{{ $pengembangantendik->waktu_pelaksanaan }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Jenis Kegiatan</label>
                                                    <select class="form-control" name="jenis_kegiatan">
                                                        <option value="Studi"
                                                            {{ $pengembangantendik->jenis_kegiatan == 'Studi' ? 'selected' : '' }}>
                                                            Studi</option>
                                                        <option value="Pelatihan"
                                                            {{ $pengembangantendik->jenis_kegiatan == 'Pelatihan' ? 'selected' : '' }}>
                                                            Pelatihan</option>
                                                        <option value="Seminar"
                                                            {{ $pengembangantendik->jenis_kegiatan == 'Seminar' ? 'selected' : '' }}>
                                                            Seminar</option>
                                                        <option value="Workshop"
                                                            {{ $pengembangantendik->jenis_kegiatan == 'Workshop' ? 'selected' : '' }}>
                                                            Workshop</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="url" class="form-label">Url:</label>
                                                    <textarea class="form-control" id="url" name="url">{{ $pengembangantendik->url }}</textarea>
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
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Pengembangan Tenaga Kependidikan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('pages.pengembangan_tenaga_kependidikan.add') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama:</label>
                                        <input type="text" class="form-control" id="nama"
                                            name="nama" value="{{ old('nama') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nipy" class="form-label">nipy:</label>
                                        <input type="text" class="form-control" id="nipy"
                                            name="nipy" value="{{ old('nipy') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama_kegiatan" class="form-label">Nama Kegiatan:</label>
                                        <textarea class="form-control" id="nama_kegiatan" name="nama_kegiatan" required>{{ old('nama_kegiatan') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="waktu_pelaksanaan" class="form-label">Waktu:</label>
                                        <input type="text" class="form-control" id="waktu_pelaksanaan"
                                            name="waktu_pelaksanaan" value="{{ old('waktu_pelaksanaan') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Jenis Kegiatan</label>
                                        <select class="form-control" name="jenis_kegiatan">
                                            <option value="Studi"
                                                {{ old('jenis_kegiatan') == 'Studi' ? 'selected' : '' }}>
                                                Studi</option>
                                            <option value="Pelatihan"
                                                {{ old('jenis_kegiatan') == 'Pelatihan' ? 'selected' : '' }}>
                                                Pelatihan</option>
                                            <option value="Seminar"
                                                {{ old('jenis_kegiatan') == 'Seminar' ? 'selected' : '' }}>
                                                Seminar</option>
                                            <option value="Workshop"
                                                {{ old('jenis_kegiatan') == 'Workshop' ? 'selected' : '' }}>
                                                Workshop</option>
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

                @if ($pengembangan_tenaga_kependidikan->isEmpty())
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

            modalTitle.textContent = 'Tambah Pengembangan Dosen ';
            // modalBodyInput.value = recipient;
        });
    </script>
</x-app-layout>
