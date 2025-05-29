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
                            <th class="px-2 py-2 border">No</th>
                            <th class="px-4 py-2 border">Nama</th>
                            <th class="px-4 py-2 border">Bidang Keahlian</th>
                            <th class="px-4 py-2 border">Jenis Rekognisi</th>
                            <th class="px-4 py-2 border">Nama Kegiatan</th>
                            <th class="px-4 py-2 border">Tingkat</th>
                            <th class="px-4 py-2 border">Tahun Perolehan</th>
                            <th class="px-4 py-2 border">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekognisi_tenaga_kependidikan as $rekognisitenagakependidikan)
                            <tr>
                                <td class="px-1 py-2 border">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border">{{ $rekognisitenagakependidikan->nama }}</td>
                                <td class="px-4 py-2 border">{{ $rekognisitenagakependidikan->bidang_keahlian }}</td>
                                <td class="px-4 py-2 border">{{ $rekognisitenagakependidikan->jenis_rekognisi }}</td>
                                <td class="px-4 py-2 border">{{ $rekognisitenagakependidikan->tingkat }}</td>
                                <td class="px-4 py-2 border">{{ $rekognisitenagakependidikan->tahun_perolehan }}</td>
                                <td class="px-1 py-3 border flex flex-col items-center space-y-2">
                                    <button 
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $rekognisitenagakependidikan->id }}">
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

                            <div class="modal fade" id="exampleModal{{ $rekognisitenagakependidikan->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah Rekognisi Tenaga Kependidikan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('pages.rekognisi_tenaga_kependidikan.update', $rekognisitenagakependidikan->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" hidden name="id" value="{{ $rekognisitenagakependidikan->id }}">
            
                                                <div class="mb-3">
                                                    <label for="nama" class="form-label">Nama:</label>
                                                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $rekognisitenagakependidikan->nama }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="bidang_keahlian" class="form-label">Bidang Keahlian:</label>
                                                    <input type="text" class="form-control" id="bidang_keahlian" name="bidang_keahlian" value="{{ $rekognisitenagakependidikan->bidang_keahlian }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jenis_rekognisi" class="form-label">Jenis Rekognisi:</label>
                                                    <input type="text" class="form-control" id="jenis_rekognisi" name="jenis_rekognisi" value="{{ $rekognisitenagakependidikan->jenis_rekognisi }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tingkat" class="form-label">Tingkat:</label>
                                                    <input type="text" class="form-control" id="tingkat" name="tingkat" value="{{ $rekognisitenagakependidikan->tingkat }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tahun_perolehan" class="form-label">Tahun Perolehan:</label>
                                                    <input type="text" class="form-control" id="tahun_perolehan" name="tahun_perolehan" value="{{ $rekognisitenagakependidikan->tahun_perolehan }}" required>
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
                                <form action="{{ route('pages.rekognisi_tenaga_kependidikan.add') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama:</label>
                                        <input type="text" class="form-control" id="nama" name="nama" value="{{ session('nama') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="bidang_keahlian" class="form-label">Bidang Keahlian:</label>
                                        <input type="text" class="form-control" id="bidang_keahlian" name="bidang_keahlian" value="{{ session('bidang_keahlian') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jenis_rekognisi" class="form-label">Jenis Rekognisi:</label>
                                        <input type="text" class="form-control" id="jenis_rekognisi" name="jenis_rekognisi" value="{{ session('jenis_rekognisi') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tingkat" class="form-label">Tingkat:</label>
                                        <input type="text" class="form-control" id="tingkat" name="tingkat" value="{{ session('tingkat') }}" required>
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

                @if($rekognisi_tenaga_kependidikan->isEmpty())
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