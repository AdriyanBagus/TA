<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900 leading-tight text-center tracking-wide">
            {{ __('Pengaturan Form User') }}
        </h2>
    </x-slot>

    <div class="py-7 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-2xl p-8">
                <table class="min-w-full border-collapse border border-gray-300 rounded-xl overflow-hidden text-sm">
                    <thead class="bg-indigo-600 text-white uppercase text-xs tracking-wider select-none">
                        <tr>
                            <th class="px-6 py-4 border border-indigo-700 font-semibold text-center">Nama Form</th>
                            <th class="px-6 py-4 border border-indigo-700 font-semibold text-center">Pilih User</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($forms as $form)
                            <tr class="hover:bg-indigo-50 transition-colors duration-200 cursor-pointer">
                                <td
                                    class="px-6 py-4 border border-gray-300 font-medium text-gray-700 text-center uppercase ">
                                    {{ $form->form_name }}</td>

                                <td class="px-6 py-4 border border-gray-300 text-center">
                                    <form id="form-{{ $form->id }}"
                                        action="{{ route('form.settings.update', $form->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        <input type="hidden" name="status" value="{{ $form->status }}">

                                        <button type="button" onclick="openModal({{ $form->id }})"
                                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
                                            Pilih User
                                        </button>

                                        <div id="selected-users-{{ $form->id }}"></div>

                                        {{-- Modal --}}
                                        <div id="modal-{{ $form->id }}"
                                            class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 transition-opacity duration-300">
                                            <div
                                                class="bg-white rounded-2xl w-full max-w-md p-8 shadow-2xl relative animate-fadeIn">
                                                <h3 class="text-xl font-semibold mb-6 text-gray-900 border-b pb-3">Pilih
                                                    User</h3>
                                                <div class="max-h-72 overflow-y-auto space-y-3">
                                                    @foreach ($users as $user)
                                                        {{-- Checkbox Prodi --}}
                                                        <label
                                                            class="flex items-center space-x-3 cursor-pointer hover:bg-indigo-100 rounded-md p-2">
                                                            <input type="checkbox" value="{{ $user->id }}"
                                                                class="form-checkbox h-5 w-5 text-indigo-600 transition user-checkbox-{{ $form->id }} prodi-checkbox"
                                                                data-form-id="{{ $form->id }}"
                                                                data-prodi-id="{{ $user->id }}"
                                                                {{ in_array($user->id, $selectedUsers[$form->id] ?? []) ? 'checked' : '' }}>
                                                            <span
                                                                class="text-gray-700 select-none font-semibold">{{ $user->name }}</span>
                                                        </label>

                                                        {{-- Input Hidden untuk Dosen --}}
                                                        @foreach ($user->dosen as $dosen)
                                                            <input type="hidden" value="{{ $dosen->id }}"
                                                                class="dosen-hidden-checkbox dosen-of-{{ $form->id }}-{{ $user->id }}"
                                                                data-form-id="{{ $form->id }}"
                                                                data-prodi-id="{{ $user->id }}"
                                                                {{ in_array($dosen->id, $selectedUsers[$form->id] ?? []) ? 'data-checked=true' : '' }}>
                                                        @endforeach
                                                    @endforeach
                                                </div>

                                                <div class="mt-6 flex justify-end space-x-3">
                                                    <button type="button" onclick="closeModal({{ $form->id }})"
                                                        class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold transition">
                                                        Batal
                                                    </button>
                                                    <button type="button" onclick="saveAndSubmit({{ $form->id }})"
                                                        class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-semibold transition">
                                                        Simpan
                                                    </button>
                                                </div>

                                                {{-- Close button top-right --}}
                                                <button type="button" onclick="closeModal({{ $form->id }})"
                                                    aria-label="Close modal"
                                                    class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 focus:outline-none">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease forwards;
        }
    </style>

    <script>
        function openModal(formId) {
            const modal = document.getElementById(`modal-${formId}`);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            // Focus first checkbox inside modal for better accessibility
            const firstCheckbox = modal.querySelector('input[type=checkbox]');
            if (firstCheckbox) firstCheckbox.focus();
        }

        function closeModal(formId) {
            const modal = document.getElementById(`modal-${formId}`);
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function saveAndSubmit(formId) {
            const checkboxes = document.querySelectorAll(`.user-checkbox-${formId}`);
            const selectedUsers = document.getElementById(`selected-users-${formId}`);

            // Clear existing hidden inputs
            selectedUsers.innerHTML = '';

            checkboxes.forEach(cb => {
                if (cb.checked) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'users[]';
                    input.value = cb.value;
                    selectedUsers.appendChild(input);
                }
            });

            closeModal(formId);

            // Submit form
            document.getElementById(`form-${formId}`).submit();
        }
    </script>
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Berhasil Diubah',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
</x-app-layout>
