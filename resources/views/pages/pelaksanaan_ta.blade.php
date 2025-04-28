<x-app-layout>
    <x-slot name="header">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Pelaksanaan TA') }}
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
                            <th class="px-4 py-2 border">NIDN</th>
                            <th class="px-4 py-2 border">Bimbingan Mahasiswa</th>
                            <th class="px-4 py-2 border">Jumlah Bimbingan</th>
                            <th class="px-4 py-2 border">Bimbingan Mahasiswa PS Lain</th>
                            <th class="px-4 py-2 border">Jumlah Bimbingan Seluruh PS</th>
                            <th class="px-4 py-2 border">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pelaksanaan_ta as $pelaksanaanta)
                            <tr>
                                <td class="px-1 py-2 border">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border">{{ $pelaksanaanta->nama }}</td>
                                <td class="px-4 py-2 border">{{ $pelaksanaanta->nidn }}</td>
                                <td class="px-4 py-2 border">{{ $pelaksanaanta->bimbingan_mahasiswa_ps }}</td>
                                <td class="px-4 py-2 border">{{ $pelaksanaanta->rata_rata_jumlah_bimbingan }}</td>
                                <td class="px-4 py-2 border">{{ $pelaksanaanta->bimbingan_mahasiswa_ps_lain }}</td>
                                <td class="px-4 py-2 border">{{ $pelaksanaanta->rata_rata_jumlah_bimbingan_seluruh_ps }}</td>
                                <td class="px-1 py-3 border flex flex-col items-center space-y-2">
                                    <!-- Tombol Edit -->
                                    <button 
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $pelaksanaanta->id }}">
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

                            <div class="modal fade" id="exampleModal{{ $pelaksanaanta->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah Pelaksanaan TA</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('pages.pelaksanaan_ta.update', $pelaksanaanta->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" hidden name="id" value="{{ $pelaksanaanta->id }}">
            
                                                <div class="mb-3">
                                                    <label for="nama" class="form-label">Nama:</label>
                                                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $pelaksanaanta->nama }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nidn" class="form-label">NIDN:</label>
                                                    <input type="text" class="form-control" id="nidn" name="nidn" value="{{ $pelaksanaanta->nidn }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="bimbingan_mahasiswa_ps" class="form-label">Bimbingan Mahasiswa:</label>
                                                    <input type="text" class="form-control" id="bimbingan_mahasiswa_ps" name="bimbingan_mahasiswa_ps" value="{{ $pelaksanaanta->bimbingan_mahasiswa_ps }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="rata_rata_jumlah_bimbingan" class="form-label">Jumlah Bimbingan:</label>
                                                    <input type="text" class="form-control" id="rata_rata_jumlah_bimbingan" name="rata_rata_jumlah_bimbingan" value="{{ $pelaksanaanta->rata_rata_jumlah_bimbingan }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="bimbingan_mahasiswa_ps_lain" class="form-label">Bimbingan Mahasiswa PS Lain:</label>
                                                    <input type="text" class="form-control" id="bimbingan_mahasiswa_ps_lain" name="bimbingan_mahasiswa_ps_lain" value="{{ $pelaksanaanta->bimbingan_mahasiswa_ps_lain }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="rata_rata_jumlah_bimbingan_seluruh_ps" class="form-label">Jumlah Bimbingan Seluruh PS:</label>
                                                    <input type="text" class="form-control" id="rata_rata_jumlah_bimbingan_seluruh_ps" name="rata_rata_jumlah_bimbingan_seluruh_ps" value="{{ $pelaksanaanta->rata_rata_jumlah_bimbingan_seluruh_ps }}" required>
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
                                <form action="{{ route('pages.pelaksanaan_ta.add') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama:</label>
                                        <input type="text" class="form-control" id="nama" name="nama" value="{{ session('nama') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nidn" class="form-label">NIDN:</label>
                                        <input type="text" class="form-control" id="nidn" name="nidn" value="{{ session('nidn') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="bimbingan_mahasiswa_ps" class="form-label">Bimbingan Mahasiswa:</label>
                                        <input type="text" class="form-control" id="bimbingan_mahasiswa_ps" name="bimbingan_mahasiswa_ps" value="{{ session('bimbingan_mahasiswa_ps') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="rata_rata_jumlah_bimbingan" class="form-label">Jumlah Bimbingan:</label>
                                        <input type="text" class="form-control" id="rata_rata_jumlah_bimbingan" name="rata_rata_jumlah_bimbingan" value="{{ session('rata_rata_jumlah_bimbingan') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="bimbingan_mahasiswa_ps_lain" class="form-label">Bimbingan Mahasiswa PS Lain:</label>
                                        <input type="text" class="form-control" id="bimbingan_mahasiswa_ps_lain" name="bimbingan_mahasiswa_ps_lain" value="{{ session('bimbingan_mahasiswa_ps_lain') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="rata_rata_jumlah_bimbingan_seluruh_ps" class="form-label">Jumlah Bimbingan Seluruh PS:</label>
                                        <input type="text" class="form-control" id="rata_rata_jumlah_bimbingan_seluruh_ps" name="rata_rata_jumlah_bimbingan_seluruh_ps" value="{{ session('rata_rata_jumlah_bimbingan_seluruh_ps') }}" required>
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

                @if($pelaksanaan_ta->isEmpty())
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