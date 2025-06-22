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
        TahunAkademik::create([
            'tahun' => $request->tahun
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
}
