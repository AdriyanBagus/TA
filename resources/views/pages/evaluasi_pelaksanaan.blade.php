<x-app-layout>
    <x-slot name="header">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Evaluasi Pelaksanaan') }}
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
                            <th class="px-4 py-2 border">Nomor PTK</th>
                            <th class="px-4 py-2 border">Kategori PTK</th>
                            <th class="px-4 py-2 border">Rencana Penyelesaian</th>
                            <th class="px-4 py-2 border">Realisasi Perbaikan</th>
                            <th class="px-4 py-2 border">Penanggungjawab Perbaikan</th>
                            <th class="px-4 py-2 border">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($evaluasi_pelaksanaan as $evaluasipelaksanaan)
                            <tr>
                                <td class="px-1 py-2 border">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border">{{ $evaluasipelaksanaan->nomor_ptk }}</td>
                                <td class="px-4 py-2 border">{{ $evaluasipelaksanaan->kategori_ptk }}</td>
                                <td class="px-4 py-2 border">{{ $evaluasipelaksanaan->rencana_penyelesaian }}</td>
                                <td class="px-4 py-2 border">{{ $evaluasipelaksanaan->realisasi_perbaikan }}</td>
                                <td class="px-4 py-2 border">{{ $evaluasipelaksanaan->penanggungjawab_perbaikan }}</td>
                                <td class="px-1 py-3 border flex flex-col items-center space-y-2">
                                    <!-- Tombol Edit -->
                                    <button 
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $evaluasipelaksanaan->id }}">
                                        Edit
                                </button>

                                    <!-- Tombol Delete -->
                                    <form action="{{ route('pages.evaluasi_pelaksanaan.destroy', $evaluasipelaksanaan->id) }}" method="POST"
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

                            <div class="modal fade" id="exampleModal{{ $evaluasipelaksanaan->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah Evaluasi Pelaksanaan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('pages.evaluasi_pelaksanaan.update', $evaluasipelaksanaan->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" hidden name="id" value="{{ $evaluasipelaksanaan->id }}">
            
                                                <div class="mb-3">
                                                    <label for="nomor_ptk" class="form-label">Nomor PTK:</label>
                                                    <input type="text" class="form-control" id="nomor_ptk" name="nomor_ptk" value="{{ $evaluasipelaksanaan->nomor_ptk }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Kategori PTK</label>
                                                    <select class="form-control" name="kategori_ptk" value="{{ $evaluasipelaksanaan->kategori_ptk }}">
                                                      <option value="Mayor" {{ old('kategori_ptk') == 'Mayor' ? 'selected' : '' }}>Mayor</option>
                                                      <option value="Minor" {{ old('kategori_ptk') == 'Minor' ? 'selected' : '' }}>Minor</option>
                                                      <option value="Observasi" {{ old('kategori_ptk') == 'Observasi' ? 'selected' : '' }}>Observasi</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                  <label for="rencana_penyelesaian" class="form-label">Rencana Penyelesaian:</label>
                                                  <input type="text" class="form-control" id="rencana_penyelesaian" name="rencana_penyelesaian" value="{{ $evaluasipelaksanaan->rencana_penyelesaian }}" required>
                                                </div>
                                                <div class="mb-3">
                                                  <label for="realisasi_perbaikan" class="form-label">Realisasi Perbaikan:</label>
                                                  <input type="text" class="form-control" id="realisasi_perbaikan" name="realisasi_perbaikan" value="{{ $evaluasipelaksanaan->realisasi_perbaikan }}" required>
                                                </div>
                                                <div class="mb-3">
                                                  <label for="penanggungjawab_perbaikan" class="form-label">Penanggungjawab Perbaikan:</label>
                                                  <input type="text" class="form-control" id="penanggungjawab_perbaikan" name="penanggungjawab_perbaikan" value="{{ $evaluasipelaksanaan->penanggungjawab_perbaikan }}" required>
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
                                <form action="{{ route('pages.evaluasi_pelaksanaan.add') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="nomor_ptk" class="form-label">Nomor PTK:</label>
                                        <input type="text" class="form-control" id="nomor_ptk" name="nomor_ptk" value="{{ session('nomor_ptk') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Kategori PTK</label>
                                        <select class="form-control" name="kategori_ptk">
                                          <option value="Mayor" {{ old('kategori_ptk') == 'Mayor' ? 'selected' : '' }}>Mayor</option>
                                          <option value="Minor" {{ old('kategori_ptk') == 'Minor' ? 'selected' : '' }}>Minor</option>
                                          <option value="Observasi" {{ old('kategori_ptk') == 'Observasi' ? 'selected' : '' }}>Observasi</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                      <label for="rencana_penyelesaian" class="form-label">Rencana Penyelesaian:</label>
                                      <input type="text" class="form-control" id="rencana_penyelesaian" name="rencana_penyelesaian" value="{{ session('rencana_penyelesaian') }}" required>
                                    </div>
                                    <div class="mb-3">
                                      <label for="realisasi_perbaikan" class="form-label">Realisasi Perbaikan:</label>
                                      <input type="text" class="form-control" id="realisasi_perbaikan" name="realisasi_perbaikan" value="{{ session('realisasi_perbaikan') }}" required>
                                    </div>
                                    <div class="mb-3">
                                      <label for="penanggungjawab_perbaikan" class="form-label">Penanggungjawab Perbaikan:</label>
                                      <input type="text" class="form-control" id="penanggungjawab_perbaikan" name="penanggungjawab_perbaikan" value="{{ session('penanggungjawab_perbaikan') }}" required>
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

                @if ($evaluasi_pelaksanaan->isEmpty())
                    <p class="text-center text-gray-500 mt-4">Tidak ada data yang diinput.</p>
                @endif
            </div>
        </div>
    </div>
    <script>
        document.getElementById('exampleModal').addEventListener('show.bs.modal', function (event) {
         const button = event.relatedTarget; // Button yang memicu modal
         const modalTitle = this.querySelector('.modal-title');
         const modalBodyInput = this.querySelector('.modal-body input');
     
         modalTitle.textContent = 'Tambah Evaluasi Pelaksanaan ';
         // modalBodyInput.value = recipient;
    });
</x-app-layout>