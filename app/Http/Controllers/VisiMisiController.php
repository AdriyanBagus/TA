<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\Settings;
use App\Models\TahunAkademik;
use App\Models\VisiMisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisiMisiController extends Controller
{
    public function index()
    {
        return view('pages.visi_misi');
    }

    public function show(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil tahun akademik aktif
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
    
        $visi_misi = VisiMisi::where('user_id', Auth::user()->id)
                            ->where('visi_misi.tahun_akademik_id', $tahunTerpilih)
                            ->get();

        $tabel = (new VisiMisi())->getTable(); 
        $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
    
        return view('pages.visi_misi', get_defined_vars());
    }

    public function add(Request $request)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();

        $request->validate([
            'visi' => 'required|string',
            'misi' => 'required|string',
            'deskripsi' => 'required|string',
        ]);

        VisiMisi::create([
            'visi' => $request->visi,
            'misi' => $request->misi,
            'deskripsi' => $request->deskripsi,
            'user_id' => Auth::user()->id,
            'tahun_akademik_id' => $tahunAktif->id,
        ]);

        return redirect()->back()->with('success', 'Data Visi & Misi berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();

        $request->validate([
            'visi' => 'required|string',
            'misi' => 'required|string',
            'deskripsi' => 'required|string',
        ]);

        $visi_misi = VisiMisi::find($id);
        $visi_misi->tahun_akademik_id = $tahunAktif->id;
        $visi_misi->visi = $request->visi;
        $visi_misi->misi = $request->misi;
        $visi_misi->deskripsi = $request->deskripsi;
        $visi_misi->user_id = Auth::user()->id;
        $visi_misi->save();

        return redirect()->back()->with('success-edit', 'Data Visi & Misi berhasil diubah!');
    }

    public function destroy($id)
    {
        $visi_misi = VisiMisi::find($id);

        if ($visi_misi) {
            $visi_misi->delete();
            return redirect()->back()->with('success-delete', 'Data Visi & Misi berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'Data Visi & Misi tidak ditemukan!');
    }

    public function exportCsv()
    {
        $records = VisiMisi::where('user_id', Auth::user()->id)
                            ->where('tahun_akademik_id', TahunAkademik::where('is_active', true)->value('id'))
                            ->get();

        $filename = 'visi_misi_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'ID', 'Visi', 'Misi', 'Deskripsi'
        ];

        $callback = function() use ($records, $columns) {
            $handle = fopen('php://output', 'w');

            // Tambahkan BOM di awal file (Byte Order Mark)
            echo chr(239) . chr(187) . chr(191);

            fputcsv($handle, $columns, ';', '"');

            $no = 1;
            foreach ($records as $record) {
                fputcsv($handle, [
                    $no++,
                    $record->visi,
                    $record->misi,
                    $record->deskripsi
                ], ';', '"');
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}