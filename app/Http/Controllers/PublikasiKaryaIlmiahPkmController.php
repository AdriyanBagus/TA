<?php

namespace App\Http\Controllers;

use App\Models\PublikasiKaryaIlmiahPkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublikasiKaryaIlmiahPkmController extends Controller
{
    public function index()
    {
        return view('pages.publikasi_karya_ilmiah_pkm');
    }

    public function show()
    {
        if (Auth::user()->id) {
            $publikasi_karya_ilmiah_pkm = PublikasiKaryaIlmiahPkm::where('user_id', Auth::user()->id)->get();
        }
    
        return view('pages.publikasi_karya_ilmiah_pkm', compact('publikasi_karya_ilmiah_pkm'));
    }

    public function add(Request $request)
    {
        PublikasiKaryaIlmiahPkm::create([
            'user_id' => Auth::user()->id,
            'judul_penelitian' => $request->judul_penelitian,
            'judul_publikasi' => $request->judul_publikasi,
            'dosen' => $request->dosen,
            'mahasiswa' => $request->mahasiswa,
            'dipublikasikan' => $request->dipublikasikan,
            'penerbit' => $request->penerbit,
            'jenis' => $request->jenis,
            'tingkat' => $request->tingkat,
            'penyusun' => $request->penyusun,
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $publikasi_karya_ilmiah_pkm = PublikasiKaryaIlmiahPkm::find($id);
        $publikasi_karya_ilmiah_pkm->judul_penelitian = $request->judul_penelitian;
        $publikasi_karya_ilmiah_pkm->judul_publikasi = $request->judul_publikasi;
        $publikasi_karya_ilmiah_pkm->dosen = $request->dosen;
        $publikasi_karya_ilmiah_pkm->mahasiswa = $request->mahasiswa;
        $publikasi_karya_ilmiah_pkm->dipublikasikan = $request->dipublikasikan;
        $publikasi_karya_ilmiah_pkm->penerbit = $request->penerbit;
        $publikasi_karya_ilmiah_pkm->jenis = $request->jenis;
        $publikasi_karya_ilmiah_pkm->tingkat = $request->tingkat;
        $publikasi_karya_ilmiah_pkm->penyusun = $request->penyusun;
        $publikasi_karya_ilmiah_pkm->status = $request->status;
        $publikasi_karya_ilmiah_pkm->user_id = Auth::user()->id;
        $publikasi_karya_ilmiah_pkm->save();

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $publikasi_karya_ilmiah_pkm = PublikasiKaryaIlmiahPkm::find($id);
        $publikasi_karya_ilmiah_pkm->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
