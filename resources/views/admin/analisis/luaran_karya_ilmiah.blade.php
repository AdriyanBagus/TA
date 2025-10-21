<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Luaran Karya Ilmiah') }}
            </h2>

            {{-- Dropdown Filter Tahun Akademik --}}
            <form method="GET" action="{{ route('luaran_karya_ilmiah') }}"
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

    <div class="py-12">
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                <table class="min-w-full bg-white border border-gray-500">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border">
                                <a
                                    href="{{ route('luaran_karya_ilmiah', ['sort_by' => 'nama_user', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc']) }}">
                                    Nama Prodi
                                </a>
                            </th>
                            <th class="px-4 py-2 border">
                                <a
                                    href="{{ route('luaran_karya_ilmiah', ['sort_by' => 'judul_kegiatan', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc']) }}">
                                    Judul Kegiatan
                                </a>
                            </th>
                            <th class="px-4 py-2 border">
                                <a
                                    href="{{ route('luaran_karya_ilmiah', ['sort_by' => 'judul_karya', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc']) }}">
                                    Judul Karya
                                </a>
                            </th>
                            <th class="px-4 py-2 border">
                                <a
                                    href="{{ route('luaran_karya_ilmiah', ['sort_by' => 'pencipta_utama', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc']) }}">
                                    Pencipta Utama
                                </a>
                            </th>
                            <th class="px-4 py-2 border">
                                <a
                                    href="{{ route('luaran_karya_ilmiah', ['sort_by' => 'jenis', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc']) }}">
                                    Jenis
                                </a>
                            </th>
                            <th class="px-4 py-2 border">
                                <a
                                    href="{{ route('luaran_karya_ilmiah', ['sort_by' => 'nomor_karya', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc']) }}">
                                    Nomor Karya
                                </a>
                            </th>
                            <th class="px-4 py-2 border">
                                <a
                                    href="{{ route('luaran_karya_ilmiah', ['sort_by' => 'url', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc']) }}">
                                    URL
                                </a>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($luaran_karya_ilmiah as $data)
                            <tr>
                                <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border">{{ $data->nama_user }}</td>
                                <td class="px-4 py-2 border">{{ $data->judul_kegiatan }}</td>
                                <td class="px-4 py-2 border">{{ $data->judul_karya }}</td>
                                <td class="px-4 py-2 border">{{ $data->pencipta_utama }}</td>
                                <td class="px-4 py-2 border">{{ $data->jenis }}</td>
                                <td class="px-4 py-2 border">{{ $data->nomor_karya }}</td>
                                <td class="px-1 py-2 border text-sm">
                                    <a href="{{ $data->url }}" target="_blank"
                                        class="text-blue-500 hover:underline">
                                        Link
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($luaran_karya_ilmiah->isEmpty())
                    <p class="text-center text-gray-500 mt-4">Tidak ada pengguna yang terdaftar.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>