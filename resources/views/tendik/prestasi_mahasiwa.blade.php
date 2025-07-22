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
                    {{ __('Prestasi Mahasiswa') }}
                </h2>
            </div>

            <div class="flex items-center space-x-4 mt-4">
                {{-- Dropdown Filter Tahun Akademik --}}
                <form method="GET" action="{{ route('pages.prestasi_mahasiswa') }}"
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
                        <a href="{{ route('pages.prestasi_mahasiswa.export') }}" class="btn btn-success btn-sm">
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
                            <th class="px-4 py-2 border text-sm">Jenis Prestasi</th>
                            <th class="px-4 py-2 border text-sm">Nama Prestasi</th>
                            <th class="px-4 py-2 border text-sm">Tingkat</th>
                            <th class="px-4 py-2 border text-sm">Tahun</th>
                            <th class="px-4 py-2 border text-sm">Url</th>
                            <th class="px-4 py-2 border text-sm">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prestasi_mahasiswa as $prestasimahasiswa)
                            <tr>
                                <td class="px-1 py-2 border text-sm">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $prestasimahasiswa->nama }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $prestasimahasiswa->jenis_prestasi }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $prestasimahasiswa->nama_prestasi }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $prestasimahasiswa->tingkat }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $prestasimahasiswa->tahun }}</td>
                                <td class="px-1 py-2 border text-sm">
                                    <a href="{{ $prestasimahasiswa->url }}" target="_blank"
                                        class="text-blue-500 hover:underline">
                                        Link
                                    </a>
                                </td>
                                <td class="px-1 py-3 border flex flex-col items-center space-y-2">
                                    <!-- Tombol Edit -->
                                    <button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal{{ $prestasimahasiswa->id }}">
                                        Edit
                                    </button>

                                    <!-- Tombol Delete -->
                                    <form action="{{ route('pages.prestasi_mahasiswa.destroy', $prestasimahasiswa->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?');">

                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="exampleModal{{ $prestasimahasiswa->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Prestasi Mahasiswa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('pages.prestasi_mahasiswa.update', $prestasimahasiswa->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" hidden name="id"
                                                    value="{{ $prestasimahasiswa->id }}">

                                                <div class="mb-3">
                                                    <label for="nama" class="form-label">Nama:</label>
                                                    <input type="text" class="form-control" id="nama"
                                                        name="nama" value="{{ $prestasimahasiswa->nama }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Jenis Prestasi</label>
                                                    <select class="form-control" name="jenis_prestasi">
                                                        <option value="Akademik"
                                                            {{ $prestasimahasiswa->jenis_prestasi == 'Akademik' ? 'selected' : '' }}>
                                                            Akademik</option>
                                                        <option value="Non-Akademik"
                                                            {{ $prestasimahasiswa->jenis_prestasi == 'Non-Akademik' ? 'selected' : '' }}>
                                                            Non-Akademik</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nama_prestasi" class="form-label">Nama Prestasi:</label>
                                                    <textarea class="form-control" id="nama_prestasi" name="nama_prestasi" required>{{ $prestasimahasiswa->nama_prestasi }}</textarea>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label>Tingkat</label>
                                                    <select class="form-control" name="tingkat">
                                                        <option value="Internasional"
                                                            {{ $prestasimahasiswa->tingkat == 'Internasional' ? 'selected' : '' }}>
                                                            Internasional</option>
                                                        <option value="Nasional"
                                                            {{ $prestasimahasiswa->tingkat == 'Nasional' ? 'selected' : '' }}>
                                                            Nasional</option>
                                                        <option value="Lokal"
                                                            {{ $prestasimahasiswa->tingkat == 'Lokal' ? 'selected' : '' }}>
                                                            Lokal</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tahun" class="form-label">Tahun:</label>
                                                    <input type="number" class="form-control" id="tahun"
                                                        name="tahun" value="{{ $prestasimahasiswa->tahun }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="url" class="form-label">Url:</label>
                                                    <textarea class="form-control" id="url" name="url">{{ $prestasimahasiswa->url }}</textarea>
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
                                <h5 class="modal-title" id="exampleModalLabel">New Message</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('pages.prestasi_mahasiswa.add') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama:</label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            value="{{ old('nama') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Jenis Prestasi</label>
                                        <select class="form-control" name="jenis_prestasi">
                                            <option value="Akademik" {{ old('jenis_prestasi') == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                                            <option value="Non-Akademik" {{ old('jenis_prestasi') == 'Non-Akademik' ? 'selected' : '' }}>Non-Akademik</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama_prestasi" class="form-label">Nama Prestasi:</label>
                                        <textarea class="form-control" id="nama_prestasi" name="nama_prestasi" required>{{ old('nama_prestasi') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Tingkat</label>
                                        <select class="form-control" name="tingkat">
                                            <option value="Internasional" {{ old('tingkat') == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                                            <option value="Nasional" {{ old('tingkat') == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                            <option value="Lokal" {{ old('tingkat') == 'Lokal' ? 'selected' : '' }}>Lokal</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tahun" class="form-label">Tahun:</label>
                                        <input type="number" class="form-control" id="tahun" name="tahun"
                                            value="{{ old('tahun') }}" required>
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

                @if ($prestasi_mahasiswa->isEmpty())
                    <p class="text-center text-gray-500 mt-4">Tidak ada data yang diinput.</p>
                @endif
            </div>
        </div>
    </div>

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

            modalTitle.textContent = 'Tambah Prestasi Mahasiswa';
            // modalBodyInput.value = recipient;
        });
    </script>
</x-app-layout>
