<?php

namespace App\Http\Controllers;

use App\Models\BebanKinerjaDosen;
use App\Models\Komentar;
use App\Models\ProfilDosen;
use App\Models\RekognisiDosen;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdiController extends Controller
{
    public function bebankinerjadosen(Request $request)
    {

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        $beban_kinerja_dosen = BebanKinerjaDosen::where('parent_id', Auth::user()->id)
                ->where('beban_kinerja_dosen.tahun_akademik_id', $tahunTerpilih)
                ->get();

        //Komentar
        $tabel = (new BebanKinerjaDosen())->getTable();
        $dosen = User::select('id', 'name')
            ->where('usertype', 'dosen')
            ->where('parent_id', Auth::user()->id)
            ->get(); 
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('pages.beban_kinerja_dosen', get_defined_vars());
    }

    public function rekognisidosen(Request $request)
    {
        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        $rekognisi_dosen = RekognisiDosen::where('parent_id', Auth::user()->id)
                ->where('rekognisi_dosen.tahun_akademik_id', $tahunTerpilih)
                ->get();

        //Komentar
        $tabel = (new RekognisiDosen())->getTable();
        $dosen = User::select('id', 'name')
            ->where('usertype', 'dosen')
            ->where('parent_id', Auth::user()->id)
            ->get(); 
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('pages.rekognisi_dosen', get_defined_vars());
    }

    
}
