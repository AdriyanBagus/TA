<x-app-layout>
    <?php
$tahunAktif = App\Models\TahunAkademik::where('is_active', true)->first();

$isExpired = $tahunAktif && (
    now()->lt($tahunAktif->tanggal_mulai) ||
    now()->gt($tahunAktif->tanggal_batas_pengisian)
);
?>


    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Instrumen Laporan Evaluasi Diri Internal') }}
            </h2>

            @if ($tahunAktif)
            <div class="text-sm text-gray-600 text-right">
                <div><strong>Periode:</strong></div>
                <div>
                    {{ \Carbon\Carbon::parse($tahunAktif->tanggal_mulai)->translatedFormat('d F Y') }}
                    -
                    {{ \Carbon\Carbon::parse($tahunAktif->tanggal_batas_pengisian)->translatedFormat('d F Y') }}
                    @if(now()->gt($tahunAktif->tanggal_batas_pengisian))
                        <span class="text-red-600 font-semibold"> (Sudah Lewat)</span>
                    @elseif(now()->lt($tahunAktif->tanggal_mulai))
                        <span class="text-orange-600 font-semibold"> (Belum Dimulai)</span>
                    @endif
                </div>
            </div>
        @endif
        </div>
    </x-slot>

    <?php
$menu = App\Models\Menu::get();

// Warna latar belakang dinamis (loop)
$colors = ['bg-blue-100', 'bg-green-100', 'bg-yellow-100', 'bg-purple-100', 'bg-pink-100', 'bg-indigo-100'];
    ?>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($menu as $index => $item)
                        @if ($isExpired)
                            <div
                                class="rounded-xl shadow-md p-5 flex flex-col {{ $colors[$index % count($colors)] }} opacity-50 cursor-not-allowed">
                                <div class="mb-2 text-sm text-gray-700 font-semibold uppercase tracking-wide flex-1">
                                    {{ $item->menu_id }}
                                </div>
                                <div class="text-sm font-bold text-gray-900 flex-1">
                                    {{ $item->menu }}
                                </div>
                            </div>
                        @else
                            <a href="{{ route($item->link) }}"
                                class="transition duration-300 ease-in-out transform hover:-translate-y-1">
                                <div class="rounded-xl shadow-md p-5 flex flex-col {{ $colors[$index % count($colors)] }} hover:shadow-xl"
                                    style="height: 100%;">
                                    <div class="mb-2 text-sm text-gray-700 font-semibold uppercase tracking-wide flex-1">
                                        {{ $item->menu_id }}
                                    </div>
                                    <div class="text-sm font-bold text-gray-900 flex-1">
                                        {{ $item->menu }}
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>


            </div>
        </div>
    </div>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            })
        </script>
    @endif
</x-app-layout>