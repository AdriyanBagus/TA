<x-app-layout>
    <x-slot name="header">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Publikasi Karya Ilmiah PKM') }}
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
                            <th class="px-2 py-2 border text-xs">No</th>
                            <th class="px-4 py-2 border text-xs">Judul Penelitian</th>
                            <th class="px-4 py-2 border text-xs">Judul Publikasi</th>
                            <th class="px-4 py-2 border text-xs">Dosen</th>
                            <th class="px-4 py-2 border text-xs">Mahasiswa</th>
                            <th class="px-4 py-2 border text-xs">Dipublikasikan</th>
                            <th class="px-4 py-2 border text-xs">Penerbit</th>
                            <th class="px-4 py-2 border text-xs">Jenis</th>
                            <th class="px-4 py-2 border text-xs">Tingkat</th>
                            <th class="px-4 py-2 border text-xs">Penyusun</th>
                            <th class="px-4 py-2 border text-xs">Status</th>
                            <th class="px-4 py-2 border text-xs">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($publikasi_karya_ilmiah_pkm as $publikasi)
                            <tr>
                                <td class="px-1 py-2 border text-xs">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border text-xs">{{ $publikasi->judul_penelitian }}</td>
                                <td class="px-4 py-2 border text-xs">{{ $publikasi->judul_publikasi }}</td>
                                <td class="px-4 py-2 border text-xs">{{ $publikasi->dosen }}</td>
                                <td class="px-4 py-2 border text-xs">{!! nl2br(e($publikasi->mahasiswa)) !!}</td>
                                <td class="px-4 py-2 border text-xs">{{ $publikasi->dipublikasikan }}</td>
                                <td class="px-4 py-2 border text-xs">{{ $publikasi->penerbit }}</td>
                                <td class="px-4 py-2 border text-xs">{{ $publikasi->jenis }}</td>
                                <td class="px-4 py-2 border text-xs">{{ $publikasi->tingkat }}</td>
                                <td class="px-4 py-2 border text-xs">{{ $publikasi->penyusun }}</td>
                                <td class="px-4 py-2 border text-xs">{{ $publikasi->status }}</td>
                                <td class="px-1 py-3 border flex flex-col items-center space-y-2">
                                    <!-- Tombol Edit -->
                                    <button 
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $publikasi->id }}">
                                        Edit
                                </button>

                                    <!-- Tombol Delete -->
                                    <form action="{{ route('pages.publikasi_karya_ilmiah_pkm.destroy', $publikasi->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="exampleModal{{ $publikasi->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Publikasi Karya Ilmiah</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('pages.publikasi_karya_ilmiah_pkm.update', $publikasi->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" hidden name="id" value="{{ $publikasi->id }}">
            
                                                <div class="mb-3">
                                                    <label for="judul_penelitian" class="form-label">Judul Penelitian:</label>
                                                    <input type="text" class="form-control" id="judul_penelitian" name="judul_penelitian" value="{{ $publikasi->judul_penelitian }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="judul_publikasi" class="form-label">Judul Publikasi:</label>
                                                    <input type="text" class="form-control" id="judul_publikasi" name="judul_publikasi" value="{{ $publikasi->judul_publikasi }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="dosen" class="form-label">Nama Dosen:</label>
                                                    <textarea class="form-control" id="dosen" name="dosen" required>{{  $publikasi->dosen }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="mahasiswa" class="form-label">Mahasiswa:</label>
                                                    <textarea class="form-control" id="mahasiswa" name="mahasiswa" required>{{  $publikasi->mahasiswa }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="dipublikasikan" class="form-label">Dipublikasikan Pada:</label>
                                                    <input type="text" class="form-control" id="dipublikasikan" name="dipublikasikan" value="{{ $publikasi->dipublikasikan }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="penerbit" class="form-label">Penerbit:</label>
                                                    <input type="text" class="form-control" id="penerbit" name="penerbit" value="{{ $publikasi->penerbit }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jenis" class="form-label">jenis:</label>
                                                    <input type="text" class="form-control" id="jenis" name="jenis" value="{{ $publikasi->jenis }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Tingkat:</label>
                                                    <select class="form-control" name="tingkat" value="{{ $publikasi->tingkat }}">
                                                      <option value="internasional" {{ old('tingkat') == 'internasional' ? 'selected' : '' }}>Internasional</option>
                                                      <option value="nasional" {{ old('tingkat') == 'nasional' ? 'selected' : '' }}>Nasional</option>
                                                      <option value="lokal" {{ old('tingkat') == 'lokal' ? 'selected' : '' }}>Lokal/Wilayah</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Penyusun Utama:</label>
                                                    <select class="form-control" name="penyusun" value="{{ $publikasi->penyusun }}">
                                                      <option value="dosen" {{ old('penyusun') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                                                      <option value="mahasiswa" {{ old('penyusun') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Status Publikasi:</label>
                                                    <select class="form-control" name="status" value="{{ $publikasi->penyusun }}">
                                                      <option value="submit" {{ old('status') == 'submit' ? 'selected' : '' }}>Submit</option>
                                                      <option value="in review" {{ old('status') == 'in review' ? 'selected' : '' }}>In Review</option>
                                                      <option value="accepted" {{ old('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                                      <option value="publish" {{ old('status') == 'publish' ? 'selected' : '' }}>Publish</option>
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
                        @endforeach
                    </tbody>
                </table>

                {{-- Modal --}}
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Publikasi_Karya_Ilmiah</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('pages.publikasi_karya_ilmiah_pkm.add') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="judul_penelitian" class="form-label">Judul Penelitian:</label>
                                        <input type="text" class="form-control" id="judul_penelitian" name="judul_penelitian" value="{{ session('judul_penelitian') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="judul_publikasi" class="form-label">Judul Publikasi:</label>
                                        <input type="text" class="form-control" id="judul_publikasi" name="judul_publikasi" value="{{ session('judul_publikasi') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="dosen" class="form-label">Nama Dosen:</label>
                                        <textarea class="form-control" id="dosen" name="dosen" required>{{ session('dosen') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="mahasiswa" class="form-label">Mahasiswa:</label>
                                        <textarea class="form-control" id="mahasiswa" name="mahasiswa" required>{{ session('mahasiswa') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="dipublikasikan" class="form-label">Dipublikasikan Pada:</label>
                                        <input type="text" class="form-control" id="dipublikasikan" name="dipublikasikan" value="{{ session('dipublikasikan') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="penerbit" class="form-label">Penerbit:</label>
                                        <input type="text" class="form-control" id="penerbit" name="penerbit" value="{{ session('penerbit') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jenis" class="form-label">jenis:</label>
                                        <input type="text" class="form-control" id="jenis" name="jenis" value="{{ session('jenis') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Tingkat:</label>
                                        <select class="form-control" name="tingkat">
                                          <option value="internasional" {{ old('tingkat') == 'internasional' ? 'selected' : '' }}>Internasional</option>
                                          <option value="nasional" {{ old('tingkat') == 'nasional' ? 'selected' : '' }}>Nasional</option>
                                          <option value="lokal" {{ old('tingkat') == 'lokal' ? 'selected' : '' }}>Lokal/Wilayah</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Penyusun Utama:</label>
                                        <select class="form-control" name="penyusun">
                                          <option value="dosen" {{ old('penyusun') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                                          <option value="mahasiswa" {{ old('penyusun') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Status Publikasi:</label>
                                        <select class="form-control" name="status">
                                          <option value="submit" {{ old('status') == 'submit' ? 'selected' : '' }}>Submit</option>
                                          <option value="in review" {{ old('status') == 'in review' ? 'selected' : '' }}>In Review</option>
                                          <option value="accepted" {{ old('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                          <option value="publish" {{ old('status') == 'publish' ? 'selected' : '' }}>Publish</option>
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

                @if($publikasi_karya_ilmiah_pkm->isEmpty())
                    <p class="text-center text-gray-500 mt-4">Tidak ada data yang diinput.</p>
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
     
         modalTitle.textContent = 'Tambah Publikasi Karya Ilmiah ';
         // modalBodyInput.value = recipient;
    });
    </script>
</x-app-layout>