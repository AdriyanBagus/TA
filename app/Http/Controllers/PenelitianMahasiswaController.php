<?php

namespace App\Http\Controllers;

use App\Models\PenelitianMahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenelitianMahasiswaController extends Controller
{
    public function index(){
        return view('pages.penelitian_mahasiswa');
    }

    public function show(){
        if (Auth::user()->id) {
            $penelitian_mahasiswa = PenelitianMahasiswa::where('user_id', Auth::user()->id)->get();
        }
        return view('pages.penelitian_mahasiswa', compact('penelitian_mahasiswa'));
    }

    public function add(Request $request)
    {
        PenelitianMahasiswa::create([
            'user_id' => Auth::user()->id,
            'judul_penelitian' => $request->judul_penelitian,
            'nama_mahasiswa' => $request->nama_mahasiswa,
            'nama_pembimbing' => $request->nama_pembimbing,
            'tingkat' => $request->tingkat,
            'sumber_dana' => $request->sumber_dana,
            'kesesuaian_roadmap' => $request->kesesuaian_roadmap
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $penelitian_mahasiswa = PenelitianMahasiswa::find($id);
        $penelitian_mahasiswa->judul_penelitian = $request->judul_penelitian;
        $penelitian_mahasiswa->nama_mahasiswa = $request->nama_mahasiswa;
        $penelitian_mahasiswa->nama_pembimbing = $request->nama_pembimbing;
        $penelitian_mahasiswa->tingkat = $request->tingkat;
        $penelitian_mahasiswa->sumber_dana = $request->sumber_dana;
        $penelitian_mahasiswa->kesesuaian_roadmap = $request->kesesuaian_roadmap;
        $penelitian_mahasiswa->user_id = Auth::user()->id;
        $penelitian_mahasiswa->save();

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    
    public function destroy($id)
    {
        $penelitian_mahasiswa = PenelitianMahasiswa::find($id);
        $penelitian_mahasiswa->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
