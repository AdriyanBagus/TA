<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\TahunAkademik;
use App\Models\BimbinganTaDosen; // Menggunakan Model baru
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelaksanaanTaController extends Controller
{
    /**
     * Fungsi 'show' yang bekerja sebagai "Detektif Pribadi".
     */
    public function show(Request $request)
    {
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $user = Auth::user();
        $prodiList = User::where('usertype', 'dosen')->pluck('bidang_ilmu_prodi')->unique()->sort();

        // TUGAS #1: Menerima "Daftar Tugas"
        $namaMahasiswaTerkait = BimbinganTaDosen::where('user_id', $user->id)
            ->where('tahun_akademik_id', $tahunTerpilih)
            ->pluck('nama_mahasiswa')
            ->unique();

        if ($namaMahasiswaTerkait->isEmpty()) {
            return view('dosen.pelaksanaan_ta', [
                'list_bimbingan_final' => [],
                'rekap' => ['ps_sendiri' => 0, 'ps_lain' => 0, 'sebagai_dospem_1' => 0, 'sebagai_dospem_2' => 0, 'total_bimbingan' => 0],
                'komentar' => collect(), 'tahunList' => $tahunList,
                'tahunTerpilih' => $tahunTerpilih, 'prodiList' => $prodiList
            ]);
        }

        // TUGAS #2: Mengumpulkan semua "bukti" terkait
        $potongan_puzzle = BimbinganTaDosen::where('tahun_akademik_id', $tahunTerpilih)
            ->whereIn('nama_mahasiswa', $namaMahasiswaTerkait)
            ->with('user')
            ->get();

        // TUGAS #3: Menyusun "laporan"
        $bimbinganTersusun = [];
        foreach ($potongan_puzzle as $potongan) {
            $namaMahasiswa = $potongan->nama_mahasiswa;
            if (!isset($bimbinganTersusun[$namaMahasiswa])) {
                $bimbinganTersusun[$namaMahasiswa] = [
                    'nama_mahasiswa' => $namaMahasiswa, 'prodi_mahasiswa' => $potongan->prodi_mahasiswa,
                    'dosen_pembimbing_1' => null, 'dosen_pembimbing_2' => null,
                    'id_dospem_1' => null, 'id_dospem_2' => null,
                ];
            }
            if ($potongan->posisi_dosen == 'Dospem 1') {
                $bimbinganTersusun[$namaMahasiswa]['dosen_pembimbing_1'] = $potongan->user->name;
                $bimbinganTersusun[$namaMahasiswa]['id_dospem_1'] = $potongan->id;
            } elseif ($potongan->posisi_dosen == 'Dospem 2') {
                $bimbinganTersusun[$namaMahasiswa]['dosen_pembimbing_2'] = $potongan->user->name;
                $bimbinganTersusun[$namaMahasiswa]['id_dospem_2'] = $potongan->id;
            }
        }
        $list_bimbingan_final = array_values($bimbinganTersusun);

        // TUGAS #4: Menghitung rekapitulasi
        $rekap = [
            'ps_sendiri' => 0, 'ps_lain' => 0, 'sebagai_dospem_1' => 0,
            'sebagai_dospem_2' => 0, 'total_bimbingan' => count($list_bimbingan_final),
        ];
        $prodiDosen = $user->bidang_ilmu_prodi;
        foreach ($list_bimbingan_final as $bimbingan) {
            if (trim(strtolower($bimbingan['prodi_mahasiswa'])) == trim(strtolower($prodiDosen))) { $rekap['ps_sendiri']++; } else { $rekap['ps_lain']++; }
            if ($bimbingan['dosen_pembimbing_1'] == $user->name) { $rekap['sebagai_dospem_1']++; }
            if ($bimbingan['dosen_pembimbing_2'] == $user->name) { $rekap['sebagai_dospem_2']++; }
        }

        $tabel = 'bimbingan_ta_dosen';
        $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', $user->parent_id)->get();
        
        return view('dosen.pelaksanaan_ta', compact('list_bimbingan_final', 'rekap', 'komentar', 'tahunList', 'tahunTerpilih', 'prodiList'));
    }

    /**
     * Fungsi 'store' yang sudah direnovasi.
     */
    public function store(Request $request)
    {
        $request->validate(['nama_mahasiswa' => 'required|string|max:255', 'prodi_mahasiswa' => 'required|string|max:255', 'posisi_dosen' => 'required|string']);
        $tahunAktif = TahunAkademik::where('is_active', true)->first();
        BimbinganTaDosen::updateOrCreate(
            [ 'user_id' => Auth::id(), 'tahun_akademik_id' => $tahunAktif->id, 'nama_mahasiswa' => $request->nama_mahasiswa, ],
            [ 'prodi_mahasiswa' => $request->prodi_mahasiswa, 'posisi_dosen' => $request->posisi_dosen, ]
        );
        return redirect()->route('dosen.pelaksanaan_ta.show')->with('success', 'Data Bimbingan Mahasiswa berhasil disimpan!');
    }

    /**
     * Fungsi 'update' yang baru untuk mengedit potongan puzzle.
     */
    public function update(Request $request, $id)
    {
        $request->validate(['nama_mahasiswa' => 'required|string|max:255', 'prodi_mahasiswa' => 'required|string|max:255', 'posisi_dosen' => 'required|string']);
        $potongan_puzzle = BimbinganTaDosen::findOrFail($id);
        if ($potongan_puzzle->user_id != Auth::id()) { abort(403); }
        $potongan_puzzle->update($request->all());
        return redirect()->route('dosen.pelaksanaan_ta.show')->with('success', 'Data Bimbingan Mahasiswa berhasil diubah!');
    }

    /**
     * Fungsi 'destroy' yang baru untuk menghapus potongan puzzle.
     */
    public function destroy($id)
    {
        $potongan_puzzle = BimbinganTaDosen::findOrFail($id);
        if ($potongan_puzzle->user_id != Auth::id()) { abort(403); }
        $potongan_puzzle->delete();
        return redirect()->route('dosen.pelaksanaan_ta.show')->with('success', 'Data Bimbingan Mahasiswa berhasil dihapus!');
    }

    /**
     * Gemi's Edit: Membangun "Pabrik CSV" baru dari nol.
     */
    public function exportCsv(Request $request)
    {
        // Logikanya meniru fungsi show() untuk mendapatkan data yang benar
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $user = Auth::user();

        $namaMahasiswaTerkait = BimbinganTaDosen::where('user_id', $user->id)
            ->where('tahun_akademik_id', $tahunTerpilih)
            ->pluck('nama_mahasiswa')->unique();

        if ($namaMahasiswaTerkait->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data untuk diekspor.');
        }

        $potongan_puzzle = BimbinganTaDosen::where('tahun_akademik_id', $tahunTerpilih)
            ->whereIn('nama_mahasiswa', $namaMahasiswaTerkait)
            ->with('user')->get();

        $bimbinganTersusun = [];
        foreach ($potongan_puzzle as $potongan) {
            $namaMahasiswa = $potongan->nama_mahasiswa;
            if (!isset($bimbinganTersusun[$namaMahasiswa])) {
                $bimbinganTersusun[$namaMahasiswa] = [
                    'nama_mahasiswa' => $namaMahasiswa, 'prodi_mahasiswa' => $potongan->prodi_mahasiswa,
                    'dosen_pembimbing_1' => null, 'dosen_pembimbing_2' => null,
                ];
            }
            if ($potongan->posisi_dosen == 'Dospem 1') { $bimbinganTersusun[$namaMahasiswa]['dosen_pembimbing_1'] = $potongan->user->name; }
            elseif ($potongan->posisi_dosen == 'Dospem 2') { $bimbinganTersusun[$namaMahasiswa]['dosen_pembimbing_2'] = $potongan->user->name; }
        }
        $records = array_values($bimbinganTersusun);

        // Proses pembuatan file CSV
        $filename = 'Pelaksanaan_TA_' . date('Y-m-d') . '.csv';
        $headers = [ "Content-type" => "text/csv", "Content-Disposition" => "attachment; filename=$filename", "Pragma" => "no-cache", "Cache-Control" => "must-revalidate, post-check=0, pre-check=0", "Expires" => "0" ];
        $columns = ['No', 'Nama Mahasiswa', 'Prodi Mahasiswa', 'Dosen Pembimbing 1', 'Dosen Pembimbing 2'];

        $callback = function() use ($records, $columns) {
            $handle = fopen('php://output', 'w');
            echo chr(239) . chr(187) . chr(191);
            fputcsv($handle, $columns, ';', '"');
            $no = 1;
            foreach ($records as $record) {
                fputcsv($handle, [
                    $no++,
                    $record['nama_mahasiswa'],
                    $record['prodi_mahasiswa'],
                    $record['dosen_pembimbing_1'] ?? '-',
                    $record['dosen_pembimbing_2'] ?? '-',
                ], ';', '"');
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
