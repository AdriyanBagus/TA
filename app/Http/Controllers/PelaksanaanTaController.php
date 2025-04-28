<?php

namespace App\Http\Controllers;

use App\Models\PelaksanaanTa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelaksanaanTaController extends Controller
{
    public function index()
    {
        return view('pages.pelaksanaan_ta');
    }

    public function show()
    {
        if (Auth::user()->id) {
            $pelaksanaan_ta = PelaksanaanTa::where('user_id', Auth::user()->id)->get();
        }
        return view('pages.pelaksanaan_ta', compact('pelaksanaan_ta'));
    }

    public function add(Request $request)
    {

        PelaksanaanTa::create([
            'user_id' => Auth::user()->id,
            'nama' => $request->nama,
            'nidn' => $request->nidn,
            'bimbingan_mahasiswa_ps' => $request->bimbingan_mahasiswa_ps,
            'rata_rata_jumlah_bimbingan' => $request->rata_rata_jumlah_bimbingan,
            'bimbingan_mahasiswa_ps_lain' => $request->bimbingan_mahasiswa_ps_lain,
            'rata_rata_jumlah_bimbingan_seluruh_ps' => $request->rata_rata_jumlah_bimbingan_seluruh_ps,
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {

        $pelaksanaan_ta = PelaksanaanTa::find($id);
        $pelaksanaan_ta->user_id = Auth::user()->id;
        $pelaksanaan_ta->nama = $request->nama;
        $pelaksanaan_ta->nidn = $request->nidn;
        $pelaksanaan_ta->bimbingan_mahasiswa_ps = $request->bimbingan_mahasiswa_ps;
        $pelaksanaan_ta->rata_rata_jumlah_bimbingan = $request->rata_rata_jumlah_bimbingan;
        $pelaksanaan_ta->bimbingan_mahasiswa_ps_lain = $request->bimbingan_mahasiswa_ps_lain;
        $pelaksanaan_ta->rata_rata_jumlah_bimbingan_seluruh_ps = $request->rata_rata_jumlah_bimbingan_seluruh_ps;
        $pelaksanaan_ta->save();
        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $pelaksanaan_ta = PelaksanaanTa::find($id);
        $pelaksanaan_ta->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
