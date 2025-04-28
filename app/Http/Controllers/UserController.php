<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $tabelCounts = [
            'tabel1' => DB::table('visi_misi')->count(),
            'tabel2' => DB::table('kerjasama_pendidikan')->count(),
            'tabel3' => DB::table('kerjasama_penelitian')->count(),
            'tabel4' => DB::table('kerjasama_pengabdian_kepada_masyarakat')->count(),
            'tabel5' => DB::table('evaluasi_pelaksanaan')->count(),
            'tabel6' => DB::table('profil_dosen')->count(),
            'tabel7' => DB::table('beban_kinerja_dosen')->count(),
            'tabel8' => DB::table('profil_dosen_tidak_tetap')->count(),
            // Tambahkan tabel lainnya di sini
        ];

        return view('dashboard', compact('tabelCounts'));
    }
}
