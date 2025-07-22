<x-app-layout>
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
                    {{ __('PKM Dosen') }}
                </h2>
            </div>

            <div class="flex items-center space-x-4 mt-4">
                {{-- Dropdown Filter Tahun Akademik --}}
                <form method="GET" action="{{ route('dosen.pkm_dosen') }}"
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
                    <a href="{{ route('dosen.pkm_dosen.export') }}" class="btn btn-success btn-sm"
                        onclick="return confirm('Apakah Anda yakin ingin mendownload CSV?')">
                        Download CSV
                    </a>

                    @if ($tahunTerpilih && $tahunList->where('id', $tahunTerpilih)->first()->is_active)
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
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
                            <th class="px-2 py-2 border text-xs">No</th>
                            <th class="px-4 py-2 border text-xs">Judul PKM</th>
                            <th class="px-4 py-2 border text-xs">Nama Dosen</th>
                            <th class="px-4 py-2 border text-xs">Nama Mahasiswa</th>
                            <th class="px-4 py-2 border text-xs">Tingkat</th>
                            <th class="px-4 py-2 border text-xs">Sumber Dana</th>
                            <th class="px-4 py-2 border text-xs">Bentuk Dana</th>
                            <th class="px-4 py-2 border text-xs">Jumlah Dana</th>
                            <th class="px-4 py-2 border text-xs">Bentuk Integrasi</th>
                            <th class="px-4 py-2 border text-xs">Mata Kuliah</th>
                            <th class="px-4 py-2 border text-sm text-center">Url</th>
                            <th class="px-4 py-2 border text-xs">Roadmap</th>
                            <th class="px-4 py-2 border text-sm text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pkm_dosen as $pkmdosen)
                            <tr>
                                <td class="px-1 py-2 border text-xs">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border text-xs">{{ $pkmdosen->judul_pkm }}</td>
                                <td class="px-4 py-2 border text-xs">{!! nl2br(e($pkmdosen->dosen)) !!}</td>
                                <td class="px-4 py-2 border text-xs">{!! nl2br(e($pkmdosen->mahasiswa)) !!}</td>
                                <td class="px-4 py-2 border text-xs">{{ $pkmdosen->tingkat }}</td>
                                <td class="px-4 py-2 border text-xs">{{ $pkmdosen->sumber_dana }}</td>
                                <td class="px-4 py-2 border text-xs">{{ $pkmdosen->bentuk_dana }}</td>
                                <td class="px-4 py-2 border text-xs">{{ $pkmdosen->jumlah_dana }}</td>
                                <td class="px-4 py-2 border text-xs">{{ $pkmdosen->bentuk_integrasi }}</td>
                                <td class="px-4 py-2 border text-xs">{{ $pkmdosen->mata_kuliah }}</td>
                                <td class="px-4 py-2 border text-sm">
                                    <a href="{{ $pkmdosen->url }}" target="_blank"
                                        class="text-blue-500 hover:text-blue-700 underline">Link</a>
                                </td>
                                <td class="px-4 py-2 border text-sm text-center">
                                    @if ($pkmdosen->kesesuaian_roadmap == 'Sesuai')
                                        <span
                                            class="badge bg-success text-white">{{ $pkmdosen->kesesuaian_roadmap }}</span>
                                    @elseif ($pkmdosen->kesesuaian_roadmap == 'Kurang Sesuai')
                                        <span
                                            class="badge bg-warning text-white">{{ $pkmdosen->kesesuaian_roadmap }}</span>
                                    @elseif ($pkmdosen->kesesuaian_roadmap == 'Tidak Sesuai')
                                        <span
                                            class="badge bg-danger text-white">{{ $pkmdosen->kesesuaian_roadmap }}</span>
                                    @else
                                        <span class="badge bg-secondary text-white">-</span>
                                    @endif
                                </td>
                                <td class="px-1 py-3 border flex flex-col items-center space-y-2">
                                    <!-- Tombol Edit -->
                                    <button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-xs"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal{{ $pkmdosen->id }}">
                                        Edit
                                    </button>

                                    <!-- Tombol Delete -->
                                    <form action="{{ route('dosen.pkm_dosen.destroy', $pkmdosen->id) }}" method="POST"
                                        class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="exampleModal{{ $pkmdosen->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit PKM Dosen</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('dosen.pkm_dosen.update', $pkmdosen->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" hidden name="id"
                                                    value="{{ $pkmdosen->id }}">

                                                <div class="mb-3">
                                                    <label for="judul_pkm" class="form-label">Judul PKM:</label>
                                                    <textarea class="form-control" id="judul_pkm" name="judul_pkm" required>{{ $pkmdosen->judul_pkm }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="dosen" class="form-label">Nama Dosen:</label>
                                                    <textarea class="form-control" id="dosen" name="dosen" required>{{ $pkmdosen->dosen }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="mahasiswa" class="form-label">Nama Mahasiswa:</label>
                                                    <textarea class="form-control" id="mahasiswa" name="mahasiswa" required>{{ $pkmdosen->mahasiswa }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label>Tingkat:</label>
                                                    <select class="form-control" name="tingkat"
                                                        value="{{ $pkmdosen->tingkat }}">
                                                        <option value="internasional"
                                                            {{ old('tingkat') == 'internasional' ? 'selected' : '' }}>
                                                            Internasional</option>
                                                        <option value="nasional"
                                                            {{ old('tingkat') == 'nasional' ? 'selected' : '' }}>
                                                            Nasional</option>
                                                        <option value="lokal"
                                                            {{ old('tingkat') == 'lokal' ? 'selected' : '' }}>Lokal
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="sumber_dana" class="form-label">Sumber Dana:</label>
                                                    <input type="text" class="form-control" id="sumber_dana"
                                                        name="sumber_dana" placeholder="PT, Mandiri, Luar PT sebutkan"
                                                        value="{{ $pkmdosen->sumber_dana }}" required>
                                                </div>

                                                <div class="form-group">
                                                    <label>Bentuk Dana:</label>
                                                    <select class="form-control" name="bentuk_dana"
                                                        value="{{ $pkmdosen->bentuk_dana }}">
                                                        <option value="Inkind"
                                                            {{ $pkmdosen->bentuk_dana == 'Inkind' ? 'selected' : '' }}>
                                                            Inkind</option>
                                                        <option value="Cash"
                                                            {{ $pkmdosen->bentuk_dana == 'Cash' ? 'selected' : '' }}>
                                                            Cash</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="jumlah_dana" class="form-label">Jumlah Dana:</label>
                                                    <input type="number" class="form-control" id="jumlah_dana"
                                                        name="jumlah_dana"
                                                        value="{{ $pkmdosen->jumlah_dana }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="bentuk_integrasi" class="form-label">Sumber
                                                        Dana:</label>
                                                    <input type="text" class="form-control" id="bentuk_integrasi"
                                                        name="bentuk_integrasi"
                                                        value="{{ $pkmdosen->bentuk_integrasi }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="mata_kuliah" class="form-label">Mata Kuliah:</label>
                                                    <input type="text" class="form-control" id="mata_kuliah"
                                                        name="mata_kuliah" value="{{ $pkmdosen->mata_kuliah }}"
                                                        required>
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
                            <form action="{{ route('dosen.pkm_dosen.add') }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah PKM Dosen</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="judul_pkm" class="form-label">Judul PKM:</label>
                                        <textarea class="form-control" id="judul_pkm" name="judul_pkm" required>{{ session('judul_pkm') }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="dosen" class="form-label">Nama Dosen:</label>
                                        <textarea class="form-control" id="dosen" name="dosen" required>{{ session('dosen') }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="mahasiswa" class="form-label">Nama Mahasiswa:</label>
                                        <textarea class="form-control" id="mahasiswa" name="mahasiswa" required>{{ session('mahasiswa') }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label>Tingkat:</label>
                                        <select class="form-control" name="tingkat" required>
                                            <option value="internasional"
                                                {{ old('tingkat') == 'internasional' ? 'selected' : '' }}>Internasional
                                            </option>
                                            <option value="nasional"
                                                {{ old('tingkat') == 'nasional' ? 'selected' : '' }}>Nasional</option>
                                            <option value="lokal" {{ old('tingkat') == 'lokal' ? 'selected' : '' }}>
                                                Lokal</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="sumber_dana" class="form-label">Sumber Dana:</label>
                                        <input type="text" class="form-control" id="sumber_dana"
                                            name="sumber_dana" value="{{ session('sumber_dana') }}" required>
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
                                            name="jumlah_dana" value="{{ old('jumlah_dana') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="bentuk_integrasi" class="form-label">Bentuk Integrasi:</label>
                                        <input type="text" class="form-control" id="bentuk_integrasi"
                                            name="bentuk_integrasi" value="{{ session('bentuk_integrasi') }}"
                                            required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="mata_kuliah" class="form-label">Mata Kuliah:</label>
                                        <input type="text" class="form-control" id="mata_kuliah"
                                            name="mata_kuliah" value="{{ session('mata_kuliah') }}" required>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- End Modal --}}

                @if ($pkm_dosen->isEmpty())
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
        const exampleModal = document.getElementById('exampleModal');
        exampleModal.addEventListener('show.bs.modal', function() {
            const modalTitle = exampleModal.querySelector('.modal-title');
            modalTitle.textContent = 'Tambah PKM Dosen';
        });
    </script>

</x-app-layout>
