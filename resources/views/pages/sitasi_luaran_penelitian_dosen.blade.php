<x-app-layout>
    <x-slot name="header">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Sitasi Luaran Penelitian Dosen') }}
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
                            <th class="px-4 py-2 border text-xs">Judul Artikel</th>
                            <th class="px-4 py-2 border text-xs">Jumlah Sitasi</th>
                            <th class="px-4 py-2 border text-xs">Link Sitasi</th>
                            <th class="px-4 py-2 border text-xs">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sitasi_luaran_penelitian_dosen as $sitasiluaran)
                            <tr>
                                <td class="px-1 py-2 border text-xs">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border text-xs">{{ $sitasiluaran->nama }}</td>
                                <td class="px-4 py-2 border text-xs">{{ $sitasiluaran->judul_artikel }}</td>
                                <td class="px-4 py-2 border text-xs">{{ $sitasiluaran->jumlah_sitasi }}</td>
                                <td class="px-4 py-2 border text-xs">
                                    <a href="{{ $sitasiluaran->link_sitasi }}" target="_blank" class="text-blue-600 underline">
                                        Link
                                    </a>
                                </td>
                                <td class="px-1 py-3 border flex flex-col items-center space-y-2">
                                    <!-- Tombol Edit -->
                                    <button 
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-xs" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $sitasiluaran->id }}">
                                        Edit
                                </button>

                                    <!-- Tombol Delete -->
                                    <form action="{{ route('pages.sitasi_luaran_penelitian_dosen.destroy', $sitasiluaran->id) }}" method="POST"
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

                            <div class="modal fade" id="exampleModal{{ $sitasiluaran->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">luaran Karya Ilmiah</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('pages.sitasi_luaran_penelitian_dosen.update', $sitasiluaran->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" hidden name="id" value="{{ $sitasiluaran->id }}">
            
                                                <div class="mb-3">
                                                    <label for="nama" class="form-label">Nama:</label>
                                                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $sitasiluaran->nama }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="judul_artikel" class="form-label">Judul karya:</label>
                                                    <input type="text" class="form-control" id="judul_artikel" name="judul_artikel" value="{{ $sitasiluaran->judul_artikel }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jumlah_sitasi" class="form-label">Jumlah Sitasi:</label>
                                                    <input type="text" class="form-control" id="jumlah_sitasi" name="jumlah_sitasi" value="{{ $sitasiluaran->jumlah_sitasi }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="link_sitasi" class="form-label">Link Sitasi:</label>
                                                    <input type="text" class="form-control" id="link_sitasi" name="link_sitasi" value="{{ $sitasiluaran->link_sitasi }}" required>
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
                                <form action="{{ route('pages.sitasi_luaran_penelitian_dosen.add') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama:</label>
                                        <input type="text" class="form-control" id="nama" name="nama" value="{{ session('nama') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="judul_artikel" class="form-label">Judul karya:</label>
                                        <input type="text" class="form-control" id="judul_artikel" name="judul_artikel" value="{{ session('judul_artikel') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jumlah_sitasi" class="form-label">Jumlah Sitasi:</label>
                                        <input type="text" class="form-control" id="jumlah_sitasi" name="jumlah_sitasi" value="{{ session('jumlah_sitasi') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="link_sitasi" class="form-label">Link Sitasi:</label>
                                        <input type="text" class="form-control" id="link_sitasi" name="link_sitasi" placeholder="eg: https://drive.google.com/" value="{{ session('link_sitasi') }}" required>
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

                @if($sitasi_luaran_penelitian_dosen->isEmpty())
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
     
         modalTitle.textContent = 'Tambah Sitasi luaran Penelitian Dosen ';
         // modalBodyInput.value = recipient;
    });
    </script>
</x-app-layout>