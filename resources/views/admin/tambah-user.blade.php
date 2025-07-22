<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Tambah Akun Prodi') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-xl mx-auto px-6">
            <div class="bg-white p-8 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold text-gray-700 mb-6">Form Registrasi Prodi</h3>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <input type="hidden" name="usertype" value="user">

                    {{-- Name --}}
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Prodi</label>
                        <div class="mt-1 relative">
                            <input id="name" name="name" type="text" value="{{ old('name') }}"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 pl-10"
                                required autofocus autocomplete="name">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5.121 17.804A13.937 13.937 0 0112 15c2.62 0 5.038.755 7.121 2.054M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <div class="mt-1 relative">
                            <input id="email" name="email" type="email" value="{{ old('email') }}"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 pl-10"
                                required autocomplete="username">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12H8m8 0l-8-8m8 8l-8 8" />
                                </svg>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    {{-- Password --}}
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" name="password" type="password"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required autocomplete="new-password">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    {{-- Confirm Password --}}
                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi
                            Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required autocomplete="new-password">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded shadow">
                            Simpan User
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

</x-app-layout>