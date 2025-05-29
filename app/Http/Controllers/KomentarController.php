<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KomentarController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_tabel' => 'required',
            'prodi_id' => 'required',
            'komentar' => 'required',
        ]);

        $komentar = Komentar::create([
            'nama_tabel' => $request->nama_tabel,
            'prodi_id' => $request->prodi_id,
            'komentar' => $request->komentar,
        ]);

        $notifikasi = Notifikasi::create([
            'prodi_id' => $request->prodi_id,
            'user_id' => Auth::user()->id,
            'pesan' => "New comment in table ".$request->nama_tabel,
            'nama_tabel' => $request->nama_tabel,
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil di tambahkan');
    }

    
}
