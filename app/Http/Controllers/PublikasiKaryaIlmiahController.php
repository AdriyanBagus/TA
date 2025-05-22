<?php

namespace App\Http\Controllers;

use App\Models\PublikasiKaryaIlmiah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublikasiKaryaIlmiahController extends Controller
{
    public function index()
    {
        return view('pages.publikasi_karya_ilmiah');
    }

    public function show()
    {
        if (Auth::user()->id) {
            $publikasi_karya_ilmiah = PublikasiKaryaIlmiah::where('user_id', Auth::user()->id)->get();
        }
    
        return view('pages.publikasi_karya_ilmiah', compact('publikasi_karya_ilmiah'));
    }

    public function add(Request $request)
    {
        PublikasiKaryaIlmiah::create([
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
        $publikasi_karya_ilmiah = PublikasiKaryaIlmiah::find($id);
        $publikasi_karya_ilmiah->judul_penelitian = $request->judul_penelitian;
        $publikasi_karya_ilmiah->judul_publikasi = $request->judul_publikasi;
        $publikasi_karya_ilmiah->dosen = $request->dosen;
        $publikasi_karya_ilmiah->mahasiswa = $request->mahasiswa;
        $publikasi_karya_ilmiah->dipublikasikan = $request->dipublikasikan;
        $publikasi_karya_ilmiah->penerbit = $request->penerbit;
        $publikasi_karya_ilmiah->jenis = $request->jenis;
        $publikasi_karya_ilmiah->tingkat = $request->tingkat;
        $publikasi_karya_ilmiah->penyusun = $request->penyusun;
        $publikasi_karya_ilmiah->status = $request->status;
        $publikasi_karya_ilmiah->user_id = Auth::user()->id;
        $publikasi_karya_ilmiah->save();

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $publikasi_karya_ilmiah = PublikasiKaryaIlmiah::find($id);
        $publikasi_karya_ilmiah->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
