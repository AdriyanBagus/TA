<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\ProfilDosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilDosenController extends Controller
{
    public function index(){
        return view('pages.profil_dosen');
    }

    public function show(){
        if (Auth::user()->id) {
            $profil_dosen = ProfilDosen::where('user_id', Auth::user()->id)->get();

            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            // dan prodi_id yang sesuai dengan user yang sedang login
            $tabel = (new ProfilDosen())->getTable(); 
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
        return view('pages.profil_dosen', compact('profil_dosen', 'komentar'));
    }

    public function add(Request $request)
    {
        ProfilDosen::create([
            'user_id' => Auth::user()->id,
            'nama' => $request->nama,
            'nidn' => $request->nidn,
            'kualifikasi_pendidikan' => $request->kualifikasi_pendidikan,
            'sertifikasi_pendidik_profesional' => $request->sertifikasi_pendidik_profesional,
            'bidang_keahlian' => $request->bidang_keahlian,
            'bidang_ilmu_prodi' => $request->bidang_ilmu_prodi 
        ]);

        return redirect()->back()->with('success', 'Data Profil Dosen berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $profil_dosen = ProfilDosen::find($id);
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
        $profil_dosen = ProfilDosen::find($id);
        $profil_dosen->delete();

        return redirect()->back()->with('success', 'Data Profil Dosen berhasil dihapus!');
    }
}
