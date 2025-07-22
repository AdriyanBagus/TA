<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                <table class="min-w-full bg-white border border-gray-500">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border">Nama</th>
                            <th class="px-4 py-2 border">Email</th>
                            <th class="px-4 py-2 border">Role</th>
                            <th class="px-4 py-2 border">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="px-4 py-2 border">{{ $user->name }}</td>
                                <td class="px-4 py-2 border">{{ $user->email }}</td>
                                <td class="px-4 py-2 border">
                                    {{ $user->usertype === 'user' ? 'Admin Prodi' : $user->usertype }}
                                </td>

                                <td class="px-4 py-3 border flex items-center justify-center space-x-6">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('admin.edit-user', $user->id) }}"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                                        Edit
                                    </a>

                                    <!-- Tombol Delete -->
                                    <form method="POST" action="{{ route('admin.delete-user', $user->id) }}"
                                        class="delete-user-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="delete-user-btn bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded"
                                            data-username="{{ $user->name }}">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($users->isEmpty())
                    <p class="text-center text-gray-500 mt-4">Tidak ada pengguna yang terdaftar.</p>
                @endif
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-user-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const form = button.closest('form');
                    const username = button.getAttribute('data-username');

                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: `Akun "${username}" akan dihapus secara permanen!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    @if (session('success-edit'))
        <script>
            Swal.fire({
                title: 'Berhasil Diubah',
                text: '{{ session('success-edit') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
    @if (session('delete'))
        <script>
            Swal.fire({
                title: 'Berhasil Dihapus',
                text: '{{ session('delete') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
</x-app-layout>