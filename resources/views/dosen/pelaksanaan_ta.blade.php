<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('dosen.dashboard') }}"
                    class="inline-flex items-center bg-gray-100 hover:bg-gray-200 text-black-700 text-sm px-3 py-1.5 rounded-lg shadow-sm transition duration-200 mr-4">
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
            
            {{-- Gemi's Edit: Mengelompokkan filter dan tombol --}}
            <div class="flex items-center space-x-4">
                <form method="GET" action="{{ route('dosen.pelaksanaan_ta.show') }}" class="flex items-center gap-2">
                    <label for="tahun" class="text-sm font-medium text-gray-700">Tahun Akademik:</label>
                    <select name="tahun" id="tahun" onchange="this.form.submit()"
                        class="block w-64 px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm">
                        @foreach ($tahunList as $tahun)
                            <option value="{{ $tahun->id }}" {{ $tahunTerpilih == $tahun->id ? 'selected' : '' }}>
                                {{ $tahun->tahun }} {{ $tahun->is_active ? '(Aktif)' : '' }}
                            </option>
                        @endforeach
                    </select>
                </form>

                {{-- Gemi's Edit: Menambahkan tombol Download CSV --}}
                <a href="{{ route('dosen.pelaksanaan_ta.export', ['tahun' => $tahunTerpilih]) }}" class="btn btn-success btn-sm">
                    Download CSV
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- BAGIAN 1: FORM TAMBAH DATA -->
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Data Bimbingan Mahasiswa</h3>
                <form action="{{ route('dosen.pelaksanaan_ta.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="nama_mahasiswa" class="block text-sm font-medium text-gray-700">Nama Mahasiswa</label>
                            <input type="text" name="nama_mahasiswa" id="nama_mahasiswa" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label for="prodi_mahasiswa" class="block text-sm font-medium text-gray-700">Asal Prodi Mahasiswa</label>
                            <select name="prodi_mahasiswa" id="prodi_mahasiswa" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="" disabled selected>Pilih Prodi</option>
                                @foreach ($prodiList as $prodi)
                                    <option value="{{ $prodi }}">{{ $prodi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Posisi Saya Sebagai</label>
                            <div class="mt-2 space-y-2">
                                <div class="flex items-center">
                                    <input id="dospem_1" name="posisi_dosen" type="radio" value="Dospem 1" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" required>
                                    <label for="dospem_1" class="ml-3 block text-sm font-medium text-gray-700">Dosen Pembimbing 1</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="dospem_2" name="posisi_dosen" type="radio" value="Dospem 2" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                    <label for="dospem_2" class="ml-3 block text-sm font-medium text-gray-700">Dosen Pembimbing 2</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-primary btn-sm">Tambah Data</button>
                    </div>
                </form>
            </div>

            <!-- BAGIAN 2: TABEL DAFTAR BIMBINGAN (DENGAN TOMBOL ACTION) -->
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Daftar Mahasiswa Bimbingan</h3>
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 border text-left text-sm font-semibold text-gray-600">No</th>
                            <th class="px-4 py-2 border text-left text-sm font-semibold text-gray-600">Nama Mahasiswa</th>
                            <th class="px-4 py-2 border text-left text-sm font-semibold text-gray-600">Prodi Mahasiswa</th>
                            <th class="px-4 py-2 border text-left text-sm font-semibold text-gray-600">Dosen Pembimbing 1</th>
                            <th class="px-4 py-2 border text-left text-sm font-semibold text-gray-600">Dosen Pembimbing 2</th>
                            <th class="px-4 py-2 border text-center text-sm font-semibold text-gray-600">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($list_bimbingan_final as $bimbingan)
                            <tr>
                                <td class="px-4 py-2 border text-sm">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $bimbingan['nama_mahasiswa'] }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $bimbingan['prodi_mahasiswa'] }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $bimbingan['dosen_pembimbing_1'] ?? '-' }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $bimbingan['dosen_pembimbing_2'] ?? '-' }}</td>
                                <td class="px-4 py-2 border text-center">
                                    {{-- Tombol hanya muncul jika dosen yang login adalah Dospem 1 untuk baris ini --}}
                                    @if ($bimbingan['dosen_pembimbing_1'] == Auth::user()->name && $bimbingan['id_dospem_1'])
                                        <div class="flex justify-center items-center space-x-2">
                                            <button type="button" class="text-blue-600 hover:text-blue-900 text-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $bimbingan['id_dospem_1'] }}">Edit</button>
                                            <form action="{{ route('dosen.pelaksanaan_ta.destroy', $bimbingan['id_dospem_1']) }}" method="POST" class="d-inline delete-form">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Hapus</button>
                                            </form>
                                        </div>
                                    @endif
                                    {{-- Tombol hanya muncul jika dosen yang login adalah Dospem 2 untuk baris ini --}}
                                    @if ($bimbingan['dosen_pembimbing_2'] == Auth::user()->name && $bimbingan['id_dospem_2'])
                                        <div class="flex justify-center items-center space-x-2">
                                            <button type="button" class="text-blue-600 hover:text-blue-900 text-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $bimbingan['id_dospem_2'] }}">Edit</button>
                                            <form action="{{ route('dosen.pelaksanaan_ta.destroy', $bimbingan['id_dospem_2']) }}" method="POST" class="d-inline delete-form">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Hapus</button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-4 border text-center text-gray-500">Belum ada data bimbingan yang diinput.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- BAGIAN 3: TABEL REKAPITULASI -->
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Rekapitulasi Bimbingan</h3>
                <table class="min-w-full bg-white border border-gray-300">
                    <thead><tr class="bg-gray-50"><th class="px-4 py-2 border text-left text-sm font-semibold text-gray-600">Keterangan</th><th class="px-4 py-2 border text-left text-sm font-semibold text-gray-600">Jumlah</th></tr></thead>
                    <tbody>
                        <tr><td class="px-4 py-2 border text-sm">Jumlah Bimbingan (PS Sendiri)</td><td class="px-4 py-2 border text-sm">{{ $rekap['ps_sendiri'] ?? 0 }}</td></tr>
                        <tr><td class="px-4 py-2 border text-sm">Jumlah Bimbingan (PS Lain)</td><td class="px-4 py-2 border text-sm">{{ $rekap['ps_lain'] ?? 0 }}</td></tr>
                        <tr class="font-bold bg-gray-50"><td class="px-4 py-2 border text-sm">Jumlah Bimbingan Seluruh PS</td><td class="px-4 py-2 border text-sm">{{ $rekap['total_bimbingan'] ?? 0 }}</td></tr>
                        <tr><td class="px-4 py-2 border text-sm">Jumlah sebagai Dosen Pembimbing 1</td><td class="px-4 py-2 border text-sm">{{ $rekap['sebagai_dospem_1'] ?? 0 }}</td></tr>
                        <tr><td class="px-4 py-2 border text-sm">Jumlah sebagai Dosen Pembimbing 2</td><td class="px-4 py-2 border text-sm">{{ $rekap['sebagai_dospem_2'] ?? 0 }}</td></tr>
                    </tbody>
                </table>
            </div>

            <!-- BAGIAN KOMENTAR -->
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                <h3 class="text-lg font-bold mb-3">Komentar</h3>
                <ul>
                    @forelse ($komentar as $item)
                        <li class="mb-4 p-3 border rounded-md shadow-sm">
                            <div class="flex items-center mb-1"><div class=" bg-gray-500 rounded-full mr-2" style="width: 40px; height: 40px"></div><div><p class="font-semibold text-sm">Admin</p><p class="text-xs text-gray-500">{{ $item->created_at->format('d F Y - H:i') }} WIB</p></div></div>
                            <div class="text-sm mt-1 whitespace-pre-line">{!! nl2br(e($item->komentar)) !!}</div>
                        </li>
                    @empty
                        <p class="text-center text-gray-500 mt-4">Belum ada komentar.</p>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT YANG PINTAR -->
    @foreach ($list_bimbingan_final as $bimbingan)
        @php
            // Menentukan ID potongan puzzle mana yang akan diedit oleh user ini
            $editId = null;
            $currentPosisi = null;
            if ($bimbingan['dosen_pembimbing_1'] == Auth::user()->name) {
                $editId = $bimbingan['id_dospem_1'];
                $currentPosisi = 'Dospem 1';
            } elseif ($bimbingan['dosen_pembimbing_2'] == Auth::user()->name) {
                $editId = $bimbingan['id_dospem_2'];
                $currentPosisi = 'Dospem 2';
            }
        @endphp

        @if ($editId)
            <div class="modal fade" id="editModal{{ $editId }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header"><h5 class="modal-title">Edit Data Bimbingan</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                        <div class="modal-body">
                            <form action="{{ route('dosen.pelaksanaan_ta.update', $editId) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="space-y-4">
                                    <div><label class="block text-sm font-medium text-gray-700">Nama Mahasiswa</label><input type="text" name="nama_mahasiswa" value="{{ $bimbingan['nama_mahasiswa'] }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required></div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Asal Prodi Mahasiswa</label>
                                        <select name="prodi_mahasiswa" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                            @foreach ($prodiList as $prodi)
                                                <option value="{{ $prodi }}" {{ $bimbingan['prodi_mahasiswa'] == $prodi ? 'selected' : '' }}>{{ $prodi }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Posisi Saya Sebagai</label>
                                        <div class="mt-2 space-y-2">
                                            <div class="flex items-center"><input name="posisi_dosen" type="radio" value="Dospem 1" class="h-4 w-4" {{ $currentPosisi == 'Dospem 1' ? 'checked' : '' }} required><label class="ml-3 block text-sm">Dosen Pembimbing 1</label></div>
                                            <div class="flex items-center"><input name="posisi_dosen" type="radio" value="Dospem 2" class="h-4 w-4" {{ $currentPosisi == 'Dospem 2' ? 'checked' : '' }}><label class="ml-3 block text-sm">Dosen Pembimbing 2</label></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer mt-6"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan Perubahan</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</x-app-layout>
