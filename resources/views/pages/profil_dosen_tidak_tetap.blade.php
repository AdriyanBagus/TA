<x-app-layout>
    <x-slot name="header">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Profil Dosen Tidak Tetap') }}
            </h2>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Tambah
            </button>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                <table class="min-w-full bg-white border border-gray-500">
                    <thead>
                        <tr>
                            <th class="px-1 py-2 border">No</th>
                            <th class="px-4 py-2 border">Nama</th>
                            <th class="px-4 py-2 border">Asal Instansi</th>
                            <th class="px-4 py-2 border">Kualifikasi Pendidikan</th>
                            <th class="px-4 py-2 border">Sertifikasi Profesional</th>
                            <th class="px-4 py-2 border">Sertifikat Kompetensi</th>
                            <th class="px-4 py-2 border">Bidang Keahlian</th>
                            <th class="px-4 py-2 border">Bidang Ilmu Prodi</th>
                            <th class="px-1 py-2 border">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($profil_dosen_tidak_tetap as $profildosentidaktetap)
                            <tr>
                                <td class="px-1 py-2 border">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border">{{ $profildosentidaktetap->nama }}</td>
                                <td class="px-4 py-2 border">{{ $profildosentidaktetap->asal_instansi }}</td>
                                <td class="px-4 py-2 border">{{ $profildosentidaktetap->kualifikasi_pendidikan }}</td>
                                <td class="px-4 py-2 border">{{ $profildosentidaktetap->sertifikasi_pendidik_profesional }}</td>
                                <td class="px-4 py-2 border">{{ $profildosentidaktetap->sertifikat_kompetensi }}</td>
                                <td class="px-4 py-2 border">{{ $profildosentidaktetap->bidang_keahlian }}</td>
                                <td class="px-4 py-2 border">{{ $profildosentidaktetap->kesesuaian_bidang_ilmu_prodi }}</td>
                                <td class="px-1 py-3 border flex flex-col items-center space-y-2">
                                    <!-- Tombol Edit -->
                                    <button 
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $profildosentidaktetap->id }}">
                                        Edit
                                    </button>

                                    <!-- Tombol Delete -->
                                    <form action="{{ route('pages.profil_dosen_tidak_tetap.destroy', $profildosentidaktetap->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="exampleModal{{ $profildosentidaktetap->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Profil Dosen</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('pages.profil_dosen_tidak_tetap.update', $profildosentidaktetap->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" hidden name="id" value="{{ $profildosentidaktetap->id }}">
            
                                                <div class="mb-3">
                                                    <label for="nama" class="form-label">Nama:</label>
                                                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $profildosentidaktetap->nama }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="asal_instansi" class="form-label">Asal Instansi:</label>
                                                    <input type="text" class="form-control" id="asal_instansi" name="asal_instansi" value="{{ $profildosentidaktetap->asal_instansi }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="kualifikasi_pendidikan" class="form-label">Kualifikasi Pendidikan:</label>
                                                    <input type="text" class="form-control" id="kualifikasi_pendidikan" name="kualifikasi_pendidikan" value="{{ $profildosentidaktetap->kualifikasi_pendidikan }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="sertifikasi_pendidik_profesional" class="form-label">Sertifikasi Profesional:</label>
                                                    <input type="text" class="form-control" id="sertifikasi_pendidik_profesional" name="sertifikasi_pendidik_profesional" value="{{ $profildosentidaktetap->sertifikasi_pendidik_profesional }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="sertifikat_kompetensi" class="form-label">Sertifikat Kompetensi:</label>
                                                    <input type="text" class="form-control" id="sertifikat_kompetensi" name="sertifikat_kompetensi" value="{{ $profildosentidaktetap->sertifikat_kompetensi }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="bidang_keahlian" class="form-label">Bidang Keahlian:</label>
                                                    <input type="text" class="form-control" id="bidang_keahlian" name="bidang_keahlian" value="{{ $profildosentidaktetap->bidang_keahlian }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="kesesuaian_bidang_ilmu_prodi" class="form-label">Bidang Ilmu Prodi:</label>
                                                    <input type="text" class="form-control" id="kesesuaian_bidang_ilmu_prodi" name="kesesuaian_bidang_ilmu_prodi" value="{{ $profildosentidaktetap->kesesuaian_bidang_ilmu_prodi }}">
                                                </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Profil Dosen</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('pages.profil_dosen_tidak_tetap.add') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama:</label>
                                        <input type="text" class="form-control" id="nama" name="nama" value="{{ session('nama') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="asal_instansi" class="form-label">Asal Instansi:</label>
                                        <input type="text" class="form-control" id="asal_instansi" name="asal_instansi" value="{{ session('asal_instansi') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="kualifikasi_pendidikan" class="form-label">Kualifikasi Pendidikan:</label>
                                        <input type="text" class="form-control" id="kualifikasi_pendidikan" name="kualifikasi_pendidikan" value="{{ session('kualifikasi_pendidikan') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="sertifikasi_pendidik_profesional" class="form-label">Sertifikasi Profesional:</label>
                                        <input type="text" class="form-control" id="sertifikasi_pendidik_profesional" name="sertifikasi_pendidik_profesional" value="{{ session('sertifikasi_pendidik_profesional') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="sertifikat_kompetensi" class="form-label">Sertifikat Kompetensi:</label>
                                        <input type="text" class="form-control" id="sertifikat_kompetensi" name="sertifikat_kompetensi" value="{{ session('sertifikat_kompetensi') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="bidang_keahlian" class="form-label">Bidang Keahlian:</label>
                                        <input type="text" class="form-control" id="bidang_keahlian" name="bidang_keahlian" value="{{ session('bidang_keahlian') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="kesesuaian_bidang_ilmu_prodi" class="form-label">Bidang Ilmu Prodi:</label>
                                        <input type="text" class="form-control" id="kesesuaian_bidang_ilmu_prodi" name="kesesuaian_bidang_ilmu_prodi" value="{{ session('kesesuaian_bidang_ilmu_prodi') }}">
                                    </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                  </div>   
                  {{-- End Modal --}}

                @if($profil_dosen_tidak_tetap->isEmpty())
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
    </div>
    <script>
        document.getElementById('exampleModal').addEventListener('show.bs.modal', function (event) {
         const button = event.relatedTarget; // Button yang memicu modal
         const recipient = button.getAttribute('data-whatever'); // Ambil data dari button
         const modalTitle = this.querySelector('.modal-title');
         const modalBodyInput = this.querySelector('.modal-body input');
     
         modalTitle.textContent = 'Tambah Visi Misi ';
         // modalBodyInput.value = recipient;
        });
    </script>
</x-app-layout>
