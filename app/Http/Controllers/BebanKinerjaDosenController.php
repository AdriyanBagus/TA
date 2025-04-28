<?php

namespace App\Http\Controllers;

use App\Models\BebanKinerjaDosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BebanKinerjaDosenController extends Controller
{
    public function index(){
        return view('pages.beban_kinerja_dosen');
    }

    public function show(){
        if (Auth::user()->id) {
            $beban_kinerja_dosen = BebanKinerjaDosen::where('user_id', Auth::user()->id)->get();
        }
        return view('pages.beban_kinerja_dosen', compact('beban_kinerja_dosen'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nidn' => 'required',
            'pengajaran' => 'required',
            'penelitian' => 'required',
            'pkm' => 'required',
            'penunjang' => 'required',
            'jumlah_sks' => 'required',
            'rata_rata_sks' => 'required',
        ]);

        BebanKinerjaDosen::create([
            'user_id' => Auth::user()->id,
            'nama' => $request->nama,
            'nidn' => $request->nidn,
            'pengajaran' => $request->pengajaran,
            'penelitian' => $request->penelitian,
            'pkm' => $request->pkm,
            'penunjang' => $request->penunjang,
            'jumlah_sks' => $request->jumlah_sks,
            'rata_rata_sks' => $request->rata_rata_sks
        ]);

        return redirect()->back()->with('success', 'Data Evaluasi Pelaksanaan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nidn' => 'required|numeric',
            'pengajaran' => 'required|string|max:255',
            'penelitian' => 'required|string|max:255',
            'pkm' => 'required|string|max:255',
            'penunjang' => 'required|string|max:255',
            'jumlah_sks' => 'required|numeric',
            'rata_rata_sks' => 'required|numeric',
        ]);

        $beban_kinerja_dosen = BebanKinerjaDosen::find($id);
        $beban_kinerja_dosen->nama = $request->nama;
        $beban_kinerja_dosen->nidn = $request->nidn;
        $beban_kinerja_dosen->pengajaran = $request->pengajaran;
        $beban_kinerja_dosen->penelitian = $request->penelitian;
        $beban_kinerja_dosen->pkm = $request->pkm;
        $beban_kinerja_dosen->penunjang = $request->penunjang;
        $beban_kinerja_dosen->jumlah_sks = $request->jumlah_sks;
        $beban_kinerja_dosen->rata_rata_sks = $request->rata_rata_sks;
        $beban_kinerja_dosen->user_id = Auth::user()->id;
        $beban_kinerja_dosen->save();

        return redirect()->back()->with('success', 'Data Profil Dosen berhasil diubah!');
    }

    public function destroy($id)
    {
        $beban_kinerja_dosen = BebanKinerjaDosen::find($id);
        $beban_kinerja_dosen->delete();

        return redirect()->back()->with('success', 'Data Profil Dosen berhasil dihapus!');
    }
}
