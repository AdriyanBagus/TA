<x-app-layout>
    <x-slot name="header">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Profil Dosen') }}
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
                        <th class="px-1 py-2 border text-sm">No</th>
                        <th class="px-4 py-2 border text-sm">Nama</th>
                        <th class="px-4 py-2 border text-sm">NIDN</th>
                        <th class="px-4 py-2 border text-sm">Kualifikasi Pendidikan</th>
                        <th class="px-4 py-2 border text-sm">Sertifikasi Profesional</th>
                        <th class="px-4 py-2 border text-sm">Bidang Keahlian</th>
                        <th class="px-4 py-2 border text-sm">Bidang Ilmu Prodi</th>
                        <th class="px-1 py-2 border text-sm">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($profil_dosen as $profildosen)
                            <tr>
                                <td class="px-1 py-2 border text-sm">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $profildosen->nama }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $profildosen->nidn }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $profildosen->kualifikasi_pendidikan }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $profildosen->sertifikasi_pendidik_profesional }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $profildosen->bidang_keahlian }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $profildosen->bidang_ilmu_prodi }}</td>
                                <td class="px-1 py-3 border flex flex-col items-center space-y-2">
                                    <!-- Tombol Edit -->
                                    <button 
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $profildosen->id }}">
                                        Edit
                                    </button>

                                    <!-- Tombol Delete -->
                                    <form action="{{ route('pages.profil_dosen.destroy', $profildosen->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="exampleModal{{ $profildosen->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Profil Dosen</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('pages.profil_dosen.update', $profildosen->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" hidden name="id" value="{{ $profildosen->id }}">
            
                                                <div class="mb-3">
                                                    <label for="nama" class="form-label">Visi:</label>
                                                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $profildosen->nama }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nidn" class="form-label">NIDN:</label>
                                                    <input type="text" class="form-control" id="nidn" name="nidn" value="{{ $profildosen->nidn }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="kualifikasi_pendidikan" class="form-label">Kualifikasi Pendidikan:</label>
                                                    <input type="text" class="form-control" id="kualifikasi_pendidikan" name="kualifikasi_pendidikan" value="{{ $profildosen->kualifikasi_pendidikan }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="sertifikasi_pendidik_profesional" class="form-label">Sertifikasi Profesional:</label>
                                                    <select class="form-control" id="sertifikasi_pendidik_profesional" name="sertifikasi_pendidik_profesional" required>
                                                        <option value="Ya" {{ $profildosen->sertifikasi_pendidik_profesional == 'Ya' ? 'selected' : '' }}>Ya</option>
                                                        <option value="Tidak" {{ $profildosen->sertifikasi_pendidik_profesional == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="bidang_keahlian" class="form-label">Bidang Keahlian:</label>
                                                    <input type="text" class="form-control" id="bidang_keahlian" name="bidang_keahlian" value="{{ $profildosen->bidang_keahlian }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="bidang_ilmu_prodi" class="form-label">Bidang Ilmu Prodi:</label>
                                                    <input type="text" class="form-control" id="bidang_ilmu_prodi" name="bidang_ilmu_prodi" value="{{ $profildosen->bidang_ilmu_prodi }}" required>
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
                                <form action="{{ route('pages.profil_dosen.add') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama:</label>
                                        <input type="text" class="form-control" id="nama" name="nama" value="{{ session('nama') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nidn" class="form-label">NIDN:</label>
                                        <input type="text" class="form-control" id="nidn" name="nidn" value="{{session('nidn') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kualifikasi_pendidikan" class="form-label">Kualifikasi Pendidikan:</label>
                                        <input type="text" class="form-control" id="kualifikasi_pendidikan" name="kualifikasi_pendidikan" value="{{ session('kualifikasi_pendidikan') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="sertifikasi_pendidik_profesional" class="form-label">Sertifikasi Profesional:</label>
                                        <select class="form-control" id="sertifikasi_pendidik_profesional" name="sertifikasi_pendidik_profesional" required>
                                            <option value="Ya" {{ session('sertifikasi_pendidik_profesional') == 'Ya' ? 'selected' : '' }}>Ya</option>
                                            <option value="Tidak" {{ session('sertifikasi_pendidik_profesional') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="bidang_keahlian" class="form-label">Bidang Keahlian:</label>
                                        <input type="text" class="form-control" id="bidang_keahlian" name="bidang_keahlian" value="{{ session('bidang_keahlian') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="bidang_ilmu_prodi" class="form-label">Bidang Ilmu Prodi:</label>
                                        <input type="text" class="form-control" id="bidang_ilmu_prodi" name="bidang_ilmu_prodi" value="{{ session('bidang_ilmu_prodi') }}" required>
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

                @if($profil_dosen->isEmpty())
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
     
         modalTitle.textContent = 'Tambah Profil Dosen';
         // modalBodyInput.value = recipient;
        });
    </script>
</x-app-layout>