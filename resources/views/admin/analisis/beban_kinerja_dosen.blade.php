<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Beban Kinerja Dosen') }}
            </h2>

            {{-- Dropdown Filter Tahun Akademik --}}
            <form method="GET" action="{{ route('beban_kinerja_dosen') }}"
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
    </x-slot>


    <div class="py-4">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                <table class="min-w-full bg-white border border-gray-500">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border">
                                <a
                                    href="{{ route('beban_kinerja_dosen', ['sort_by' => 'nama_user', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc']) }}">Nama
                                    Prodi</a>
                            </th>
                            <th class="px-4 py-2 border">
                                <a
                                    href="{{ route('beban_kinerja_dosen', ['sort_by' => 'visi', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc']) }}">Nama</a>
                            </th>
                            <th class="px-4 py-2 border">
                                <a
                                    href="{{ route('beban_kinerja_dosen', ['sort_by' => 'misi', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc']) }}">NIDN</a>
                            </th>
                            <th class="px-4 py-2 border">
                                <a
                                    href="{{ route('beban_kinerja_dosen', ['sort_by' => 'misi', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc']) }}">Prodi
                                    Sendiri</a>
                            </th>
                            <th class="px-4 py-2 border">
                                <a
                                    href="{{ route('beban_kinerja_dosen', ['sort_by' => 'misi', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc']) }}">Prodi
                                    Lain</a>
                            </th>
                            <th class="px-4 py-2 border">
                                <a
                                    href="{{ route('beban_kinerja_dosen', ['sort_by' => 'misi', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc']) }}">Prodi
                                    diluar PT</a>
                            </th>
                            <th class="px-4 py-2 border">
                                <a
                                    href="{{ route('beban_kinerja_dosen', ['sort_by' => 'misi', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc']) }}">Penelitian</a>
                            </th>
                            <th class="px-4 py-2 border">
                                <a
                                    href="{{ route('beban_kinerja_dosen', ['sort_by' => 'misi', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc']) }}">PKM
                                </a>
                            </th>
                            <th class="px-4 py-2 border">
                                <a
                                    href="{{ route('beban_kinerja_dosen', ['sort_by' => 'misi', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc']) }}">Penunjang
                                </a>
                            </th>
                            <th class="px-4 py-2 border">
                                <a
                                    href="{{ route('beban_kinerja_dosen', ['sort_by' => 'misi', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc']) }}">Jumlah
                                    SKS </a>
                            </th>
                            <th class="px-4 py-2 border">
                                <a
                                    href="{{ route('beban_kinerja_dosen', ['sort_by' => 'misi', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc']) }}">Rata-rata
                                    SKS </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($beban_kinerja_dosen as $data)
                            <tr>
                                <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border">{{ $data->nama_user }}</td>
                                <td class="px-4 py-2 border">{{ $data->nama }}</td>
                                <td class="px-4 py-2 border">{{ $data->nidn }}</td>
                                <td class="px-4 py-2 border">{{ $data->ps_sendiri }}</td>
                                <td class="px-4 py-2 border">{{ $data->ps_lain }}</td>
                                <td class="px-4 py-2 border">{{ $data->ps_diluar_pt }}</td>
                                <td class="px-4 py-2 border">{{ $data->penelitian }}</td>
                                <td class="px-4 py-2 border">{{ $data->pkm }}</td>
                                <td class="px-4 py-2 border">{{ $data->penunjang }}</td>
                                <td class="px-4 py-2 border">{{ $data->jumlah_sks }}</td>
                                <td class="px-4 py-2 border">{{ $data->rata_rata_sks }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($beban_kinerja_dosen->isEmpty())
                    <p class="text-center text-gray-500 mt-4">Tidak ada pengguna yang terdaftar.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
