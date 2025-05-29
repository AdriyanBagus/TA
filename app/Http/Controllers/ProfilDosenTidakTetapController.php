<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\ProfilDosenTidakTetap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilDosenTidakTetapController extends Controller
{
    public function index(){
        return view('pages.profil_dosen_tidak_tetap');
    }

    public function show(){
        if (Auth::user()->id) {
            $profil_dosen_tidak_tetap = ProfilDosenTidakTetap::where('user_id', Auth::user()->id)->get();

            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            // dan prodi_id yang sesuai dengan user yang sedang login
            $tabel = (new ProfilDosenTidakTetap())->getTable(); 
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
        return view('pages.profil_dosen_tidak_tetap', compact('profil_dosen_tidak_tetap', 'komentar'));
    }

    public function add(Request $request)
    {
        ProfilDosenTidakTetap::create([
            'user_id' => Auth::user()->id,
            'nama' => $request->nama,
            'asal_instansi' => $request->asal_instansi,
            'kualifikasi_pendidikan' => $request->kualifikasi_pendidikan,
            'sertifikasi_pendidik_profesional' => $request->sertifikasi_pendidik_profesional,
            'sertifikat_kompetensi' => $request->sertifikat_kompetensi,
            'bidang_keahlian' => $request->bidang_keahlian,
            'kesesuaian_bidang_ilmu_prodi' => $request->kesesuaian_bidang_ilmu_prodi 
        ]);

        return redirect()->back()->with('success', 'Data Profil Dosen berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $profil_dosen_tidak_tetap = ProfilDosenTidakTetap::find($id);
        $profil_dosen_tidak_tetap->nama = $request->nama;
        $profil_dosen_tidak_tetap->asal_instansi = $request->asal_instansi;
        $profil_dosen_tidak_tetap->kualifikasi_pendidikan = $request->kualifikasi_pendidikan;
        $profil_dosen_tidak_tetap->sertifikasi_pendidik_profesional = $request->sertifikasi_pendidik_profesional;
        $profil_dosen_tidak_tetap->sertifikat_kompetensi = $request->sertifikat_kompetensi;
        $profil_dosen_tidak_tetap->bidang_keahlian = $request->bidang_keahlian;
        $profil_dosen_tidak_tetap->kesesuaian_bidang_ilmu_prodi = $request->kesesuaian_bidang_ilmu_prodi;
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
}
