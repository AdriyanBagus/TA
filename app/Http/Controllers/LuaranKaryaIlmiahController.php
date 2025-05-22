<?php

namespace App\Http\Controllers;

use App\Models\LuaranKaryaIlmiah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LuaranKaryaIlmiahController extends Controller
{
    public function index()
    {
        return view('pages.luaran_karya_ilmiah');
    }

    public function show()
    {
        if (Auth::user()->id) {
            $luaran_karya_ilmiah = LuaranKaryaIlmiah::where('user_id', Auth::user()->id)->get();
        }
    
        return view('pages.luaran_karya_ilmiah', compact('luaran_karya_ilmiah'));
    }

    public function add(Request $request)
    {
        LuaranKaryaIlmiah::create([
            'user_id' => Auth::user()->id,
            'judul_kegiatan_pkm' => $request->judul_kegiatan_pkm,
            'judul_karya' => $request->judul_karya,
            'dosen' => $request->dosen,
            'mahasiswa' => $request->mahasiswa,
            'penyusun_utama' => $request->penyusun_utama,
            'jenis' => $request->jenis,
            'nomor_karya' => $request->nomor_karya,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $luaran_karya_ilmiah = LuaranKaryaIlmiah::find($id);
        $luaran_karya_ilmiah->judul_kegiatan_pkm = $request->judul_kegiatan_pkm;
        $luaran_karya_ilmiah->judul_karya = $request->judul_karya;
        $luaran_karya_ilmiah->dosen = $request->dosen;
        $luaran_karya_ilmiah->mahasiswa = $request->mahasiswa;
        $luaran_karya_ilmiah->penyusun_utama = $request->penyusun_utama;
        $luaran_karya_ilmiah->jenis = $request->jenis;
        $luaran_karya_ilmiah->nomor_karya = $request->nomor_karya;
        $luaran_karya_ilmiah->keterangan = $request->keterangan;
        $luaran_karya_ilmiah->user_id = Auth::user()->id;
        $luaran_karya_ilmiah->save();

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $luaran_karya_ilmiah = LuaranKaryaIlmiah::find($id);
        $luaran_karya_ilmiah->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
