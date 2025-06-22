<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\PenelitianMahasiswa;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenelitianMahasiswaController extends Controller
{
    public function index(){
        return view('pages.penelitian_mahasiswa');
    }

    public function show(Request $request){
        if (Auth::user()->id) {
            // Ambil daftar tahun akademik
            $tahunList = TahunAkademik::all();
            $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

            $penelitian_mahasiswa = PenelitianMahasiswa::where('user_id', Auth::user()->id)
                ->where('penelitian_mahasiswa.tahun_akademik_id', $tahunTerpilih)
                ->get();

            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            // dan prodi_id yang sesuai dengan user yang sedang login
            $tabel = (new PenelitianMahasiswa())->getTable(); 
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
        return view('pages.penelitian_mahasiswa', compact('penelitian_mahasiswa', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function add(Request $request)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();
        
        PenelitianMahasiswa::create([
            'user_id' => Auth::user()->id,
            'tahun_akademik_id' => $tahunAktif->id,
            'judul_penelitian' => $request->judul_penelitian,
            'nama_mahasiswa' => $request->nama_mahasiswa,
            'nama_pembimbing' => $request->nama_pembimbing,
            'tingkat' => $request->tingkat,
            'sumber_dana' => $request->sumber_dana,
            'bentuk_dana' => $request->bentuk_dana,
            'jumlah_dana' => $request->jumlah_dana,
            'kesesuaian_roadmap' => $request->kesesuaian_roadmap
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();

        $penelitian_mahasiswa = PenelitianMahasiswa::find($id);
        $penelitian_mahasiswa->tahun_akademik_id = $tahunAktif->id;
        $penelitian_mahasiswa->judul_penelitian = $request->judul_penelitian;
        $penelitian_mahasiswa->nama_mahasiswa = $request->nama_mahasiswa;
        $penelitian_mahasiswa->nama_pembimbing = $request->nama_pembimbing;
        $penelitian_mahasiswa->tingkat = $request->tingkat;
        $penelitian_mahasiswa->sumber_dana = $request->sumber_dana;
        $penelitian_mahasiswa->bentuk_dana = $request->bentuk_dana;
        $penelitian_mahasiswa->jumlah_dana = $request->jumlah_dana;
        $penelitian_mahasiswa->kesesuaian_roadmap = $request->kesesuaian_roadmap;
        $penelitian_mahasiswa->user_id = Auth::user()->id;
        $penelitian_mahasiswa->save();

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    
    public function destroy($id)
    {
        $penelitian_mahasiswa = PenelitianMahasiswa::find($id);
        $penelitian_mahasiswa->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function exportCsv()
    {
        $records = PenelitianMahasiswa::where('user_id', Auth::user()->id)
                            ->where('tahun_akademik_id', TahunAkademik::where('is_active', true)->value('id'))
                            ->get();

        $filename = 'Penelitian Mahasiswa_' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'No', 'Judul Penelitian', 'Nama Mahasiswa', 'Nama Pembimbing', 'Tingkat',
            'Sumber Dana', 'Bentuk Dana', 'Jumlah Dana', 'Kesesuaian Roadmap'
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
                    $record->nama_mahasiswa,
                    $record->nama_pembimbing,
                    $record->tingkat,
                    $record->sumber_dana,
                    $record->bentuk_dana,
                    $record->jumlah_dana,
                    $record->kesesuaian_roadmap
                ], ';', '"');
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
