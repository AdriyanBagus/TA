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
                    {{ __('Pelaksanaan TA') }}
                </h2>
            </div>

            <div class="flex items-center space-x-4 mt-4">
                {{-- Dropdown Filter Tahun Akademik --}}
                <form method="GET" action="{{ route('dosen.pelaksanaan_ta') }}"
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
                    <a href="{{ route('dosen.pelaksanaan_ta.export') }}" class="btn btn-success btn-sm"
                        onclick="return confirm('Apakah Anda yakin ingin mendownload CSV?')">
                        Download CSV
                    </a>

                    @if (!$sudahAdaData && $tahunTerpilih && $tahunList->where('id', $tahunTerpilih)->first()->is_active)
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
                            <th class="px-2 py-2 border text-sm">No</th>
                            <th class="px-4 py-2 border text-sm">Nama</th>
                            <th class="px-4 py-2 border text-sm">NIDN</th>
                            <th class="px-4 py-2 border text-sm">Bimbingan Mahasiswa PS Sendiri</th>
                            <th class="px-4 py-2 border text-sm">Jumlah Bimbingan PS sendiri</th>
                            <th class="px-4 py-2 border text-sm">Bimbingan Mahasiswa PS Lain</th>
                            <th class="px-4 py-2 border text-sm">Jumlah Bimbingan PS Lain</th>
                            <th class="px-4 py-2 border text-sm">Jumlah Bimbingan Seluruh PS</th>
                            <th class="px-4 py-2 border text-sm text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pelaksanaan_ta as $pelaksanaanta)
                            <tr>
                                <td class="px-1 py-2 border text-sm">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $pelaksanaanta->nama }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $pelaksanaanta->nidn }}</td>
                                <td class="px-4 py-2 border text-sm">
                                    {{ $pelaksanaanta->bimbingan_mahasiswa_ps_sendiri }}</td>
                                <td class="px-4 py-2 border text-sm">
                                    {{ $pelaksanaanta->rata_rata_jumlah_bimbingan_ps_sendiri }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $pelaksanaanta->bimbingan_mahasiswa_ps_lain }}
                                </td>
                                <td class="px-4 py-2 border text-sm">
                                    {{ $pelaksanaanta->rata_rata_jumlah_bimbingan_ps_lain }}</td>
                                <td class="px-4 py-2 border text-sm">
                                    {{ $pelaksanaanta->rata_rata_jumlah_bimbingan_seluruh_ps }}</td>
                                <td class="px-1 py-3 border flex flex-col items-center space-y-2">
                                    <!-- Tombol Edit -->
                                    <button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal{{ $pelaksanaanta->id }}">
                                        Edit
                                    </button>

                                    <!-- Tombol Delete -->
                                    <form
                                        action="{{ route('dosen.pelaksanaan_ta.destroy', $pelaksanaanta->id) }}"
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

                            <div class="modal fade" id="exampleModal{{ $pelaksanaanta->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah Pelaksanaan TA</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form
                                                action="{{ route('dosen.pelaksanaan_ta.update', $pelaksanaanta->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" hidden name="id"
                                                    value="{{ $pelaksanaanta->id }}">

                                                <div class="mb-3">
                                                    <label for="bimbingan_mahasiswa_ps_sendiri"
                                                        class="form-label">Bimbingan Mahasiswa PS sendiri:</label>
                                                    <input type="number" class="form-control"
                                                        id="bimbingan_mahasiswa_ps_sendiri"
                                                        name="bimbingan_mahasiswa_ps_sendiri"
                                                        value="{{ $pelaksanaanta->bimbingan_mahasiswa_ps_sendiri }}"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="rata_rata_jumlah_bimbingan_ps_sendiri"
                                                        class="form-label">Jumlah Bimbingan PS Sendiri:</label>
                                                    <input type="number" class="form-control"
                                                        id="rata_rata_jumlah_bimbingan_ps_sendiri"
                                                        name="rata_rata_jumlah_bimbingan_ps_sendiri"
                                                        value="{{ $pelaksanaanta->rata_rata_jumlah_bimbingan_ps_sendiri }}"
                                                        readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="bimbingan_mahasiswa_ps_lain"
                                                        class="form-label">Bimbingan Mahasiswa PS Lain:</label>
                                                    <input type="number" class="form-control"
                                                        id="bimbingan_mahasiswa_ps_lain"
                                                        name="bimbingan_mahasiswa_ps_lain"
                                                        value="{{ $pelaksanaanta->bimbingan_mahasiswa_ps_lain }}"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="rata_rata_jumlah_bimbingan_ps_lain"
                                                        class="form-label">Jumlah Bimbingan PS Lain:</label>
                                                    <input type="number" class="form-control"
                                                        id="rata_rata_jumlah_bimbingan_ps_lain"
                                                        name="rata_rata_jumlah_bimbingan_ps_lain"
                                                        value="{{ $pelaksanaanta->rata_rata_jumlah_bimbingan_ps_lain }}"
                                                        readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="rata_rata_jumlah_bimbingan_seluruh_ps"
                                                        class="form-label">Jumlah Bimbingan Seluruh PS:</label>
                                                    <input type="number" class="form-control"
                                                        id="rata_rata_jumlah_bimbingan_seluruh_ps"
                                                        name="rata_rata_jumlah_bimbingan_seluruh_ps"
                                                        value="{{ $pelaksanaanta->rata_rata_jumlah_bimbingan_seluruh_ps }}"
                                                        readonly>
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
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Pelaksanaan TA</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('dosen.pelaksanaan_ta.add') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="bimbingan_mahasiswa_ps_sendiri" class="form-label">Bimbingan
                                            Mahasiswa PS sendiri:</label>
                                        <input type="number" class="form-control"
                                            id="bimbingan_mahasiswa_ps_sendiri" name="bimbingan_mahasiswa_ps_sendiri"
                                            value="{{ old('bimbingan_mahasiswa_ps_sendiri') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="bimbingan_mahasiswa_ps_lain" class="form-label">Bimbingan
                                            Mahasiswa PS Lain:</label>
                                        <input type="number" class="form-control" id="bimbingan_mahasiswa_ps_lain"
                                            name="bimbingan_mahasiswa_ps_lain"
                                            value="{{ old('bimbingan_mahasiswa_ps_lain') }}" required>
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

                @if ($pelaksanaan_ta->isEmpty())
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

            modalTitle.textContent = 'Tambah Pelaksanaan TA ';
            // modalBodyInput.value = recipient;
        });
    </script>
</x-app-layout>