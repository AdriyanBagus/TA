<?php

namespace App\Http\Controllers;

use App\Models\PkmDosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PkmDosenController extends Controller
{
    public function index()
    {
        return view('pages.pkm_dosen');
    }

    public function show()
    {
        if (Auth::user()->id) {
            $pkm_dosen = PkmDosen::where('user_id', Auth::user()->id)->get();
        }
    
        return view('pages.pkm_dosen', compact('pkm_dosen'));
    }

    public function add(Request $request)
    {
        PkmDosen::create([
            'user_id' => Auth::user()->id,
            'judul_pkm' => $request->judul_pkm,
            'dosen' => $request->dosen,
            'mahasiswa' => $request->mahasiswa,
            'tingkat' => $request->tingkat,
            'sumber_dana' => $request->sumber_dana,
            'kesesuaian_roadmap' => $request->kesesuaian_roadmap,
            'bentuk_integrasi' => $request->bentuk_integrasi,
            'mata_kuliah' => $request->mata_kuliah
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $pkm_dosen = PkmDosen::find($id);
        $pkm_dosen->judul_pkm = $request->judul_pkm;
        $pkm_dosen->dosen = $request->dosen;
        $pkm_dosen->mahasiswa = $request->mahasiswa;
        $pkm_dosen->tingkat = $request->tingkat;
        $pkm_dosen->sumber_dana = $request->sumber_dana;
        $pkm_dosen->kesesuaian_roadmap = $request->kesesuaian_roadmap;
        $pkm_dosen->bentuk_integrasi = $request->bentuk_integrasi;
        $pkm_dosen->mata_kuliah = $request->mata_kuliah;
        $pkm_dosen->user_id = Auth::user()->id;
        $pkm_dosen->save();

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $pkm_dosen = PkmDosen::find($id);
        $pkm_dosen->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
