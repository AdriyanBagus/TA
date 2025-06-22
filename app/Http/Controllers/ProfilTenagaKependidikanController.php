<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\ProfilTenagaKependidikan;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilTenagaKependidikanController extends Controller
{
    public function index(){
        return view('pages.profil_tenaga_kependidikan');
    }

    public function show(Request $request){
        if (Auth::user()->id) {
            // Ambil daftar tahun akademik
            $tahunList = TahunAkademik::all();
            $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

            $profil_tenaga_kependidikan = ProfilTenagaKependidikan::where('user_id', Auth::user()->id)
                ->where('profil_tenaga_kependidikan.tahun_akademik_id', $tahunTerpilih)
                ->get();

            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            $tabel = (new ProfilTenagaKependidikan())->getTable(); 
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
        return view('pages.profil_tenaga_kependidikan', compact('profil_tenaga_kependidikan', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function add(Request $request)
    {   
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();

        ProfilTenagaKependidikan::create([
            'user_id' => Auth::user()->id,
            'tahun_akademik_id' => $tahunAktif->id,
            'nama' => $request->nama,
            'nipy' => $request->nipy,
            'kualifikasi_pendidikan' => $request->kualifikasi_pendidikan,
            'bidang_keahlian' => $request->bidang_keahlian,
            'jabatan' => $request->jabatan,
            'kesesuaian_bidang_kerja' => $request->kesesuaian_bidang_kerja,
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();

        $profil_tenaga_kependidikan = ProfilTenagaKependidikan::find($id);
        $profil_tenaga_kependidikan->nama = $request->nama;
        $profil_tenaga_kependidikan->nipy = $request->nipy;
        $profil_tenaga_kependidikan->tahun_akademik_id = $tahunAktif->id;
        $profil_tenaga_kependidikan->kualifikasi_pendidikan = $request->kualifikasi_pendidikan;
        $profil_tenaga_kependidikan->jabatan = $request->jabatan;
        $profil_tenaga_kependidikan->bidang_keahlian = $request->bidang_keahlian;
        $profil_tenaga_kependidikan->kesesuaian_bidang_kerja = $request->kesesuaian_bidang_kerja;
        $profil_tenaga_kependidikan->user_id = Auth::user()->id;
        $profil_tenaga_kependidikan->save();

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $profil_tenaga_kependidikan = ProfilTenagaKependidikan::find($id);
        $profil_tenaga_kependidikan->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function exportCsv()
    {
        $records = ProfilTenagaKependidikan::where('user_id', Auth::user()->id)
                            ->where('tahun_akademik_id', TahunAkademik::where('is_active', true)->value('id'))
                            ->get();

        $filename = 'Profil Tenaga Kependidikan_' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'No', 'Nama', 'NIPY','Kualifikasi Pendidikan', 'Jabatan', 'Bidang Keahlian','Kesesuaian Bidang Kerja'
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
                    $record->nipy,
                    $record->kualifikasi_pendidikan,
                    $record->jabatan,
                    $record->bidang_keahlian,
                    $record->kesesuaian_bidang_kerja
                ], ';', '"');
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
