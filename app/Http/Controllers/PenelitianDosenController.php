<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\PenelitianDosen;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenelitianDosenController extends Controller
{
    public function index(){
        return view('dosen.penelitian_dosen');
    }

    public function show(Request $request){
        if (Auth::user()->id) {
            // Ambil daftar tahun akademik
            $tahunList = TahunAkademik::all();
            $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

            $penelitian_dosen = PenelitianDosen::where('user_id', Auth::user()->id)
                ->where('penelitian_dosen.tahun_akademik_id', $tahunTerpilih)
                ->get();

            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            // dan prodi_id yang sesuai dengan user yang sedang login
            $tabel = (new PenelitianDosen())->getTable(); 
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
        return view('dosen.penelitian_dosen', get_defined_vars());
    }

    public function add(Request $request)
    {
        
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();
        
        PenelitianDosen::create([
            'user_id' => Auth::user()->id,
            'tahun_akademik_id' => $tahunAktif->id,
            'judul_penelitian' => $request->judul_penelitian,
            'nama_dosen_peneliti' => $request->nama_dosen_peneliti,
            'nama_mahasiswa' => $request->nama_mahasiswa,
            'tingkat' => $request->tingkat,
            'sumber_dana' => $request->sumber_dana,
            'bentuk_dana' => $request->bentuk_dana,
            'jumlah_dana' => $request->jumlah_dana,
            'kesesuaian_roadmap' => $request->kesesuaian_roadmap,
            'bentuk_integrasi' => $request->bentuk_integrasi,
            'mata_kuliah' => $request->mata_kuliah,
            'url' => $request->url,
            'parent_id' => Auth::user()->parent_id
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();
        
        $penelitian_dosen = PenelitianDosen::find($id);
        $penelitian_dosen->tahun_akademik_id = $tahunAktif->id;
        $penelitian_dosen->judul_penelitian = $request->judul_penelitian;
        $penelitian_dosen->nama_dosen_peneliti = $request->nama_dosen_peneliti;
        $penelitian_dosen->nama_mahasiswa = $request->nama_mahasiswa;
        $penelitian_dosen->tingkat = $request->tingkat;
        $penelitian_dosen->sumber_dana = $request->sumber_dana;
        $penelitian_dosen->bentuk_dana = $request->bentuk_dana;
        $penelitian_dosen->jumlah_dana = $request->jumlah_dana;
        $penelitian_dosen->kesesuaian_roadmap = $request->kesesuaian_roadmap;
        $penelitian_dosen->bentuk_integrasi = $request->bentuk_integrasi;
        $penelitian_dosen->mata_kuliah = $request->mata_kuliah;
        $penelitian_dosen->url = $request->url;
        $penelitian_dosen->user_id = Auth::user()->id;
        $penelitian_dosen->save();

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    
    public function destroy($id)
    {
        $penelitian_dosen = PenelitianDosen::find($id);
        $penelitian_dosen->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function exportCsv()
    {
        $records = PenelitianDosen::where('user_id', Auth::user()->id)
                            ->where('tahun_akademik_id', TahunAkademik::where('is_active', true)->value('id'))
                            ->get();

        $filename = 'Penelitian Dosen_' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'No', 'Judul Penelitian',
            'Nama Dosen Peneliti', 'Nama Mahasiswa', 'Tingkat',
            'Sumber Dana', 'Bentuk Dana', 'Jumlah Dana',
            'Kesesuaian Roadmap', 'Bentuk Integrasi', 'Mata Kuliah'
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
                    $record->judul_penelitian,
                    $record->nama_dosen_peneliti,
                    $record->nama_mahasiswa,
                    $record->tingkat,
                    $record->sumber_dana,
                    $record->bentuk_dana,
                    $record->jumlah_dana,
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
