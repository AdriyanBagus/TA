<x-app-layout>
    <x-slot name="header">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kerjasama') }}
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
                            <th class="px-2 py-2 border text-sm">No</th>
                            <th class="px-4 py-2 border text-sm">Lembaga Mitra</th>
                            <th class="px-4 py-2 border text-sm">Jenis</th>
                            <th class="px-4 py-2 border text-sm">Tingkat</th>
                            <th class="px-4 py-2 border text-sm">Judul Kerjasama</th>
                            <th class="px-4 py-2 border text-sm">Waktu</th>
                            <th class="px-4 py-2 border text-sm">Realisasi Kerjasama</th>
                            <th class="px-4 py-2 border text-sm">SPK</th>
                            <th class="px-4 py-2 border text-sm">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kerjasama as $kerjasamaa)
                            <tr>
                                <td class="px-1 py-2 border text-sm">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $kerjasamaa->lembaga_mitra }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $kerjasamaa->jenis_kerjasama }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $kerjasamaa->tingkat }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $kerjasamaa->judul_kerjasama }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $kerjasamaa->waktu_durasi }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $kerjasamaa->realisasi_kerjasama }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $kerjasamaa->spk }}</td>
                                <td class="px-1 py-3 border flex flex-col items-center space-y-2 text-sm">
                                    <!-- Tombol Edit -->
                                    <button 
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $kerjasamaa->id }}">
                                        Edit
                                    </button>

                                    <!-- Tombol Delete -->
                                    <form action="{{ route('pages.kerjasama.destroy', $kerjasamaa->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                                </td>
                            </tr>

                            <div class="modal fade" id="exampleModal{{ $kerjasamaa->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Kerjasama</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('pages.kerjasama.update', $kerjasamaa->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" hidden name="id" value="{{ $kerjasamaa->id }}">
            
                                                <div class="mb-3">
                                                    <label for="lembaga_mitra" class="form-label">Lembaga Mitra:</label>
                                                    <input type="text" class="form-control" id="lembaga_mitra" name="lembaga_mitra" value="{{ $kerjasamaa->lembaga_mitra }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Jenis</label>
                                                    <select class="form-control" name="jenis_kerjasama">
                                                      <option value="pendidikan" {{ $kerjasamaa->jenis_kerjasama == 'pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                                      <option value="penelitian" {{ $kerjasamaa->jenis_kerjasama == 'penelitian' ? 'selected' : '' }}>Penelitian</option>
                                                      <option value="pengabdian" {{ $kerjasamaa->jenis_kerjasama == 'pengabdian' ? 'selected' : '' }}>Pengabdian</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Tingkat</label>
                                                    <select class="form-control" name="tingkat">
                                                      <option value="internasional" {{ $kerjasamaa->tingkat == 'internasional' ? 'selected' : '' }}>Internasional</option>
                                                      <option value="nasional" {{ $kerjasamaa->tingkat == 'nasional' ? 'selected' : '' }}>Nasional</option>
                                                      <option value="lokal" {{ $kerjasamaa->tingkat == 'lokal' ? 'selected' : '' }}>Lokal/Wilayah</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                  <label for="judul_kerjasama" class="form-label">Judul Kerjasama:</label>
                                                  <textarea class="form-control" id="judul_kerjasama" name="judul_kerjasama" required>{{ $kerjasamaa->judul_kerjasama }}</textarea>
                                              </div>
                                              <div class="mb-3">
                                                  <label for="waktu_durasi" class="form-label">Waktu:</label>
                                                  <input type="text" class="form-control" id="waktu_durasi" name="waktu_durasi" value="{{ $kerjasamaa->waktu_durasi }}">
                                              </div>
                                              <div class="mb-3">
                                                  <label for="realisasi_kerjasama" class="form-label">Realisasi Kerjasama:</label>
                                                  <textarea class="form-control" id="realisasi_kerjasama" name="realisasi_kerjasama" required>{{ $kerjasamaa->realisasi_kerjasama }}</textarea>
                                              </div>
                                              <div class="form-group">
                                                <label>SPK</label>
                                                <select class="form-control" name="spk">
                                                  <option value="ya" {{ $kerjasamaa->spk == 'ya' ? 'selected' : '' }}>Ya</option>
                                                  <option value="tidak" {{ $kerjasamaa->spk == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                                </select>
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
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Kerjasama</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('pages.kerjasama.add') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="lembaga_mitra" class="form-label">Lembaga Mitra:</label>
                                        <input type="text" class="form-control" id="lembaga_mitra" name="lembaga_mitra" value="{{ session('lembaga_mitra') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Jenis</label>
                                        <select class="form-control" name="jenis_kerjasama">
                                          <option value="pendidikan" {{ old('jenis_kerjasama') == 'pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                          <option value="penelitian" {{ old('jenis_kerjasama') == 'penelitian' ? 'selected' : '' }}>Penelitian</option>
                                          <option value="pengabdian" {{ old('jenis_kerjasama') == 'pengabdian' ? 'selected' : '' }}>Pengabdian</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Tingkat</label>
                                        <select class="form-control" name="tingkat">
                                          <option value="internasional" {{ old('tingkat') == 'internasional' ? 'selected' : '' }}>Internasional</option>
                                          <option value="nasional" {{ old('tingkat') == 'nasional' ? 'selected' : '' }}>Nasional</option>
                                          <option value="lokal" {{ old('tingkat') == 'lokal' ? 'selected' : '' }}>Lokal/Wilayah</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="judul_kerjasama" class="form-label">Judul Kerjasama:</label>
                                        <textarea class="form-control" id="judul_kerjasama" name="judul_kerjasama" required>{{ session('judul_kerjasama') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="waktu_durasi" class="form-label">Waktu:</label>
                                        <input type="text" class="form-control" id="waktu_durasi" name="waktu_durasi" value="{{ session('waktu_durasi') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="realisasi_kerjasama" class="form-label">Realisasi Kerjasama:</label>
                                        <textarea class="form-control" id="realisasi_kerjasama" name="realisasi_kerjasama" required>{{ session('realisasi_kerjasama') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>SPK</label>
                                        <select class="form-control" name="spk">
                                          <option value="ya" {{ old('spk') == 'ya' ? 'selected' : '' }}>Ya</option>
                                          <option value="tidak" {{ old('spk') == 'tidak' ? 'selected' : '' }}>Tidak</option>
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

                @if($kerjasama->isEmpty())
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
     
         modalTitle.textContent = 'Tambah Kerjasama ';
         // modalBodyInput.value = recipient;
        });
    </script>
</x-app-layout>