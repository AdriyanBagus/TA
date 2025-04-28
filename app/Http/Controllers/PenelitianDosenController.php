<?php

namespace App\Http\Controllers;

use App\Models\PenelitianDosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenelitianDosenController extends Controller
{
    public function index(){
        return view('pages.penelitian_dosen');
    }

    public function show(){
        if (Auth::user()->id) {
            $penelitian_dosen = PenelitianDosen::where('user_id', Auth::user()->id)->get();
        }
        return view('pages.penelitian_dosen', compact('penelitian_dosen'));
    }

    public function add(Request $request)
    {
        PenelitianDosen::create([
            'user_id' => Auth::user()->id,
            'judul_penelitian' => $request->judul_penelitian,
            'nama_dosen_peneliti' => $request->nama_dosen_peneliti,
            'nama_mahasiswa' => $request->nama_mahasiswa,
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
        $penelitian_dosen = PenelitianDosen::find($id);
        $penelitian_dosen->judul_penelitian = $request->judul_penelitian;
        $penelitian_dosen->nama_dosen_peneliti = $request->nama_dosen_peneliti;
        $penelitian_dosen->nama_mahasiswa = $request->nama_mahasiswa;
        $penelitian_dosen->tingkat = $request->tingkat;
        $penelitian_dosen->sumber_dana = $request->sumber_dana;
        $penelitian_dosen->kesesuaian_roadmap = $request->kesesuaian_roadmap;
        $penelitian_dosen->bentuk_integrasi = $request->bentuk_integrasi;
        $penelitian_dosen->mata_kuliah = $request->mata_kuliah;
        $penelitian_dosen->user_id = Auth::user()->id;
        $penelitian_dosen->save();

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    
    public function destroy($id)
    {
        $penelitian_dosen = PenelitianDosen::find($id);
        $penelitian_dosen->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
