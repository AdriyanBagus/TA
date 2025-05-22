<?php

namespace App\Http\Controllers;

use App\Models\PkmMahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PkmMahasiswaController extends Controller
{
    public function index()
    {
        return view('pages.pkm_mahasiswa');
    }

    public function show()
    {
        if (Auth::user()->id) {
            $pkm_mahasiswa = PkmMahasiswa::where('user_id', Auth::user()->id)->get();
        }
    
        return view('pages.pkm_mahasiswa', compact('pkm_mahasiswa'));
    }

    public function add(Request $request)
    {
        PkmMahasiswa::create([
            'user_id' => Auth::user()->id,
            'mahasiswa' => $request->mahasiswa,
            'pembimbing' => $request->pembimbing,
            'judul_pkm' => $request->judul_pkm,
            'tingkat' => $request->tingkat,
            'sumber_dana' => $request->sumber_dana,
            'kesesuaian_roadmap' => $request->kesesuaian_roadmap
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $pkm_mahasiswa = PkmMahasiswa::find($id);
        $pkm_mahasiswa->mahasiswa = $request->mahasiswa;
        $pkm_mahasiswa->pembimbing = $request->pembimbing;
        $pkm_mahasiswa->judul_pkm = $request->judul_pkm;
        $pkm_mahasiswa->tingkat = $request->tingkat;
        $pkm_mahasiswa->sumber_dana = $request->sumber_dana;
        $pkm_mahasiswa->kesesuaian_roadmap = $request->kesesuaian_roadmap;
        $pkm_mahasiswa->user_id = Auth::user()->id;
        $pkm_mahasiswa->save();

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $pkm_mahasiswa = PkmMahasiswa::find($id);
        $pkm_mahasiswa->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
