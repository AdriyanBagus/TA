<?php

namespace App\Http\Controllers;

use App\Models\EvaluasiPelaksanaan;
use App\Models\Komentar;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluasiPelaksanaanController extends Controller
{
    public function index(){
        return view('pages.evaluasi_pelaksanaan');
    }

    public function show(Request $request){
        if (Auth::user()->id) {
            // Ambil daftar tahun akademik
            $tahunList = TahunAkademik::all();
            $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

            $evaluasi_pelaksanaan = EvaluasiPelaksanaan::where('user_id', Auth::user()->id)
                ->where('evaluasi_pelaksanaan.tahun_akademik_id', $tahunTerpilih)
                ->get();

            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            // dan prodi_id yang sesuai dengan user yang sedang login
            $tabel = (new EvaluasiPelaksanaan())->getTable(); 
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
        return view('pages.evaluasi_pelaksanaan', compact('evaluasi_pelaksanaan', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function add(Request $request)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();

        EvaluasiPelaksanaan::create([
            'user_id' => Auth::user()->id,
            'tahun_akademik_id' => $tahunAktif->id,
            'nomor_ptk' => $request->nomor_ptk,
            'kategori_ptk' => $request->kategori_ptk,
            'rencana_penyelesaian' => $request->rencana_penyelesaian,
            'realisasi_perbaikan' => $request->realisasi_perbaikan,
            'penanggungjawab_perbaikan' => $request->penanggungjawab_perbaikan 
        ]);

        return redirect()->back()->with('success', 'Data Evaluasi Pelaksanaan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();
        $evaluasi_pelaksanaan = EvaluasiPelaksanaan::findOrFail($id);
        $evaluasi_pelaksanaan->tahun_akademik_id = $tahunAktif->id;
        $evaluasi_pelaksanaan->nomor_ptk = $request->nomor_ptk;
        $evaluasi_pelaksanaan->kategori_ptk = $request->kategori_ptk;
        $evaluasi_pelaksanaan->rencana_penyelesaian = $request->rencana_penyelesaian;
        $evaluasi_pelaksanaan->realisasi_perbaikan = $request->realisasi_perbaikan;
        $evaluasi_pelaksanaan->penanggungjawab_perbaikan = $request->penanggungjawab_perbaikan;
        $evaluasi_pelaksanaan->user_id = Auth::user()->id;

        $evaluasi_pelaksanaan->save();

        return redirect()->back()->with('success', 'Data Profil Dosen berhasil diubah!');
    }

    
    public function destroy($id)
    {
        $evaluasi_pelaksanaan = EvaluasiPelaksanaan::find($id);
        $evaluasi_pelaksanaan->delete();

        return redirect()->back()->with('success', 'Data Profil Dosen berhasil dihapus!');
    }

    public function exportCsv()
    {
        $records = EvaluasiPelaksanaan::where('user_id', Auth::user()->id)
                            ->where('tahun_akademik_id', TahunAkademik::where('is_active', true)->value('id'))
                            ->get();

        $filename = 'Evaluasi Pelaksanaan_' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'No', 'Nomor PTK', 'Kategori PTK', 'Rencana Penyelesaian', 'Realisasi Perbaikan', 'Penanggung Jawab Perbaikan '
        ];

        $callback = function() use ($records, $columns) {
            $handle = fopen('php://output', 'w');

            // Tambahkan BOM di awal file (Byte Order Mark)
            echo chr(239) . chr(187) . chr(191);

            fputcsv($handle, $columns, ';', '"');

            $no = 1;
            foreach ($records as $record) {
                fputcsv($handle, [
                    $no++,
                    $record->nomor_ptk,
                    $record->kategori_ptk,
                    $record->rencana_penyelesaian,
                    $record->realisasi_perbaikan,
                    $record->penanggungjawab_perbaikan
                ], ';', '"');
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
