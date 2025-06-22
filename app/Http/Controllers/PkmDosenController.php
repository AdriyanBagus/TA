<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\PkmDosen;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PkmDosenController extends Controller
{
    public function index()
    {
        return view('pages.pkm_dosen');
    }

    public function show(Request $request)
    {
        if (Auth::user()->id) {
            // Ambil daftar tahun akademik
            $tahunList = TahunAkademik::all();
            $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
            
            $pkm_dosen = PkmDosen::where('user_id', Auth::user()->id)
                ->where('pkm_dosen.tahun_akademik_id', $tahunTerpilih)
                ->get();

            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            // dan prodi_id yang sesuai dengan user yang sedang login
            $tabel = (new PkmDosen())->getTable(); 
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
    
        return view('pages.pkm_dosen', compact('pkm_dosen', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function add(Request $request)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();

        PkmDosen::create([
            'user_id' => Auth::user()->id,
            'tahun_akademik_id' => $tahunAktif->id,
            'judul_pkm' => $request->judul_pkm,
            'dosen' => $request->dosen,
            'mahasiswa' => $request->mahasiswa,
            'tingkat' => $request->tingkat,
            'sumber_dana' => $request->sumber_dana,
            'kesesuaian_roadmap' => $request->kesesuaian_roadmap,
            'bentuk_integrasi' => $request->bentuk_integrasi,
            'mata_kuliah' => $request->mata_kuliah
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();

        $pkm_dosen = PkmDosen::find($id);
        $pkm_dosen->tahun_akademik_id = $tahunAktif->id;
        $pkm_dosen->judul_pkm = $request->judul_pkm;
        $pkm_dosen->dosen = $request->dosen;
        $pkm_dosen->mahasiswa = $request->mahasiswa;
        $pkm_dosen->tingkat = $request->tingkat;
        $pkm_dosen->sumber_dana = $request->sumber_dana;
        $pkm_dosen->kesesuaian_roadmap = $request->kesesuaian_roadmap;
        $pkm_dosen->bentuk_integrasi = $request->bentuk_integrasi;
        $pkm_dosen->mata_kuliah = $request->mata_kuliah;
        $pkm_dosen->user_id = Auth::user()->id;
        $pkm_dosen->save();

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $pkm_dosen = PkmDosen::find($id);
        $pkm_dosen->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function exportCsv()
    {
        $records = PkmDosen::where('user_id', Auth::user()->id)
                            ->where('tahun_akademik_id', TahunAkademik::where('is_active', true)->value('id'))
                            ->get();

        $filename = 'PKM Dosen_' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'No', 'Judul PKM', 'Dosen','Mahasiswa', 'Tingkat', 'Sumber Dana','Kesesuaian Roadmap', 'Bentuk Integrasi', 'Mata Kuliah'
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
                    $record->judul_pkm,
                    $record->dosen,
                    $record->mahasiswa,
                    $record->tingkat,
                    $record->sumber_dana,
                    $record->kesesuaian_roadmap,
                    $record->bentuk_integrasi,
                    $record->mata_kuliah
                ], ';', '"');
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
