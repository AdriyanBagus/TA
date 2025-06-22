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
                    {{ __('Penelitian Dosen') }}
                </h2>
            </div>

            <div class="flex items-center space-x-4 mt-4">
                {{-- Dropdown Filter Tahun Akademik --}}
                <form method="GET" action="{{ route('pages.penelitian_dosen') }}"
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
                    <a href="{{ route('pages.penelitian_dosen.export') }}" class="btn btn-success btn-sm" onclick="return confirm('Apakah Anda yakin ingin mendownload CSV?')">
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
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-3">
                <table class="min-w-full bg-white border border-gray-500">
                    <thead>
                        <tr>
                            <th class="px-1 py-2 border text-sm">No</th>
                            <th class="px-4 py-2 border text-sm">Judul Penelitian</th>
                            <th class="px-4 py-2 border text-sm">Nama Dosen Peneliti</th>
                            <th class="px-4 py-2 border text-sm">Nama Mahasiswa</th>
                            <th class="px-4 py-2 border text-sm">Tingkat</th>
                            <th class="px-4 py-2 border text-sm">Sumber Dana</th>
                            <th class="px-4 py-2 border text-sm">Bentuk Dana</th>
                            <th class="px-4 py-2 border text-sm">Jumlah Dana</th>
                            <th class="px-4 py-2 border text-sm">Kesesuaian Roadmap</th>
                            <th class="px-4 py-2 border text-sm">Bentuk Integrasi</th>
                            <th class="px-4 py-2 border text-sm">Mata Kuliah</th>
                            <th class="px-1 py-2 border text-sm">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penelitian_dosen as $penelitiandosen)
                            <tr>
                                <td class="px-1 py-2 border text-sm">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $penelitiandosen->judul_penelitian }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $penelitiandosen->nama_dosen_peneliti }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $penelitiandosen->nama_mahasiswa }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $penelitiandosen->tingkat }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $penelitiandosen->sumber_dana }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $penelitiandosen->bentuk_dana }}</td>
                                <td class="px-4 py-2 border text-sm">Rp {{ $penelitiandosen->jumlah_dana }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $penelitiandosen->kesesuaian_roadmap }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $penelitiandosen->bentuk_integrasi }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $penelitiandosen->mata_kuliah }}</td>
                                <td class="px-1 py-3 border flex flex-col items-center space-y-2">
                                    <!-- Tombol Edit -->
                                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $penelitiandosen->id }}">
                                        Edit
                                    </button>

                                    <!-- Tombol Delete -->
                                    <form action="{{ route('pages.penelitian_dosen.destroy', $penelitiandosen->id) }}"
                                        method="POST" onsubmit="return confirm('Yakin ingin menghapus ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="exampleModal{{ $penelitiandosen->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Penelitian Dosen</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form
                                                action="{{ route('pages.penelitian_dosen.update', $penelitiandosen->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" hidden name="id"
                                                    value="{{ $penelitiandosen->id }}">

                                                <div class="mb-3">
                                                    <label for="judul_penelitian" class="form-label">Judul
                                                        Penelitian:</label>
                                                    <textarea class="form-control" id="judul_penelitian"
                                                        name="judul_penelitian" required>{{ $penelitiandosen->judul_penelitian }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nama_dosen_peneliti" class="form-label">Nama
                                                        Dosen:</label>
                                                    <textarea class="form-control" id="nama_dosen_peneliti"
                                                        name="nama_dosen_peneliti" required>{{ $penelitiandosen->nama_dosen_peneliti }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nama_mahasiswa" class="form-label">Nama
                                                        Mahasiswa:</label>
                                                    <input type="text" class="form-control" id="nama_mahasiswa"
                                                        name="nama_mahasiswa"
                                                        value="{{ $penelitiandosen->nama_mahasiswa }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tingkat</label>
                                                    <select class="form-control" name="tingkat">
                                                        <option value="Internasional"
                                                            {{ $penelitiandosen->tingkat == 'Internasional' ? 'selected' : '' }}>
                                                            Internasional</option>
                                                        <option value="Nasional"
                                                            {{ $penelitiandosen->tingkat == 'Nasional' ? 'selected' : '' }}>
                                                            Nasional</option>
                                                        <option value="Lokal"
                                                            {{ $penelitiandosen->tingkat == 'Lokal' ? 'selected' : '' }}>Lokal
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="sumber_dana" class="form-label">Sumber Dana:</label>
                                                    <input type="text" class="form-control" id="sumber_dana"
                                                        name="sumber_dana"
                                                        value="{{ $penelitiandosen->sumber_dana }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Bentuk Dana:</label>
                                                    <select class="form-control" name="bentuk_dana"
                                                        value="{{ $penelitiandosen->bentuk_dana }}">
                                                        <option value="Inkind"
                                                            {{ $penelitiandosen->bentuk_dana == 'Inkind' ? 'selected' : '' }}>
                                                            Inkind</option>
                                                        <option value="Cash"
                                                            {{ $penelitiandosen->bentuk_dana == 'Cash' ? 'selected' : '' }}>
                                                            Cash</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jumlah_dana" class="form-label">Jumlah Dana:</label>
                                                    <input type="number" class="form-control" id="jumlah_dana"
                                                        name="jumlah_dana"
                                                        value="{{ $penelitiandosen->jumlah_dana }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Kesesuaian Roadmap</label>
                                                    <select class="form-control" name="kesesuaian_roadmap"
                                                        value="{{ $penelitiandosen->kesesuaian_roadmap }}">
                                                        <option value="sesuai"
                                                            {{ $penelitiandosen->kesesuaian_roadmap == 'sesuai' ? 'selected' : '' }}>
                                                            Sesuai</option>
                                                        <option value="kurang sesuai"
                                                            {{ $penelitiandosen->kesesuaian_roadmap == 'kurang sesuai' ? 'selected' : '' }}>
                                                            Kurang Sesuai</option>
                                                        <option value="tidak sesuai"
                                                            {{ $penelitiandosen->kesesuaian_roadmap == 'tidak sesuai' ? 'selected' : '' }}>
                                                            Tidak Sesuai</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="bentuk_integrasi" class="form-label">Bentuk
                                                        Integrasi:</label>
                                                    <input type="text" class="form-control" id="bentuk_integrasi"
                                                        name="bentuk_integrasi"
                                                        value="{{ $penelitiandosen->bentuk_integrasi }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="mata_kuliah" class="form-label">Mata Kuliah:</label>
                                                    <input type="text" class="form-control" id="mata_kuliah"
                                                        name="mata_kuliah"
                                                        value="{{ $penelitiandosen->mata_kuliah }}">
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
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Profil Dosen</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('pages.penelitian_dosen.add') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="judul_penelitian" class="form-label">Judul Penelitian:</label>
                                        <textarea class="form-control" id="judul_penelitian" name="judul_penelitian" required>{{ old('judul_penelitian') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama_dosen_peneliti" class="form-label">Nama Dosen:</label>
                                        <textarea class="form-control" id="nama_dosen_peneliti"
                                            name="nama_dosen_peneliti" required>{{ old('nama_dosen_peneliti') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa:</label>
                                        <input type="text" class="form-control" id="nama_mahasiswa"
                                            name="nama_mahasiswa" value="{{ old('nama_mahasiswa') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Tingkat</label>
                                        <select class="form-control" name="tingkat">
                                            <option value="Internasional"
                                                {{ old('tingkat') == 'Internasional' ? 'selected' : '' }}>Internasional
                                            </option>
                                            <option value="Nasional"
                                                {{ old('tingkat') == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                            <option value="Lokal" {{ old('tingkat') == 'Lokal' ? 'selected' : '' }}>
                                                Lokal</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="sumber_dana" class="form-label">Sumber Dana:</label>
                                        <input type="text" class="form-control" id="sumber_dana"
                                            name="sumber_dana" value="{{ old('sumber_dana') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Bentuk Dana:</label>
                                        <select class="form-control" name="bentuk_dana">
                                            <option value="Inkind"
                                                {{ old('bentuk_dana') == 'Inkind' ? 'selected' : '' }}>Inkind</option>
                                            <option value="Cash"
                                                {{ old('bentuk_dana') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jumlah_dana" class="form-label">Jumlah Dana:</label>
                                        <input type="number" class="form-control" id="jumlah_dana"
                                            name="jumlah_dana" value="{{ old('jumlah_dana') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Kesesuaian Roadmap</label>
                                        <select class="form-control" name="kesesuaian_roadmap">
                                            <option value="Sesuai"
                                                {{ old('kesesuaian_roadmap') == 'Sesuai' ? 'selected' : '' }}>
                                                Sesuai</option>
                                            <option value="Kurang Sesuai"
                                                {{ old('kesesuaian_roadmap') == 'Kurang Sesuai' ? 'selected' : '' }}>
                                                Kurang Sesuai</option>
                                            <option value="Tidak Sesuai"
                                                {{ old('kesesuaian_roadmap') == 'Tidak Sesuai' ? 'selected' : '' }}>
                                                Tidak Sesuai</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="bentuk_integrasi" class="form-label">Bentuk Integrasi:</label>
                                        <input type="text" class="form-control" id="bentuk_integrasi"
                                            name="bentuk_integrasi" value="{{ old('bentuk_integrasi') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="mata_kuliah" class="form-label">Mata Kuliah:</label>
                                        <input type="text" class="form-control" id="mata_kuliah"
                                            name="mata_kuliah" value="{{ old('mata_kuliah') }}" required>
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

                @if ($penelitian_dosen->isEmpty())
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

            modalTitle.textContent = 'Tambah Penelitian Dosen';
            // modalBodyInput.value = recipient;
        });
    </script>
</x-app-layout>
