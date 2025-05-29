<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\Settings;
use App\Models\VisiMisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisiMisiController extends Controller
{
    public function index()
    {
        return view('pages.visi_misi');
    }

    public function show()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
    
        $visi_misi = VisiMisi::where('user_id', Auth::user()->id)
                            ->whereYear('created_at', date('Y'))
                            ->get();

        $tabel = (new VisiMisi())->getTable(); 
        $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
    
        return view('pages.visi_misi', compact('visi_misi', 'komentar'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'visi' => 'required|string',
            'misi' => 'required|string',
            'deskripsi' => 'required|string',
        ]);

        VisiMisi::create([
            'visi' => $request->visi,
            'misi' => $request->misi,
            'deskripsi' => $request->deskripsi,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->back()->with('success', 'Data Visi & Misi berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'visi' => 'required|string',
            'misi' => 'required|string',
            'deskripsi' => 'required|string',
        ]);

        $visi_misi = VisiMisi::find($id);
        $visi_misi->visi = $request->visi;
        $visi_misi->misi = $request->misi;
        $visi_misi->deskripsi = $request->deskripsi;
        $visi_misi->user_id = Auth::user()->id;
        $visi_misi->save();

        return redirect()->back()->with('success', 'Data Visi & Misi berhasil diubah!');
    }

    public function destroy($id)
    {
        $visi_misi = VisiMisi::find($id);

        if ($visi_misi) {
            $visi_misi->delete();
            return redirect()->back()->with('success', 'Data Visi & Misi berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'Data Visi & Misi tidak ditemukan!');
    }
}