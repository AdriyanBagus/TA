<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('INSTRUMEN LAPORAN EVALUASI DIRI INTERNAL') }}
        </h2>
    </x-slot>

    <?php
    $menu = App\Models\menuAdmin::get();
    
    // Warna latar belakang dinamis (loop)
    $colors = ['bg-blue-100', 'bg-green-100', 'bg-yellow-100', 'bg-purple-100', 'bg-pink-100', 'bg-indigo-100'];
    ?>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($menu as $index => $item)
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
