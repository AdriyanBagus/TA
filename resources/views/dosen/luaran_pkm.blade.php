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
                    {{ __('Luaran PKM') }}
                </h2>
            </div>

            <div class="flex items-center space-x-4 mt-4">
                {{-- Dropdown Filter Tahun Akademik --}}
                <form method="GET" action="{{ route('dosen.luaran_pkm') }}"
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
                        <a href="{{ route('dosen.luaran_pkm.export') }}" class="btn btn-success btn-sm">
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
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                <table class="min-w-full bg-white border border-gray-500">
                    <thead>
                        <tr>
                            <th class="px-2 py-2 border text-sm">No</th>
                            <th class="px-4 py-2 border text-sm">Judul Kegiatan</th>
                            <th class="px-4 py-2 border text-sm">Judul Karya</th>
                            <th class="px-4 py-2 border text-sm">Pencipta Utama</th>
                            <th class="px-4 py-2 border text-sm">Jenis Karya</th>
                            <th class="px-4 py-2 border text-sm">Nomor Karya</th>
                            <th class="px-4 py-2 border text-sm">Url</th>
                            <th class="px-4 py-2 border text-sm text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($luaran_pkm as $luaran)
                            <tr>
                                <td class="px-1 py-2 border text-sm">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $luaran->judul_pkm }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $luaran->judul_karya }}</td>
                                <td class="px-4 py-2 border text-sm">{!! nl2br(e($luaran->pencipta_utama)) !!}</td>
                                <td class="px-4 py-2 border text-sm">{{ $luaran->jenis }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $luaran->nomor_karya }}</td>
                                <td class="px-2 py-2 border text-sm">
                                    <a href="{{ $luaran->url }}" target="_blank"
                                        class="text-blue-500 hover:underline">
                                        Link
                                    </a>
                                </td>
                                <td class="px-1 py-3 border flex flex-col items-center space-y-2">
                                    <!-- Tombol Edit -->
                                    <button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal{{ $luaran->id }}">
                                        Edit
                                    </button>

                                    <!-- Tombol Delete -->
                                    <form
                                        action="{{ route('dosen.luaran_pkm.destroy', $luaran->id) }}"
                                        method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="exampleModal{{ $luaran->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Luaran PKM</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('dosen.luaran_pkm.update', $luaran->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" hidden name="id"
                                                    value="{{ $luaran->id }}">

                                                <div class="mb-3">
                                                    <label for="judul_pkm" class="form-label">Judul
                                                        Kegiatan:</label>
                                                    <textarea class="form-control" id="judul_pkm" name="judul_pkm" required>{{ $luaran->judul_pkm }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="judul_karya" class="form-label">Judul karya:</label>
                                                    <textarea class="form-control" id="judul_karya" name="judul_karya" required>{{ $luaran->judul_karya }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pencipta_utama" class="form-label">Pencipta
                                                        Utama:</label>
                                                    <textarea class="form-control" id="pencipta_utama" name="pencipta_utama" placeholder="eg: Dosen, Mahasiswa" required>{{ $luaran->pencipta_utama }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label>Jenis:</label>
                                                    <select class="form-control" name="jenis">
                                                        <option value="HKI"
                                                            {{ $luaran->jenis == 'HKI' ? 'selected' : '' }}>HKI
                                                        </option>
                                                        <option value="Paten"
                                                            {{ $luaran->jenis == 'Paten' ? 'selected' : '' }}>Paten
                                                        </option>
                                                        <option value="TTG"
                                                            {{ $luaran->jenis == 'TTG' ? 'selected' : '' }}>TTG
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nomor_karya" class="form-label">Nomor Karya:</label>
                                                    <input type="text" class="form-control" id="nomor_karya"
                                                        name="nomor_karya" value="{{ $luaran->nomor_karya }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="url" class="form-label">Url:</label>
                                                    <input type="text" class="form-control" id="url"
                                                        name="url" value="{{ $luaran->url }}">
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
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Luaran PKM</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('dosen.luaran_pkm.add') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="judul_pkm" class="form-label">Judul Kegiatan:</label>
                                        <textarea class="form-control" id="judul_pkm" name="judul_pkm" required>{{ old('judul_pkm') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="judul_karya" class="form-label">Judul karya:</label>
                                        <textarea class="form-control" id="judul_karya" name="judul_karya" required>{{ old('judul_karya') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pencipta_utama" class="form-label">Pencipta Utama:</label>
                                        <textarea class="form-control" id="pencipta_utama" name="pencipta_utama" placeholder="eg: Dosen, Mahasiswa">{{ old('pencipta_utama') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Jenis:</label>
                                        <select class="form-control" name="jenis">
                                            <option value="HKI" {{ old('jenis') == 'HKI' ? 'selected' : '' }}>HKI
                                            </option>
                                            <option value="Paten" {{ old('jenis') == 'Paten' ? 'selected' : '' }}>
                                                Paten
                                            </option>
                                            <option value="TTG" {{ old('jenis') == 'TTG' ? 'selected' : '' }}>TTG
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nomor_karya" class="form-label">Nomor Karya:</label>
                                        <input type="text" class="form-control" id="nomor_karya"
                                            name="nomor_karya" value="{{ old('nomor_karya') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="url" class="form-label">Url:</label>
                                        <input type="text" class="form-control" id="url" name="url"
                                            placeholder="https://example.com" value="{{ old('url') }}">
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

                @if ($luaran_pkm->isEmpty())
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

            modalTitle.textContent = 'Tambah luaran PKM ';
            // modalBodyInput.value = recipient;
        });
    </script>
</x-app-layout>