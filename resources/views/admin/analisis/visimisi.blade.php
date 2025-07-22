<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Visi dan Misi') }}
            </h2>

            {{-- Dropdown Filter Tahun Akademik --}}
            <form method="GET" action="{{ route('visimisi') }}" class="flex flex-col md:flex-row md:items-center gap-2">
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
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('visimisi.export.csv') }}" method="GET" class="mb-4">
                <input type="hidden" name="tahun" value="{{ $tahunTerpilih }}">
                <input type="hidden" name="user_id" value="{{ $userTerpilih }}">

                <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg shadow transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M12 12v9m0 0l-3.5-3.5M12 21l3.5-3.5M12 3v9" />
                    </svg>
                    Download CSV
                </button>
            </form>

            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                <table id="visimisiTable" class="display min-w-full bg-white border border-gray-500">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border">Nama User</th>
                            <th class="px-4 py-2 border">Visi</th>
                            <th class="px-4 py-2 border">Misi</th>
                            <th class="px-4 py-2 border">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($visimisi as $data)
                            <tr>
                                <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border">{{ $data->nama_user }}</td>
                                <td class="px-4 py-2 border">{{ $data->visi }}</td>
                                <td class="px-4 py-2 border">{{ $data->misi }}</td>
                                <td class="px-4 py-2 border">{{ $data->deskripsi }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


                @if($visimisi->isEmpty())
                    <p class="text-center text-gray-500 mt-4">Tidak ada pengguna yang terdaftar.</p>
                @endif
            </div>
        </div>
    </div>
    <div class="py-4">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                <h3 class="text-lg font-bold mb-3">Komentar</h3>
                <ul>
                    @if($komentar->isNotEmpty())
                        @foreach($komentar as $komentar)
                            <li class="mb-2">
                                <p class="text-sm">Prodi: {{ $komentar->user->name }}</p>
                                <p class="text-sm">Komentar: {{ $komentar->komentar }}</p>
                                <p class="text-sm">Ditambahkan pada: {{ $komentar->created_at }}</p>
                                <hr>
                            </li>
                        @endforeach
                    @else
                        <p class="text-center text-gray-500 mt-4">Belum ada komentar.</p>
                    @endif
                </ul>

                <form action="{{ route('admin.komentar') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" hidden name="nama_tabel" value="{{ $tabel }}">
                        <select name="prodi_id" id="">
                            <option value="">Pilih Prodi</option>
                            @foreach($prodi as $prodi)
                                <option value="{{ $prodi->id }}">{{ $prodi->name }}</option>
                            @endforeach
                        </select>
                        <label for="komentar" class="form-label">Komentar:</label>
                        <textarea class="form-control" id="komentar" name="komentar" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </form>
            </div>

        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#visimisiTable').DataTable({
                responsive: true,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Selanjutnya"
                    }
                }
            });
        });
    </script>

</x-app-layout>