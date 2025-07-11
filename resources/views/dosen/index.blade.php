<x-app-layout>
    <div class="py-3 px-4 max-w-3xl mx-auto" x-data="{ open: false }">
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-xl rounded-2xl p-6 max-w-2xl mx-auto">
            <div class="flex flex-col items-center text-center">
                <!-- Avatar -->
                <div class="w-32 h-32 rounded-full bg-gray-200 overflow-hidden mb-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($profil->name) }}&background=random"
                        alt="Foto Profil" class="object-cover w-full h-full">
                </div>

                <!-- Nama dan Email -->
                <h3 class="text-2xl font-bold text-gray-800">{{ $profil->name }}</h3>
                <p class="text-sm text-gray-500 mb-4">{{ $profil->email }}</p>

                <!-- Detail Profil -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full text-left mt-4">
                    <p><span class="font-semibold text-gray-700">NIDN:</span> {{ $profil->nidn ?? '-' }}</p>
                    <p><span class="font-semibold text-gray-700">Kualifikasi Pendidikan:</span>
                        {{ $profil->kualifikasi_pendidikan ?? '-' }}</p>
                    <p><span class="font-semibold text-gray-700">Sertifikasi Profesional:</span>
                        {{ $profil->sertifikasi_pendidik_profesional ?? '-' }}</p>
                    <p><span class="font-semibold text-gray-700">Bidang Keahlian:</span>
                        {{ $profil->bidang_keahlian ?? '-' }}</p>
                    <p><span class="font-semibold text-gray-700">Kesesuaian Bidang Ilmu:</span>
                        {{ $profil->bidang_ilmu_prodi ?? '-' }}</p>
                    <p><span class="font-semibold text-gray-700">Jenis Dosen:</span> {{ $profil->jenis_dosen ?? '-' }}
                    </p>
                    <p><span class="font-semibold text-gray-700">Status Dosen:</span>
                        {{ $profil->status_dosen ?? '-' }}</p>
                    <p><span class="font-semibold text-gray-700">Asal Prodi:</span>
                        {{ \App\Models\User::find($profil->parent_id)->name ?? '-' }}</p>
                </div>

                <!-- Tombol Edit -->
                <div class="mt-6">
                    <button @click="open = true"
                        class="bg-yellow-500 text-white px-6 py-2 rounded-full hover:bg-yellow-600 transition-all shadow-md">
                        Edit Profil
                    </button>
                </div>
            </div>
        </div>


        <!-- MODAL EDIT -->
        {{-- <div x-show="open" class="fixed inset-0 z-50 bg-black/30 backdrop-blur-sm flex items-center justify-center">
            <div @click.away="open = false" class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
                <h2 class="text-lg font-semibold mb-4">Edit Profil Dosen</h2>
                <form method="POST" action="{{ route('dosen.update', $dosen->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ $dosen->nama_lengkap }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">NIDN</label>
                        <input type="text" name="nidn" value="{{ $dosen->nidn }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Asal Prodi</label>
                        <select name="asal_prodi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            @foreach (\App\Models\User::where('usertype', 'user')->pluck('name', 'id') as $id => $name)
                                <option value="{{ $id }}" {{ $dosen->asal_prodi == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" @click="open = false"
                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 transition">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Simpan</button>
                    </div>
                </form>
            </div>
        </div> --}}
    </div>
</x-app-layout>
