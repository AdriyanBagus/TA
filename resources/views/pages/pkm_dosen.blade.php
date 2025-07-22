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
                    {{ __('PKM Dosen') }}
                </h2>
            </div>

            <div class="flex items-center space-x-4 mt-4">
                {{-- Dropdown Filter Tahun Akademik --}}
                <form method="GET" action="{{ route('pages.pkm_dosen') }}"
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
                    <a href="{{ route('pages.pkm_dosen.export') }}" class="btn btn-success btn-sm"
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
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-2">
                <table id="pkmTable" class="min-w-full bg-white border border-gray-500">
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
                            <th class="px-4 py-2 border text-xs">Url</th>
                            <th class="px-4 py-2 border text-xs">Roadmap</th>
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
                                <td class="px-4 py-2 border text-sm">
                                    {{ 'Rp. ' . number_format($pkmdosen->jumlah_dana, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-2 border text-xs">{{ $pkmdosen->bentuk_integrasi }}</td>
                                <td class="px-4 py-2 border text-xs">{{ $pkmdosen->mata_kuliah }}</td>
                                <td class="px-4 py-2 border text-xs">
                                    <a href="{{ $pkmdosen->url }}" target="_blank"
                                        class="text-blue-500 hover:text-blue-700 underline">Link</a>
                                </td>
                                <td class="px-4 py-2 border text-xs text-center">
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
                                        <span class="badge bg-secondary text-white cursor-pointer"
                                            onclick="openValidasiRoadmapModal('{{ $pkmdosen->id }}')">Pilih</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="modal fade" id="validasiRoadmapModal" tabindex="-1"
                    aria-labelledby="validasiRoadmapModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="" id="validasiForm">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Validasi Kesesuaian Roadmap</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <input type="hidden" name="id" id="pkm_id">

                                    <div class="mb-3">
                                        <label for="kesesuaian_roadmap" class="form-label">Pilih Kesesuaian:</label>
                                        <select name="kesesuaian_roadmap" id="kesesuaian_roadmap" class="form-select"
                                            required>
                                            <option value="Sesuai">Sesuai</option>
                                            <option value="Kurang Sesuai">Kurang Sesuai</option>
                                            <option value="Tidak Sesuai">Tidak Sesuai</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Validasi</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
        $(document).ready(function() {
            $('#pkmTable').DataTable({
                pageLength: 5,
                scrollX: true,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Berikutnya"
                    }
                }
            });
        });
    </script>
    <script>
        function openValidasiRoadmapModal(id, currentValue = '') {
            const modal = new bootstrap.Modal(document.getElementById('validasiRoadmapModal'));
            document.getElementById('validasiForm').action = `/pkmdosen/${id}/validasi`;
            document.getElementById('pkm_id').value = id;
            document.getElementById('kesesuaian_roadmap').value = currentValue;
            modal.show();
        }
    </script>
</x-app-layout>
