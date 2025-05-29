<?php

namespace App\Http\Controllers;

use App\Models\EvaluasiPelaksanaan;
use App\Models\Komentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluasiPelaksanaanController extends Controller
{
    public function index(){
        return view('pages.evaluasi_pelaksanaan');
    }

    public function show(){
        if (Auth::user()->id) {
            $evaluasi_pelaksanaan = EvaluasiPelaksanaan::where('user_id', Auth::user()->id)->get();

            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            // dan prodi_id yang sesuai dengan user yang sedang login
            $tabel = (new EvaluasiPelaksanaan())->getTable(); 
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
        return view('pages.evaluasi_pelaksanaan', compact('evaluasi_pelaksanaan', 'komentar'));
    }

    public function add(Request $request)
    {
        EvaluasiPelaksanaan::create([
            'user_id' => Auth::user()->id,
            'nomor_ptk' => $request->nomor_ptk,
            'kategori_ptk' => $request->kategori_ptk,
            'rencana_penyelesaian' => $request->rencana_penyelesaian,
            'realisasi_perbaikan' => $request->realisasi_perbaikan,
            'penanggungjawab_perbaikan' => $request->penanggungjawab_perbaikan 
        ]);

        return redirect()->back()->with('success', 'Data Evaluasi Pelaksanaan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $evaluasi_pelaksanaan = EvaluasiPelaksanaan::findOrFail($id);

        $evaluasi_pelaksanaan->nomor_ptk = $request->nomor_ptk;
        $evaluasi_pelaksanaan->kategori_ptk = $request->kategori_ptk;
        $evaluasi_pelaksanaan->rencana_penyelesaian = $request->rencana_penyelesaian;
        $evaluasi_pelaksanaan->realisasi_perbaikan = $request->realisasi_perbaikan;
        $evaluasi_pelaksanaan->penanggungjawab_perbaikan = $request->penanggungjawab_perbaikan;
        $evaluasi_pelaksanaan->user_id = Auth::user()->id;

        $evaluasi_pelaksanaan->save();

        return redirect()->back()->with('success', 'Data Profil Dosen berhasil diubah!');
    }

    
    public function destroy($id)
    {
        $evaluasi_pelaksanaan = EvaluasiPelaksanaan::find($id);
        $evaluasi_pelaksanaan->delete();

        return redirect()->back()->with('success', 'Data Profil Dosen berhasil dihapus!');
    }
}
