<?php

namespace App\Http\Controllers;

use App\Models\SitasiLuaranPkmDosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SitasiLuaranPkmDosenController extends Controller
{
    public function index()
    {
        return view('pages.sitasi_luaran_pkm_dosen');
    }

    public function show()
    {
        if (Auth::user()->id) {
            $sitasi_luaran_pkm_dosen = SitasiLuaranPkmDosen::where('user_id', Auth::user()->id)->get();
        }
    
        return view('pages.sitasi_luaran_pkm_dosen', compact('sitasi_luaran_pkm_dosen'));
    }

    public function add(Request $request)
    {
        SitasiLuaranpkmDosen::create([
            'user_id' => Auth::user()->id,
            'nama' => $request->nama,
            'judul_artikel' => $request->judul_artikel,
            'jumlah_sitasi' => $request->jumlah_sitasi,
            'link_sitasi' => $request->link_sitasi,
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $sitasi_luaran_pkm_dosen = SitasiLuaranPkmDosen::find($id);
        $sitasi_luaran_pkm_dosen->nama = $request->nama;
        $sitasi_luaran_pkm_dosen->judul_artikel = $request->judul_artikel;
        $sitasi_luaran_pkm_dosen->jumlah_sitasi = $request->jumlah_sitasi;
        $sitasi_luaran_pkm_dosen->link_sitasi = $request->link_sitasi;
        $sitasi_luaran_pkm_dosen->user_id = Auth::user()->id;
        $sitasi_luaran_pkm_dosen->save();

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $sitasi_luaran_pkm_dosen = SitasiLuaranPkmDosen::find($id);
        $sitasi_luaran_pkm_dosen->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
