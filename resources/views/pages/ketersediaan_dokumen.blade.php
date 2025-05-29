<x-app-layout>
    <x-slot name="header">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Ketersediaan Dokumen') }}
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
                            <th class="px-4 py-2 border text-sm">Kegiatan</th>
                            <th class="px-4 py-2 border text-sm">Ketersediaan Dokumen</th>
                            <th class="px-4 py-2 border text-sm">Nomor Dokumen</th>
                            <th class="px-1 py-2 border text-sm">Link Dokumen</th>
                            <th class="px-4 py-2 border text-sm">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ketersediaan_dokumen as $ketersediaandokumen)
                            <tr>
                                <td class="px-1 py-2 border text-sm">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $ketersediaandokumen->kegiatan }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $ketersediaandokumen->ketersediaan_dokumen }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $ketersediaandokumen->nomor_dokumen }}</td>
                                <td class="px-1 py-2 border text-sm">
                                    <a href="{{ $ketersediaandokumen->link_dokumen }}" target="_blank" class="text-blue-500 hover:underline">
                                        Link
                                    </a>
                                </td>
                                <td class="px-1 py-3 border flex flex-col items-center space-y-2 text-sm">
                                    <!-- Tombol Edit -->
                                    <button 
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $ketersediaandokumen->id }}">
                                        Edit
                                    </button>

                                    <!-- Tombol Delete -->
                                    <form action="{{ route('pages.ketersediaan_dokumen.destroy', $ketersediaandokumen->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="exampleModal{{ $ketersediaandokumen->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Ketersediaan Dokumen</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('pages.ketersediaan_dokumen.update', $ketersediaandokumen->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" hidden name="id" value="{{ $ketersediaandokumen->id }}">
            
                                                <div class="mb-3">
                                                    <label for="kegiatan" class="form-label">Kegiatan:</label>
                                                    <input type="text" class="form-control" id="kegiatan" name="kegiatan" value="{{ $ketersediaandokumen->kegiatan }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="ketersediaan_dokumen" class="form-label">Ketersediaan Dokumen:</label>
                                                    <input type="text" class="form-control" id="ketersediaan_dokumen" name="ketersediaan_dokumen" value="{{ $ketersediaandokumen->ketersediaan_dokumen }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nomor_dokumen" class="form-label">Nomor Dokumen:</label>
                                                    <input type="text" class="form-control" id="nomor_dokumen" name="nomor_dokumen" value="{{ $ketersediaandokumen->nomor_dokumen }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="link_dokumen" class="form-label">Link Dokumen:</label>
                                                    <textarea class="form-control" id="link_dokumen" name="link_dokumen" rows="3" placeholder="eg: https://drive.google.com/">{{ $ketersediaandokumen->link_dokumen }}</textarea>
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
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Ketersediaan Dokumen</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('pages.ketersediaan_dokumen.add') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="kegiatan" class="form-label">Kegiatan:</label>
                                        <input type="text" class="form-control" id="kegiatan" name="kegiatan" value="{{ session('kegiatan') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ketersediaan_dokumen" class="form-label">Ketersediaan Dokumen:</label>
                                        <input type="text" class="form-control" id="ketersediaan_dokumen" name="ketersediaan_dokumen" value="{{ session('ketersediaan_dokumen') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nomor_dokumen" class="form-label">Nomor Dokumen:</label>
                                        <input type="text" class="form-control" id="nomor_dokumen" name="nomor_dokumen" value="{{ session('nomor_dokumen') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="link_dokumen" class="form-label">Link Dokumen:</label>
                                        <textarea class="form-control" id="link_dokumen" name="link_dokumen" placeholder="eg: https://drive.google.com/">{{ session('link_dokumen') }}</textarea>
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

                @if($ketersediaan_dokumen->isEmpty())
                    <p class="text-center text-gray-500 mt-4">Data tidak ada.</p>
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
     
         modalTitle.textContent = 'Tambah Visi Misi ';
         // modalBodyInput.value = recipient;
        });
    </script>
</x-app-layout>