<?php

namespace App\Http\Controllers;

use App\Models\EvaluasiPelaksanaan;
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
        }
        return view('pages.evaluasi_pelaksanaan', compact('evaluasi_pelaksanaan'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'nomor_ptk' => 'required',
            'kategori_ptk' => 'required',
            'rencana_penyelesaian' => 'required',
            'realisasi_perbaikan' => 'required',
            'penanggungjawab_perbaikan' => 'required'
        ]);

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
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama' => 'required|string|max:255',
            'kualifikasi_pendidikan' => 'required|string|max:255',
            'sertifikasi_pendidik_profesional' => 'nullable|string|max:255',
            'bidang_keahlian' => 'required|string|max:255',
            'bidang_ilmu_prodi' => 'required|string|max:255',
        ]);

        $evaluasi_pelaksanaan = EvaluasiPelaksanaan::find($id);
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
