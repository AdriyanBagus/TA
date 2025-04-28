<?php

namespace App\Http\Controllers;

use App\Models\LahanPraktek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LahanPraktekController extends Controller
{
    public function index()
    {
        return view('pages.lahan_praktek');
    }

    public function show()
    {
        if (Auth::user()->id) {
            $lahan_praktek = LahanPraktek::where('user_id', Auth::user()->id)->get();
        }
        return view('pages.lahan_praktek', compact('lahan_praktek'));
    }

    public function add(Request $request)
    {

        LahanPraktek::create([
            'user_id' => Auth::user()->id,
            'lahan_praktek' => $request->lahan_praktek,
            'akreditasi' => $request->akreditasi,
            'kesesuaian_bidang_keilmuan' => $request->kesesuaian_bidang_keilmuan,
            'jumlah_mahasiswa' => $request->jumlah_mahasiswa,
            'daya_tampung_mahasiswa' => $request->daya_tampung_mahasiswa,
            'kontribusi_lahan_praktek' => $request->kontribusi_lahan_praktek,
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {

        $lahan_praktek = LahanPraktek::find($id);
        $lahan_praktek->user_id = Auth::user()->id;
        $lahan_praktek->lahan_praktek = $request->lahan_praktek;
        $lahan_praktek->akreditasi = $request->akreditasi;
        $lahan_praktek->kesesuaian_bidang_keilmuan = $request->kesesuaian_bidang_keilmuan;
        $lahan_praktek->jumlah_mahasiswa = $request->jumlah_mahasiswa;
        $lahan_praktek->daya_tampung_mahasiswa = $request->daya_tampung_mahasiswa;
        $lahan_praktek->kontribusi_lahan_praktek = $request->kontribusi_lahan_praktek;
        $lahan_praktek->save();
        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $lahan_praktek = LahanPraktek::find($id);
        $lahan_praktek->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
