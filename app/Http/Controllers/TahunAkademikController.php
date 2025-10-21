<?php

namespace App\Http\Controllers;

use App\Models\TahunAkademik;
use Illuminate\Http\Request;

class TahunAkademikController extends Controller
{
    public function index()
    {
        $tahunList = TahunAkademik::all();
        return view('admin.tahun_akademik', compact('tahunList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_batas_pengisian' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        TahunAkademik::create([
            'tahun' => $request->tahun,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_batas_pengisian' => $request->tanggal_batas_pengisian
        ]);

        return back()->with('success', 'Tahun akademik ditambahkan.');
    }

    public function setAktif($id)
    {
        TahunAkademik::query()->update(['is_active' => false]);
        TahunAkademik::where('id', $id)->update(['is_active' => true]);

        session(['tahun_akademik_id' => $id]); // simpan di session juga

        return back()->with('success', 'Tahun akademik diaktifkan.');
    }

    public function destroy($id)
    {
        $tahun = TahunAkademik::findOrFail($id);

        // Tidak boleh hapus jika sedang aktif
        if ($tahun->is_active) {
            return back()->with('error', 'Tidak bisa menghapus tahun akademik yang sedang aktif.');
        }

        $tahun->delete();

        return back()->with('success', 'Tahun akademik berhasil dihapus.');
    }

}
