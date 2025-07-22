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
                    {{ __('Beban Kinerja Dosen') }}
                </h2>
            </div>

            <div class="flex items-center space-x-4 mt-4">
                {{-- Dropdown Filter Tahun Akademik --}}
                <form method="GET" action="{{ route('pages.beban_kinerja_dosen') }}"
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
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                <table id="bebanKinerjaTable" class="min-w-full bg-white border border-gray-500 border-collapse">
                    <thead>
                        <tr>
                            <th class="border px-2 py-2 text-sm">No</th>
                            <th class="border px-4 py-2 text-sm">Nama</th>
                            <th class="border px-4 py-2 text-sm">NIDN</th>
                            <th class="border px-4 py-2 text-sm">Prodi Sendiri</th>
                            <th class="border px-4 py-2 text-sm">Prodi Lain</th>
                            <th class="border px-4 py-2 text-sm">Prodi Diluar PT</th>
                            <th class="border px-4 py-2 text-sm">Penelitian</th>
                            <th class="border px-4 py-2 text-sm">PKM</th>
                            <th class="border px-4 py-2 text-sm">Penunjang</th>
                            <th class="border px-4 py-2 text-sm">Jumlah SKS</th>
                            <th class="border px-4 py-2 text-sm">Rata-rata SKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($beban_kinerja_dosen as $bebankinerjadosen)
                            <tr>
                                <td class="border text-sm px-1 py-2">{{ $loop->iteration }}</td>
                                <td class="border text-sm px-4 py-2">{{ $bebankinerjadosen->nama }}</td>
                                <td class="border text-sm px-4 py-2">{{ $bebankinerjadosen->nidn }}</td>
                                <td class="border text-sm px-4 py-2">
                                    {{ number_format($bebankinerjadosen->ps_sendiri, 4) + 0 }}</td>
                                <td class="border text-sm px-4 py-2">
                                    {{ number_format($bebankinerjadosen->ps_lain, 4) + 0 }}</td>
                                <td class="border text-sm px-4 py-2">
                                    {{ number_format($bebankinerjadosen->ps_diluar_pt, 4) + 0 }}</td>
                                <td class="border text-sm px-4 py-2">
                                    {{ number_format($bebankinerjadosen->penelitian, 4) + 0 }}</td>
                                <td class="border text-sm px-4 py-2">
                                    {{ number_format($bebankinerjadosen->pkm, 4) + 0 }}</td>
                                <td class="border text-sm px-4 py-2">
                                    {{ number_format($bebankinerjadosen->penunjang, 4) + 0 }}</td>
                                <td class="border text-sm px-4 py-2">
                                    {{ number_format($bebankinerjadosen->jumlah_sks, 4) + 0 }}</td>
                                <td class="border text-sm px-4 py-2">
                                    {{ number_format($bebankinerjadosen->rata_rata_sks, 4) + 0 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


                @if ($beban_kinerja_dosen->isEmpty())
                    <p class="text-center text-gray-500 mt-4">Tidak ada data yang diinput.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Komentar --}}
    {{-- <div class="py-4">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                <h3 class="text-lg font-bold mb-3">Komentar</h3>
                <ul>
                    @if ($komentar->isNotEmpty())
                        @foreach ($komentar as $item)
                            <li class="mb-4 p-3 border rounded-md shadow-sm">
                                <div class="flex items-center mb-1">
                                    <div class=" bg-gray-500 rounded-full mr-2" style="width: 40px; height: 40px"></div>
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
    </div> --}}
    <div class="py-4">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                <h3 class="text-lg font-bold mb-3">Komentar</h3>
                <ul>
                    @if ($komentar->isNotEmpty())
                        @foreach ($komentar as $komentar)
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

                <form action="{{ route('pages.komentar') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" hidden name="nama_tabel" value="{{ $tabel }}">
                        <select name="prodi_id" id="">
                            <option value="">Pilih Dosen</option>
                            @foreach ($dosen as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
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
        document.getElementById('exampleModal').addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; // Button yang memicu modal
            const modalTitle = this.querySelector('.modal-title');
            const modalBodyInput = this.querySelector('.modal-body input');

            modalTitle.textContent = 'Tambah Beban Kinerja Dosen ';
            // modalBodyInput.value = recipient;
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#bebanKinerjaTable').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50, 100],
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    }
                }
            });
        });
    </script>
</x-app-layout>
