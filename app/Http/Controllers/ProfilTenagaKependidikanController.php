<?php

namespace App\Http\Controllers;

use App\Models\ProfilTenagaKependidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilTenagaKependidikanController extends Controller
{
    public function index(){
        return view('pages.profil_tenaga_kependidikan');
    }

    public function show(){
        if (Auth::user()->id) {
            $profil_tenaga_kependidikan = ProfilTenagaKependidikan::where('user_id', Auth::user()->id)->get();
        }
        return view('pages.profil_tenaga_kependidikan', compact('profil_tenaga_kependidikan'));
    }

    public function add(Request $request)
    {
        ProfilTenagaKependidikan::create([
            'user_id' => Auth::user()->id,
            'nama' => $request->nama,
            'nipy' => $request->nipy,
            'kualifikasi_pendidikan' => $request->kualifikasi_pendidikan,
            'jabatan' => $request->jabatan,
            'kesesuaian_bidang_kerja' => $request->kesesuaian_bidang_kerja,
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {

        $profil_tenaga_kependidikan = ProfilTenagaKependidikan::find($id);
        $profil_tenaga_kependidikan->nama = $request->nama;
        $profil_tenaga_kependidikan->nipy = $request->nipy;
        $profil_tenaga_kependidikan->kualifikasi_pendidikan = $request->kualifikasi_pendidikan;
        $profil_tenaga_kependidikan->jabatan = $request->jabatan;
        $profil_tenaga_kependidikan->kesesuaian_bidang_kerja = $request->kesesuaian_bidang_kerja;
        $profil_tenaga_kependidikan->user_id = Auth::user()->id;
        $profil_tenaga_kependidikan->save();

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $profil_tenaga_kependidikan = ProfilTenagaKependidikan::find($id);
        $profil_tenaga_kependidikan->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
