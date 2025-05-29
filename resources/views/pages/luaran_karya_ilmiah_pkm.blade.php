<x-app-layout>
    <x-slot name="header">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Luaran Karya Ilmiah Dosen Hasil Kegiatan PKM') }}
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
                            <th class="px-4 py-2 border text-xs">Judul Kegiatan</th>
                            <th class="px-4 py-2 border text-xs">Judul Karya</th>
                            <th class="px-4 py-2 border text-xs">Dosen</th>
                            <th class="px-4 py-2 border text-xs">Mahasiswa</th>
                            <th class="px-4 py-2 border text-xs">Penyusun</th>
                            <th class="px-4 py-2 border text-xs">Jenis Karya</th>
                            <th class="px-4 py-2 border text-xs">Nomor Karya</th>
                            <th class="px-4 py-2 border text-xs">Keterangan</th>
                            <th class="px-4 py-2 border text-xs">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($luaran_karya_ilmiah_pkm as $luaran)
                            <tr>
                                <td class="px-1 py-2 border text-xs">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border text-xs">{{ $luaran->judul_kegiatan_pkm }}</td>
                                <td class="px-4 py-2 border text-xs">{{ $luaran->judul_karya }}</td>
                                <td class="px-4 py-2 border text-xs">{!! nl2br(e($luaran->dosen)) !!}</td>
                                <td class="px-4 py-2 border text-xs">{!! nl2br(e($luaran->mahasiswa)) !!}</td>
                                <td class="px-4 py-2 border text-xs">{{ $luaran->penyusun_utama }}</td>
                                <td class="px-4 py-2 border text-xs">{{ $luaran->jenis }}</td>
                                <td class="px-4 py-2 border text-xs">{{ $luaran->nomor_karya }}</td>
                                <td class="px-4 py-2 border text-xs">{{ $luaran->keterangan }}</td>
                                <td class="px-4 py-2 border text-xs">{{ $luaran->status }}</td>
                                <td class="px-1 py-3 border flex flex-col items-center space-y-2">
                                    <!-- Tombol Edit -->
                                    <button 
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-xs" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $luaran->id }}">
                                        Edit
                                </button>

                                    <!-- Tombol Delete -->
                                    <form action="{{ route('pages.luaran_karya_ilmiah_pkm.destroy', $luaran->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-xs">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="exampleModal{{ $luaran->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">luaran Karya Ilmiah</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('pages.luaran_karya_ilmiah_pkm.update', $luaran->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" hidden name="id" value="{{ $luaran->id }}">
            
                                                <div class="mb-3">
                                                    <label for="judul_kegiatan_pkm" class="form-label">Judul Kegiatan PKM:</label>
                                                    <input type="text" class="form-control" id="judul_kegiatan_pkm" name="judul_kegiatan_pkm" value="{{ $luaran->judul_kegiatan_pkm }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="judul_karya" class="form-label">Judul karya:</label>
                                                    <input type="text" class="form-control" id="judul_karya" name="judul_karya" value="{{ $luaran->judul_karya }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="dosen" class="form-label">Dosen:</label>
                                                    <textarea class="form-control" id="dosen" name="dosen">{{  $luaran->dosen }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="mahasiswa" class="form-label">Mahasiswa:</label>
                                                    <textarea class="form-control" id="mahasiswa" name="mahasiswa">{{  $luaran->mahasiswa }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label>Penyusun Utama:</label>
                                                    <select class="form-control" name="penyusun_utama" value="{{ $luaran->penyusun_utama }}">
                                                      <option value="dosen" {{ old('penyusun_utama') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                                                      <option value="mahasiswa" {{ old('penyusun_utama') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jenis" class="form-label">jenis:</label>
                                                    <input type="text" class="form-control" id="jenis" name="jenis" value="{{ $luaran->jenis }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nomor_karya" class="form-label">Nomor Karya:</label>
                                                    <input type="text" class="form-control" id="nomor_karya" name="nomor_karya" value="{{ $luaran->nomor_karya }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="keterangan" class="form-label">Keterangan:</label>
                                                    <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{ $luaran->keterangan }}">
                                                </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Update</button>
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
                                <h5 class="modal-title" id="exampleModalLabel">luaran_karya_ilmiah</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('pages.luaran_karya_ilmiah_pkm.add') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="judul_kegiatan_pkm" class="form-label">Judul Kegiatan PKM:</label>
                                        <input type="text" class="form-control" id="judul_kegiatan_pkm" name="judul_kegiatan_pkm" value="{{ session('judul_kegiatan_pkm') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="judul_karya" class="form-label">Judul karya:</label>
                                        <input type="text" class="form-control" id="judul_karya" name="judul_karya" value="{{ session('judul_karya') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="dosen" class="form-label">Dosen:</label>
                                        <textarea class="form-control" id="dosen" name="dosen" value="{{ session('dosen') }}"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="mahasiswa" class="form-label">Mahasiswa:</label>
                                        <textarea class="form-control" id="mahasiswa" name="mahasiswa" value="{{ session('mahasiswa') }}"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Penyusun Utama:</label>
                                        <select class="form-control" name="penyusun_utama" value="{{ session('penyusun_utama') }}">
                                          <option value="dosen" {{ old('penyusun_utama') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                                          <option value="mahasiswa" {{ old('penyusun_utama') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jenis" class="form-label">jenis:</label>
                                        <input type="text" class="form-control" id="jenis" name="jenis" value="{{ session('jenis') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="nomor_karya" class="form-label">Nomor Karya:</label>
                                        <input type="text" class="form-control" id="nomor_karya" name="nomor_karya" value="{{ session('nomor_karya') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="keterangan" class="form-label">Keterangan:</label>
                                        <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{ session('keterangan') }}">
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

                @if($luaran_karya_ilmiah_pkm->isEmpty())
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
     
         modalTitle.textContent = 'Tambah Luaran Karya Ilmiah PKM ';
         // modalBodyInput.value = recipient;
        });
    </script>
</x-app-layout>