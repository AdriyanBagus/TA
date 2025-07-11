<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\ProfilDosen;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilDosenController extends Controller
{
    public function index(){
        return view('dosen.profil_dosen');
    }

    public function show(Request $request){
        if (Auth::user()->id) {
            // Ambil daftar tahun akademik
            $tahunList = TahunAkademik::all();
            $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
            
            $profil_dosen = ProfilDosen::where('user_id', Auth::user()->id)
                ->where('profil_dosen.tahun_akademik_id', $tahunTerpilih)
                ->get();

            // Cek apakah sudah ada data
            $sudahAdaData = ProfilDosen::where('user_id', Auth::user()->id)
                ->where('profil_dosen.tahun_akademik_id', $tahunTerpilih)
                ->exists();
            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            // dan prodi_id yang sesuai dengan user yang sedang login
            $tabel = (new ProfilDosen())->getTable(); 
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
        return view('dosen.profil_dosen', get_defined_vars());
    }

    public function add(Request $request)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();

        ProfilDosen::create([
            'user_id' => Auth::user()->id,
            'tahun_akademik_id' => $tahunAktif->id,
            'nama' => $request->nama,
            'nidn' => $request->nidn,
            'kualifikasi_pendidikan' => $request->kualifikasi_pendidikan,
            'sertifikasi_pendidik_profesional' => $request->sertifikasi_pendidik_profesional,
            'bidang_keahlian' => $request->bidang_keahlian,
            'bidang_ilmu_prodi' => $request->bidang_ilmu_prodi,
            'parent_id' => Auth::user()->parent_id
        ]);

        return redirect()->back()->with('success', 'Data Profil Dosen berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();

        $profil_dosen = ProfilDosen::find($id);
        $profil_dosen->tahun_akademik_id = $tahunAktif->id;
        $profil_dosen->nama = $request->nama;
        $profil_dosen->nidn = $request->nidn;
        $profil_dosen->kualifikasi_pendidikan = $request->kualifikasi_pendidikan;
        $profil_dosen->sertifikasi_pendidik_profesional = $request->sertifikasi_pendidik_profesional;
        $profil_dosen->bidang_keahlian = $request->bidang_keahlian;
        $profil_dosen->bidang_ilmu_prodi = $request->bidang_ilmu_prodi;
        $profil_dosen->user_id = Auth::user()->id;
        $profil_dosen->save();

        return redirect()->back()->with('success', 'Data Profil Dosen berhasil diubah!');
    }

    
    public function destroy($id)
    {
        $profil_dosen = ProfilDosen::where('user_id', Auth::user()->id)
                                   ->find($id);
        $profil_dosen->delete();

        return redirect()->back()->with('success', 'Data Profil Dosen berhasil dihapus!');
    }

    public function exportCsv()
    {
        $records = ProfilDosen::where('user_id', Auth::user()->id)
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
