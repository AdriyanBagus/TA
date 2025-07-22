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
                    {{ __('Lahan Praktek') }}
                </h2>
            </div>

            <div class="flex items-center space-x-4 mt-4">
                {{-- Dropdown Filter Tahun Akademik --}}
                <form method="GET" action="{{ route('pages.lahan_praktek') }}"
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
                    <a href="{{ route('pages.lahan_praktek.export') }}" class="btn btn-success btn-sm">
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
                <table id="lahanTable" class="min-w-full bg-white border border-gray-500 border-collapse">
                    <thead>
                        <tr>
                            <th class="px-2 py-2 border text-sm">No</th>
                            <th class="px-4 py-2 border text-sm">Lahan Praktek</th>
                            <th class="px-4 py-2 border text-sm">Akreditasi</th>
                            <th class="px-4 py-2 border text-sm">Kesesuaian Bidang Keilmuan</th>
                            <th class="px-4 py-2 border text-sm">Jumlah Mahasiswa</th>
                            <th class="px-4 py-2 border text-sm">Daya Tampung Mahasiswa</th>
                            <th class="px-4 py-2 border text-sm">Kontribusi</th>
                            <th class="px-4 py-2 border text-sm">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lahan_praktek as $lahanpraktek)
                            <tr>
                                <td class="px-1 py-2 border text-sm">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $lahanpraktek->lahan_praktek }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $lahanpraktek->akreditasi }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $lahanpraktek->kesesuaian_bidang_keilmuan }}
                                </td>
                                <td class="px-4 py-2 border text-sm">{{ $lahanpraktek->jumlah_mahasiswa }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $lahanpraktek->daya_tampung_mahasiswa }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $lahanpraktek->kontribusi_lahan_praktek }}</td>
                                <td class="px-1 py-3 border text-sm text-center">
                                    <button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal{{ $lahanpraktek->id }}">
                                        Edit
                                    </button>

                                    <form action="{{ route('pages.lahan_praktek.destroy', $lahanpraktek->id) }}"
                                        method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded btn-sm mt-1">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="exampleModal{{ $lahanpraktek->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Lahan Praktek</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('pages.lahan_praktek.update', $lahanpraktek->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" hidden name="id"
                                                    value="{{ $lahanpraktek->id }}">

                                                <div class="mb-3">
                                                    <label for="lahan_praktek" class="form-label">Lahan Praktek:</label>
                                                    <input type="text" class="form-control" id="lahan_praktek"
                                                        name="lahan_praktek" value="{{ $lahanpraktek->lahan_praktek }}"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="akreditasi" class="form-label">Akreditasi:</label>
                                                    <input type="text" class="form-control" id="akreditasi"
                                                        name="akreditasi" value="{{ $lahanpraktek->akreditasi }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="kesesuaian_bidang_keilmuan"
                                                        class="form-label">Kesesuaian Bidang Keilmuan:</label>
                                                    <select class="form-control" id="kesesuaian_bidang_keilmuan"
                                                        name="kesesuaian_bidang_keilmuan">
                                                        <option value="Sesuai"
                                                            {{ $lahanpraktek->kesesuaian_bidang_keilmuan == 'Sesuai' ? 'selected' : '' }}>
                                                            Sesuai</option>
                                                        <option value="Tidak Sesuai"
                                                            {{ $lahanpraktek->kesesuaian_bidang_keilmuan == 'Tidak Sesuai' ? 'selected' : '' }}>
                                                            Tidak Sesuai</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jumlah_mahasiswa" class="form-label">Jumlah
                                                        Mahasiswa:</label>
                                                    <input type="text" class="form-control" id="jumlah_mahasiswa"
                                                        name="jumlah_mahasiswa"
                                                        value="{{ $lahanpraktek->jumlah_mahasiswa }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="daya_tampung_mahasiswa" class="form-label">Daya
                                                        Tampung
                                                        Mahasiswa:</label>
                                                    <input type="text" class="form-control"
                                                        id="daya_tampung_mahasiswa" name="daya_tampung_mahasiswa"
                                                        value="{{ $lahanpraktek->daya_tampung_mahasiswa }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="kontribusi_lahan_praktek"
                                                        class="form-label">Kontribusi Lahan Praktek:</label>
                                                    <textarea class="form-control" id="kontribusi_lahan_praktek" name="kontribusi_lahan_praktek">
                                                        {{ $lahanpraktek->kontribusi_lahan_praktek }}</textarea>
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
                                <form action="{{ route('pages.lahan_praktek.add') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="lahan_praktek" class="form-label">Lahan Praktek:</label>
                                        <input type="text" class="form-control" id="lahan_praktek"
                                            name="lahan_praktek" value="{{ old('lahan_praktek') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="akreditasi" class="form-label">Akreditasi:</label>
                                        <input type="text" class="form-control" id="akreditasi" name="akreditasi"
                                            value="{{ old('akreditasi') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="kesesuaian_bidang_keilmuan" class="form-label">Kesesuaian Bidang
                                            Keilmuan:</label>
                                        <select class="form-control" id="kesesuaian_bidang_keilmuan"
                                            name="kesesuaian_bidang_keilmuan">
                                            <option value="Sesuai"
                                                {{ old('kesesuaian_bidang_keilmuan') == 'Sesuai' ? 'selected' : '' }}>
                                                Sesuai</option>
                                            <option value="Tidak Sesuai"
                                                {{ old('kesesuaian_bidang_keilmuan') == 'Tidak Sesuai' ? 'selected' : '' }}>
                                                Tidak Sesuai</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jumlah_mahasiswa" class="form-label">Jumlah Mahasiswa:</label>
                                        <input type="text" class="form-control" id="jumlah_mahasiswa"
                                            name="jumlah_mahasiswa" value="{{ old('jumlah_mahasiswa') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="daya_tampung_mahasiswa" class="form-label">Daya Tampung
                                            Mahasiswa:</label>
                                        <input type="text" class="form-control" id="daya_tampung_mahasiswa"
                                            name="daya_tampung_mahasiswa"
                                            value="{{ old('daya_tampung_mahasiswa') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="kontribusi_lahan_praktek" class="form-label">Kontribusi Lahan
                                            Praktek:</label>
                                        <textarea class="form-control" id="kontribusi_lahan_praktek" name="kontribusi_lahan_praktek">{{ old('kontribusi_lahan_praktek') }}</textarea>
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

                @if ($lahan_praktek->isEmpty())
                    <p class="text-center text-gray-500 mt-4">Data tidak ada.</p>
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

            modalTitle.textContent = 'Tambah Lahan Praktek ';
            // modalBodyInput.value = recipient;
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#lahanTable').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50],
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        next: "→",
                        previous: "←"
                    },
                    zeroRecords: "Data tidak ditemukan",
                },
                columnDefs: [{
                        orderable: false,
                        targets: [7]
                    } // Kolom Action tidak bisa sorting
                ]
            });
        });
    </script>
</x-app-layout>
