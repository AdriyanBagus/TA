<x-app-layout>
    <x-slot name="header">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Profil Tenaga Kependidikan') }}
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
                            <th class="px-2 py-2 border">No</th>
                            <th class="px-4 py-2 border">Nama</th>
                            <th class="px-4 py-2 border">NIPY</th>
                            <th class="px-4 py-2 border">Kualifikasi Pendidikan</th>
                            <th class="px-4 py-2 border">Jabatan</th>
                            <th class="px-4 py-2 border">Kesesuaian Bidang Kerja</th>
                            <th class="px-4 py-2 border">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($profil_tenaga_kependidikan as $profiltenagakependidikan)
                            <tr>
                                <td class="px-1 py-2 border">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border">{{ $profiltenagakependidikan->nama }}</td>
                                <td class="px-4 py-2 border">{{ $profiltenagakependidikan->nipy }}</td>
                                <td class="px-4 py-2 border">{{ $profiltenagakependidikan->kualifikasi_pendidikan }}</td>
                                <td class="px-4 py-2 border">{{ $profiltenagakependidikan->jabatan }}</td>
                                <td class="px-4 py-2 border">{{ $profiltenagakependidikan->kesesuaian_bidang_kerja }}</td>
                                <td class="px-1 py-3 border flex flex-col items-center space-y-2">
                                    <button 
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $profiltenagakependidikan->id }}">
                                        Edit
                                    </button>

                                    <!-- Tombol Delete -->
                                    <form action="" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                        {{-- @csrf
                                        @method('DELETE') --}}
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="exampleModal{{ $profiltenagakependidikan->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah Ketersediaan Dokumen</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('pages.profil_tenaga_kependidikan.update', $profiltenagakependidikan->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" hidden name="id" value="{{ $profiltenagakependidikan->id }}">
            
                                                <div class="mb-3">
                                                    <label for="nama" class="form-label">Nama:</label>
                                                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $profiltenagakependidikan->nama }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nipy" class="form-label">NIPY:</label>
                                                    <input type="text" class="form-control" id="nipy" name="nipy" value="{{ $profiltenagakependidikan->nipy }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="kualifikasi_pendidikan" class="form-label">Kualifikasi Pendidikan:</label>
                                                    <input type="text" class="form-control" id="kualifikasi_pendidikan" name="kualifikasi_pendidikan" value="{{ $profiltenagakependidikan->kualifikasi_pendidikan }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jabatan" class="form-label">Jabatan:</label>
                                                    <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ $profiltenagakependidikan->jabatan }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Kesesuaian Bidang Kerja</label>
                                                    <select class="form-control" name="kesesuaian_bidang_kerja" value="{{ $profiltenagakependidikan->kesesuaian_bidang_kerja }}">
                                                      <option value="Ya" {{ old('kesesuaian_bidang_kerja') == 'Ya' ? 'selected' : '' }}>Ya</option>
                                                      <option value="Tidak" {{ old('kesesuaian_bidang_kerja') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                                    </select>
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
                                <h5 class="modal-title" id="exampleModalLabel">New Message</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('pages.profil_tenaga_kependidikan.add') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama:</label>
                                        <input type="text" class="form-control" id="nama" name="nama" value="{{ session('nama') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nipy" class="form-label">NIPY:</label>
                                        <input type="text" class="form-control" id="nipy" name="nipy" value="{{ session('nipy') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kualifikasi_pendidikan" class="form-label">Kualifikasi Pendidikan:</label>
                                        <input type="text" class="form-control" id="kualifikasi_pendidikan" name="kualifikasi_pendidikan" value="{{ session('kualifikasi_pendidikan') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jabatan" class="form-label">Jabatan:</label>
                                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ session('jabatan') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Kesesuaian Bidang Kerja</label>
                                        <select class="form-control" name="kesesuaian_bidang_kerja" >
                                          <option value="Ya" {{ old('kesesuaian_bidang_kerja') == 'Ya' ? 'selected' : '' }}>Ya</option>
                                          <option value="Tidak" {{ old('kesesuaian_bidang_kerja') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
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

                @if($profil_tenaga_kependidikan->isEmpty())
                    <p class="text-center text-gray-500 mt-4">Data tidak ada.</p>
                @endif
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
</x-app-layout>