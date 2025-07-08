<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\ProfilDosen;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdiController extends Controller
{
    public function profildosen(Request $request)
    {

        // // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        // $tahunList = TahunAkademik::all();
        // $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        // $profil_dosen = ProfilDosen::where('parent_id', Auth::user()->id)
        //         ->where('profil_dosen.tahun_akademik_id', $tahunTerpilih)
        //         ->get();

        // //Komentar
        // $tabel = (new ProfilDosen())->getTable(); 
        // $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();;

        // return view('admin.analisis.visimisi', compact('visimisi', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function bebankinerjadosen(Request $request)
    {
        // // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        // $tahunList = TahunAkademik::all();
        // $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        // $beban_kinerja_dosen = BebanKinerjaDosen::where('parent_id', Auth::user()->id)
        //         ->where('beban_kinerja_dosen.tahun_akademik_id', $tahunTerpilih)
        //         ->get();

        // //Komentar
        // $tabel = (new BebanKinerjaDosen())->getTable(); 
        // $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();;

        // return view('admin.analisis.visimisi', compact('visimisi', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    
}
