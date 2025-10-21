<x-app-layout>
    <x-slot name="header">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Diagram View') }}
            </h2>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Tambah
            </button>
        </div>
    </x-slot>

    <canvas id="kerjasamaChart" width="400" height="200"></canvas>

    <script>
        var ctx = document.getElementById('kerjasamaChart').getContext('2d');
        var data = @json($diagram_view); // Ambil data dari controller

        var chart = new Chart(ctx, {
            type: 'bar', // Jenis chart (bar, line, pie, dll.)
            data: {
                labels: Object.keys(data), // Label kategori (Internasional, Nasional, Lokal)
                datasets: [{
                    label: 'Jumlah Kerjasama',
                    data: Object.values(data), // Jumlah berdasarkan kategori
                    backgroundColor: ['red', 'blue', 'green'], // Warna batang
                }]
            }
        });
    </script>


</x-app-layout>