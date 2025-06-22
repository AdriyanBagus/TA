<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\PkmMahasiswa;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PkmMahasiswaController extends Controller
{
    public function index()
    {
        return view('pages.pkm_mahasiswa');
    }

    public function show(Request $request)
    {
        if (Auth::user()->id) {
            // Ambil daftar tahun akademik
            $tahunList = TahunAkademik::all();
            $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

            $pkm_mahasiswa = PkmMahasiswa::where('user_id', Auth::user()->id)
                ->where('pkm_mahasiswa.tahun_akademik_id', $tahunTerpilih)
                ->get();

            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            // dan prodi_id yang sesuai dengan user yang sedang login
            $tabel = (new PkmMahasiswa())->getTable(); 
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
    
        return view('pages.pkm_mahasiswa', compact('pkm_mahasiswa', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function add(Request $request)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();

        PkmMahasiswa::create([
            'user_id' => Auth::user()->id,
            'tahun_akademik_id' => $tahunAktif->id,
            'mahasiswa' => $request->mahasiswa,
            'pembimbing' => $request->pembimbing,
            'judul_pkm' => $request->judul_pkm,
            'tingkat' => $request->tingkat,
            'sumber_dana' => $request->sumber_dana,
            'kesesuaian_roadmap' => $request->kesesuaian_roadmap
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();

        $pkm_mahasiswa = PkmMahasiswa::find($id);
        $pkm_mahasiswa->tahun_akademik_id = $tahunAktif->id;
        $pkm_mahasiswa->mahasiswa = $request->mahasiswa;
        $pkm_mahasiswa->pembimbing = $request->pembimbing;
        $pkm_mahasiswa->judul_pkm = $request->judul_pkm;
        $pkm_mahasiswa->tingkat = $request->tingkat;
        $pkm_mahasiswa->sumber_dana = $request->sumber_dana;
        $pkm_mahasiswa->kesesuaian_roadmap = $request->kesesuaian_roadmap;
        $pkm_mahasiswa->user_id = Auth::user()->id;
        $pkm_mahasiswa->save();

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $pkm_mahasiswa = PkmMahasiswa::find($id);
        $pkm_mahasiswa->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function exportCsv()
    {
        $records = PkmMahasiswa::where('user_id', Auth::user()->id)
                            ->where('tahun_akademik_id', TahunAkademik::where('is_active', true)->value('id'))
                            ->get();

        $filename = 'PKM Mahasiswa_' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'No', 'Mahasiswa', 'Pembimbing','Judul PKM', 'Tingkat', 'Sumber Dana','Kesesuaian Roadmap'
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
                    $record->mahasiswa,
                    $record->pembimbing,
                    $record->judul_pkm,
                    $record->tingkat,
                    $record->sumber_dana,
                    $record->kesesuaian_roadmap
                ], ';', '"');
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
