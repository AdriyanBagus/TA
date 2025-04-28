<?php

namespace App\Http\Controllers;

use App\Models\KetersediaanDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KetersediaanDokumenController extends Controller
{
    public function index()
    {
        return view('pages.ketersediaan_dokumen');
    }

    public function show()
    {
        if (Auth::user()->id) {
            $ketersediaan_dokumen = KetersediaanDokumen::where('user_id', Auth::user()->id)->get();
        }
        return view('pages.ketersediaan_dokumen', compact('ketersediaan_dokumen'));
    }

    public function add(Request $request)
    {

        KetersediaanDokumen::create([
            'user_id' => Auth::user()->id,
            'kegiatan' => $request->kegiatan,
            'ketersediaan_dokumen' => $request->ketersediaan_dokumen,
            'nomor_dokumen' => $request->nomor_dokumen
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {

        $ketersediaan_dokumen = KetersediaanDokumen::find($id);
        $ketersediaan_dokumen->kegiatan = $request->kegiatan;
        $ketersediaan_dokumen->ketersediaan_dokumen = $request->ketersediaan_dokumen;
        $ketersediaan_dokumen->nomor_dokumen = $request->nomor_dokumen;
        $ketersediaan_dokumen->user_id = Auth::user()->id;
        $ketersediaan_dokumen->save();
        $ketersediaan_dokumen->kegiatan = $request->kegiatan;

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $ketersediaan_dokumen = KetersediaanDokumen::find($id);
        $ketersediaan_dokumen->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

}
