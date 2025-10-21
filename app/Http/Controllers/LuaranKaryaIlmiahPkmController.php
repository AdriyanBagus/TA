<?php

namespace App\Http\Controllers;

use App\Models\LuaranKaryaIlmiahPkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LuaranKaryaIlmiahPkmController extends Controller
{
    public function index()
    {
        return view('pages.luaran_karya_ilmiah_pkm');
    }

    public function show()
    {
        if (Auth::user()->id) {
            $luaran_karya_ilmiah_pkm = LuaranKaryaIlmiahPkm::where('user_id', Auth::user()->id)->get();
        }
    
        return view('pages.luaran_karya_ilmiah_pkm', compact('luaran_karya_ilmiah_pkm'));
    }

    public function add(Request $request)
    {
        LuaranKaryaIlmiahPkm::create([
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
        $luaran_karya_ilmiah_pkm = LuaranKaryaIlmiahPkm::find($id);
        $luaran_karya_ilmiah_pkm->judul_kegiatan_pkm = $request->judul_kegiatan_pkm;
        $luaran_karya_ilmiah_pkm->judul_karya = $request->judul_karya;
        $luaran_karya_ilmiah_pkm->dosen = $request->dosen;
        $luaran_karya_ilmiah_pkm->mahasiswa = $request->mahasiswa;
        $luaran_karya_ilmiah_pkm->penyusun_utama = $request->penyusun_utama;
        $luaran_karya_ilmiah_pkm->jenis = $request->jenis;
        $luaran_karya_ilmiah_pkm->nomor_karya = $request->nomor_karya;
        $luaran_karya_ilmiah_pkm->keterangan = $request->keterangan;
        $luaran_karya_ilmiah_pkm->user_id = Auth::user()->id;
        $luaran_karya_ilmiah_pkm->save();

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $luaran_karya_ilmiah_pkm = LuaranKaryaIlmiahPkm::find($id);
        $luaran_karya_ilmiah_pkm->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
