<x-app-layout>
    <x-slot name="header">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Lahan Praktek') }}
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
                            <th class="px-4 py-2 border">Lahan Praktek</th>
                            <th class="px-4 py-2 border">Akreditasi</th>
                            <th class="px-4 py-2 border">Kesesuaian Bidang Keilmuan</th>
                            <th class="px-4 py-2 border">Jumlah Mahasiswa</th>
                            <th class="px-4 py-2 border">Daya Tampung Mahasiswa</th>
                            <th class="px-4 py-2 border">Kontribusi</th>
                            <th class="px-4 py-2 border">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lahan_praktek as $lahanpraktek)
                            <tr>
                                <td class="px-1 py-2 border">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border">{{ $lahanpraktek->lahan_praktek }}</td>
                                <td class="px-4 py-2 border">{{ $lahanpraktek->akreditasi }}</td>
                                <td class="px-4 py-2 border">{{ $lahanpraktek->kesesuaian_bidang_keilmuan }}</td>
                                <td class="px-4 py-2 border">{{ $lahanpraktek->jumlah_mahasiswa }}</td>
                                <td class="px-4 py-2 border">{{ $lahanpraktek->daya_tampung_mahasiswa }}</td>
                                <td class="px-4 py-2 border">{{ $lahanpraktek->kontribusi_lahan_praktek }}</td>
                                <td class="px-1 py-3 border flex flex-col items-center space-y-2">
                                    <!-- Tombol Edit -->
                                    <button 
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $lahanpraktek->id }}">
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

                            <div class="modal fade" id="exampleModal{{ $lahanpraktek->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah Pelaksanaan TA</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('pages.pelaksanaan_ta.update', $lahanpraktek->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" hidden name="id" value="{{ $lahanpraktek->id }}">
            
                                                <div class="mb-3">
                                                    <label for="lahan_praktek" class="form-label">Lahan Praktek:</label>
                                                    <input type="text" class="form-control" id="lahan_praktek" name="lahan_praktek" value="{{ $lahanpraktek->lahan_praktek }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="akreditasi" class="form-label">Akreditasi:</label>
                                                    <input type="text" class="form-control" id="akreditasi" name="akreditasi" value="{{ $lahanpraktek->akreditasi }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="kesesuaian_bidang_keilmuan" class="form-label">Kesesuaian Bidang Keilmuan:</label>
                                                    <input type="text" class="form-control" id="kesesuaian_bidang_keilmuan" name="kesesuaian_bidang_keilmuan" value="{{ $lahanpraktek->kesesuaian_bidang_keilmuan }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jumlah_mahasiswa" class="form-label">Jumlah Mahasiswa:</label>
                                                    <input type="text" class="form-control" id="jumlah_mahasiswa" name="jumlah_mahasiswa" value="{{ $lahanpraktek->jumlah_mahasiswa }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="daya_tampung_mahasiswa" class="form-label">Daya Tampung Mahasiswa:</label>
                                                    <input type="text" class="form-control" id="daya_tampung_mahasiswa" name="daya_tampung_mahasiswa" value="{{ $lahanpraktek->daya_tampung_mahasiswa }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="kontribusi_lahan_praktek" class="form-label">Kontribusi Lahan Praktek:</label>
                                                    <input type="text" class="form-control" id="kontribusi_lahan_praktek" name="kontribusi_lahan_praktek" value="{{ $lahanpraktek->kontribusi_lahan_praktek }}" required>
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
                                <form action="{{ route('pages.lahan_praktek.add') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="lahan_praktek" class="form-label">Lahan Praktek:</label>
                                        <input type="text" class="form-control" id="lahan_praktek" name="lahan_praktek" value="{{ session('lahan_praktek') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="akreditasi" class="form-label">Akreditasi:</label>
                                        <input type="text" class="form-control" id="akreditasi" name="akreditasi" value="{{ session('akreditasi') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kesesuaian_bidang_keilmuan" class="form-label">Kesesuaian Bidang Keilmuan:</label>
                                        <input type="text" class="form-control" id="kesesuaian_bidang_keilmuan" name="kesesuaian_bidang_keilmuan" value="{{ session('kesesuaian_bidang_keilmuan') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jumlah_mahasiswa" class="form-label">Jumlah Mahasiswa:</label>
                                        <input type="text" class="form-control" id="jumlah_mahasiswa" name="jumlah_mahasiswa" value="{{ session('jumlah_mahasiswa') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="daya_tampung_mahasiswa" class="form-label">Daya Tampung Mahasiswa:</label>
                                        <input type="text" class="form-control" id="daya_tampung_mahasiswa" name="daya_tampung_mahasiswa" value="{{ session('daya_tampung_mahasiswa') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kontribusi_lahan_praktek" class="form-label">Kontribusi Lahan Praktek:</label>
                                        <input type="text" class="form-control" id="kontribusi_lahan_praktek" name="kontribusi_lahan_praktek" value="{{ session('kontribusi_lahan_praktek') }}" required>
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

                @if($lahan_praktek->isEmpty())
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