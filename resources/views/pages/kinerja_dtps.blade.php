<x-app-layout>
    <x-slot name="header">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kinerja DTPS') }}
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
                            <th class="px-4 py-2 border">Nama Dosen</th>
                            <th class="px-4 py-2 border">NIDN</th>
                            <th class="px-4 py-2 border">Jenis Rekognisi</th>
                            <th class="px-4 py-2 border">Nama Kegiatan</th>
                            <th class="px-4 py-2 border">Tingkat</th>
                            <th class="px-4 py-2 border">Tahun Perolehan</th>
                            <th class="px-4 py-2 border">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kinerja_dtps as $kinerjadtps)
                            <tr>
                                <td class="px-1 py-2 border">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border">{{ $kinerjadtps->nama_dosen }}</td>
                                <td class="px-4 py-2 border">{{ $kinerjadtps->nidn }}</td>
                                <td class="px-4 py-2 border">{{ $kinerjadtps->jenis_rekognisi }}</td>
                                <td class="px-4 py-2 border">{{ $kinerjadtps->nama_kegiatan }}</td>
                                <td class="px-4 py-2 border">{{ $kinerjadtps->tingkat }}</td>
                                <td class="px-4 py-2 border">{{ $kinerjadtps->tahun_perolehan }}</td>
                                <td class="px-1 py-3 border flex flex-col items-center space-y-2">
                                    <!-- Tombol Edit -->
                                    <button 
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $kinerjadtps->id }}">
                                        Edit
                                </button>

                                    <!-- Tombol Delete -->
                                    <form action="" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="exampleModal{{ $kinerjadtps->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">New Message</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('pages.kinerja_dtps.update', $kinerjadtps->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" hidden name="id" value="{{ $kinerjadtps->id }}">
            
                                                <div class="mb-3">
                                                    <label for="nama_dosen" class="form-label">Nama Dosen:</label>
                                                    <input type="text" class="form-control" id="nama_dosen" name="nama_dosen" value="{{ $kinerjadtps->nama_dosen }}" required>
                                                </div>
                                                <div class="mb-3">
                                                  <label for="nidn" class="form-label">NIDN:</label>
                                                  <input type="text" class="form-control" id="nidn" name="nidn" value="{{ $kinerjadtps->nidn }}" required>
                                              </div>
                                              <div class="mb-3">
                                                  <label for="jenis_rekognisi" class="form-label">Jenis Rekognisi:</label>
                                                  <input type="text" class="form-control" id="jenis_rekognisi" name="jenis_rekognisi" value="{{ $kinerjadtps->jenis_rekognisi }}" required>
                                              </div>
                                              <div class="mb-3">
                                                  <label for="nama_kegiatan" class="form-label">Nama Kegiatan:</label>
                                                  <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" value="{{ $kinerjadtps->nama_kegiatan }}" required>
                                              </div>
                                              <div class="form-group">
                                                    <label>Tingkat</label>
                                                    <select class="form-control" name="tingkat" value="{{ $kinerjadtps->tingkat }}">
                                                      <option value="Internasional" {{ old('tingkat') == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                                                      <option value="Nasional" {{ old('tingkat') == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                                      <option value="Lokal/Wilayah" {{ old('tingkat') == 'Lokal' ? 'selected' : '' }}>Lokal/Wilayah</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tahun_perolehan" class="form-label">Tahun Perolehan:</label>
                                                    <input type="text" class="form-control" id="tahun_perolehan" name="tahun_perolehan" value="{{ $kinerjadtps->tahun_perolehan }}" required>
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
                                <form action="{{ route('pages.kinerja_dtps.add') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="nama_dosen" class="form-label">Nama Dosen:</label>
                                        <input type="text" class="form-control" id="nama_dosen" name="nama_dosen" value="{{ session('nama_dosen') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nidn" class="form-label">NIDN:</label>
                                        <input type="text" class="form-control" id="nidn" name="nidn" value="{{ session('nidn') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jenis_rekognisi" class="form-label">Jenis Rekognisi:</label>
                                        <input type="text" class="form-control" id="jenis_rekognisi" name="jenis_rekognisi" value="{{ session('jenis_rekognisi') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama_kegiatan" class="form-label">Nama Kegiatan:</label>
                                        <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" value="{{ session('nama_kegiatan') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Tingkat</label>
                                        <select class="form-control" name="tingkat">
                                          <option value="Internasional" {{ old('tingkat') == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                                          <option value="Nasional" {{ old('tingkat') == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                          <option value="Lokal/Wilayah" {{ old('tingkat') == 'Lokal' ? 'selected' : '' }}>Lokal/Wilayah</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tahun_perolehan" class="form-label">Tahun Perolehan:</label>
                                        <input type="text" class="form-control" id="tahun_perolehan" name="tahun_perolehan" value="{{ session('tahun_perolehan') }}" required>
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

                @if($kinerja_dtps->isEmpty())
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
    </script>
</x-app-layout>