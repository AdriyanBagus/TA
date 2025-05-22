<?php

namespace App\Http\Controllers;

use App\Models\Kerjasama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KerjasamaController extends Controller
{
    public function index()
    {
        return view('pages.kerjasama');
    }

    public function show()
    {
        if (Auth::user()->id) {
            $kerjasama = Kerjasama::where('user_id', Auth::user()->id)->get();
        }
        return view('pages.kerjasama', compact('kerjasama'));
    }

    public function add(Request $request)
    {

        Kerjasama::create([
            'user_id' => Auth::user()->id,
            'lembaga_mitra' => $request->lembaga_mitra,
            'jenis_kerjasama' => $request->jenis_kerjasama,
            'tingkat' => $request->tingkat,
            'judul_kerjasama' => $request->judul_kerjasama,
            'waktu_durasi' => $request->waktu_durasi,
            'realisasi_kerjasama' => $request->realisasi_kerjasama,
            'spk' => $request->spk
        ]);

        return redirect()->back()->with('success', 'Data Visi & Misi berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {

        $kerjasama = Kerjasama::find($id);
        $kerjasama->lembaga_mitra = $request->lembaga_mitra;
        $kerjasama->jenis_kerjasama = $request->jenis_kerjasama;
        $kerjasama->tingkat = $request->tingkat;
        $kerjasama->judul_kerjasama = $request->judul_kerjasama;
        $kerjasama->waktu_durasi = $request->waktu_durasi;
        $kerjasama->realisasi_kerjasama = $request->realisasi_kerjasama;
        $kerjasama->spk = $request->spk;
        $kerjasama->user_id = Auth::user()->id;
        $kerjasama->save();

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $kerjasama = Kerjasama::find($id);
        $kerjasama->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
