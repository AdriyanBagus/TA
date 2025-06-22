<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\ProfilDosenTidakTetap;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilDosenTidakTetapController extends Controller
{
    public function index(){
        return view('pages.profil_dosen_tidak_tetap');
    }

    public function show(Request $request){
        if (Auth::user()->id) {
            // Ambil daftar tahun akademik
            $tahunList = TahunAkademik::all();
            $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

            $profil_dosen_tidak_tetap = ProfilDosenTidakTetap::where('user_id', Auth::user()->id)
                ->where('profil_dosen_tidak_tetap.tahun_akademik_id', $tahunTerpilih)
                ->get();

            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            // dan prodi_id yang sesuai dengan user yang sedang login
            $tabel = (new ProfilDosenTidakTetap())->getTable(); 
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
        return view('pages.profil_dosen_tidak_tetap', compact('profil_dosen_tidak_tetap', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function add(Request $request)
    {
        $tahunAktif = TahunAkademik::where('is_active', true)->first();

        ProfilDosenTidakTetap::create([
            'user_id' => Auth::user()->id,
            'tahun_akademik_id' => $tahunAktif->id,
            'nama' => $request->nama,
            'asal_instansi' => $request->asal_instansi,
            'kualifikasi_pendidikan' => $request->kualifikasi_pendidikan,
            'sertifikasi_pendidik_profesional' => $request->sertifikasi_pendidik_profesional,
            'status' => $request->status,
            'bidang_keahlian' => $request->bidang_keahlian,
            'bidang_ilmu_prodi' => $request->bidang_ilmu_prodi 
        ]);

        return redirect()->back()->with('success', 'Data Profil Dosen berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $tahunAktif = TahunAkademik::where('is_active', true)->first();

        $profil_dosen_tidak_tetap = ProfilDosenTidakTetap::find($id);
        $profil_dosen_tidak_tetap->tahun_akademik_id = $tahunAktif->id;
        $profil_dosen_tidak_tetap->nama = $request->nama;
        $profil_dosen_tidak_tetap->asal_instansi = $request->asal_instansi;
        $profil_dosen_tidak_tetap->kualifikasi_pendidikan = $request->kualifikasi_pendidikan;
        $profil_dosen_tidak_tetap->sertifikasi_pendidik_profesional = $request->sertifikasi_pendidik_profesional;
        $profil_dosen_tidak_tetap->status = $request->status;
        $profil_dosen_tidak_tetap->bidang_keahlian = $request->bidang_keahlian;
        $profil_dosen_tidak_tetap->bidang_ilmu_prodi = $request->bidang_ilmu_prodi;
        $profil_dosen_tidak_tetap->user_id = Auth::user()->id;
        $profil_dosen_tidak_tetap->save();

        return redirect()->back()->with('success', 'Data Profil Dosen berhasil diubah!');
    }

    public function destroy($id)
    {
        $profil_dosen_tidak_tetap = ProfilDosenTidakTetap::find($id);
        $profil_dosen_tidak_tetap->delete();

        return redirect()->back()->with('success', 'Data Profil Dosen berhasil dihapus!');
    }

    public function exportCsv()
    {
        $records = ProfilDosenTidakTetap::where('user_id', Auth::user()->id)
                            ->where('tahun_akademik_id', TahunAkademik::where('is_active', true)->value('id'))
                            ->get();

        $filename = 'Profil Dosen Tidak Tetap_' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'No', 'Nama', 'Asal Instansi','Kualifikasi Pendidikan', 'Sertifikasi Pendidik Profesional','Status', 'Bidang Keahlian','Bidang Ilmu Prodi'
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
                    $record->nama,
                    $record->asal_instansi,
                    $record->kualifikasi_pendidikan,
                    $record->sertifikasi_pendidik_profesional,
                    $record->status,
                    $record->bidang_keahlian,
                    $record->bidang_ilmu_prodi
                ], ';', '"');
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
