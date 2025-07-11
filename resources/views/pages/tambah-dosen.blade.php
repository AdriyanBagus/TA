<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Program Studi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow rounded-lg p-8">
                <form method="POST" action="{{ route('tambah-dosen.store') }}">
                    @csrf
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Nama Dosen')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />

                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" required autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="nidn" :value="__('NIDN')" />
                        <x-text-input id="nidn" class="block mt-1 w-full" type="text" name="nidn"
                            :value="old('nidn')" required autocomplete="off" />
                        <x-input-error :messages="$errors->get('nidn')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="kualifikasi_pendidikan" :value="__('Kualifikasi Pendidikan')" />
                        <x-text-input id="kualifikasi_pendidikan" class="block mt-1 w-full" type="text" name="kualifikasi_pendidikan"
                            :value="old('kualifikasi_pendidikan')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('kualifikasi_pendidikan')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="sertifikasi_pendidik_profesional" :value="__('Sertifikasi Pendidik Profesional')" />
                        <select class="block mt-1 w-full" id="sertifikasi_pendidik_profesional" name="sertifikasi_pendidik_profesional" required>
                            <option value="Ya" {{ old('sertifikasi_pendidik_profesional') == 'Ya' ? 'selected' : '' }}>Ya</option>
                            <option value="Tidak" {{ old('sertifikasi_pendidik_profesional') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                        <x-input-error :messages="$errors->get('sertifikasi_pendidik_profesional')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="bidang_keahlian" :value="__('Bidang Keahlian')" />
                        <x-text-input id="bidang_keahlian" class="block mt-1 w-full" type="text" name="bidang_keahlian"
                            :value="old('bidang_keahlian')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('bidang_keahlian')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="bidang_ilmu_prodi" :value="__('Kesesuaian Bidang Ilmu Prodi')" />
                        <select class="block mt-1 w-full" id="bidang_ilmu_prodi" name="bidang_ilmu_prodi" required>
                            <option value="Sesuai" {{ old('bidang_ilmu_prodi') == 'Sesuai' ? 'selected' : '' }}>Sesuai</option>
                            <option value="Tidak Sesuai" {{ old('bidang_ilmu_prodi') == 'Tidak Sesuai' ? 'selected' : '' }}>Tidak Sesuai</option>
                        </select>
                        <x-input-error :messages="$errors->get('bidang_ilmu_prodi')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="jenis_dosen" :value="__('Jenis Dosen')" />
                        <select class="block mt-1 w-full" id="jenis_dosen" name="jenis_dosen" required>
                            <option value="Dosen Tetap" {{ old('jenis_dosen') == 'Dosen Tetap' ? 'selected' : '' }}>Dosen Tetap</option>
                            <option value="Dosen Tidak Tetap" {{ old('jenis_dosen') == 'Dosen Tidak Tetap' ? 'selected' : '' }}>Dosen Tidak Tetap</option>
                        </select>
                        <x-input-error :messages="$errors->get('jenis_dosen')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="status_dosen" :value="__('Status Dosen')" />
                        <select class="block mt-1 w-full" id="status_dosen" name="status_dosen" required>
                            <option value="Dosen Akademik" {{ old('status') == 'Dosen Akademik' ? 'selected' : '' }}>Dosen Akademik</option>
                            <option value="Dosen Praktisi" {{ old('status') == 'Dosen Praktisi' ? 'selected' : '' }}>Dosen Praktisi</option>
                        </select>
                        <x-input-error :messages="$errors->get('status_dosen')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">

                        <x-primary-button class="ms-4">
                            {{ __('Tambah') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
