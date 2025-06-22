<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\LahanPraktek;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LahanPraktekController extends Controller
{
    public function index()
    {
        return view('pages.lahan_praktek');
    }

    public function show(Request $request)
    {
        if (Auth::user()->id) {
            // Ambil daftar tahun akademik
            $tahunList = TahunAkademik::all();
            $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

            $lahan_praktek = LahanPraktek::where('user_id', Auth::user()->id)
                                         ->where('lahan_praktek.tahun_akademik_id', $tahunTerpilih)
                                         ->get();

            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            // dan prodi_id yang sesuai dengan user yang sedang login
            $tabel = (new LahanPraktek())->getTable(); 
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
        return view('pages.lahan_praktek', compact('lahan_praktek', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function add(Request $request)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();

        LahanPraktek::create([
            'user_id' => Auth::user()->id,
            'tahun_akademik_id' => $tahunAktif->id,
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
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();

        $lahan_praktek = LahanPraktek::find($id);
        $lahan_praktek->user_id = Auth::user()->id;
        $lahan_praktek->tahun_akademik_id = $tahunAktif->id;
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

    public function exportCsv()
    {
        $records = LahanPraktek::where('user_id', Auth::user()->id)
                            ->where('tahun_akademik_id', TahunAkademik::where('is_active', true)->value('id'))
                            ->get();

        $filename = 'Lahan Praktek_' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'No', 'Lahan Praktek', 'Akreditasi', 'Kesesuaian Bidang Keilmuan',
            'Jumlah Mahasiswa', 'Daya Tampung Mahasiswa', 'Kontribusi Lahan Praktek'
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
                    $record->lahan_praktek,
                    $record->akreditasi,
                    $record->kesesuaian_bidang_keilmuan,
                    $record->jumlah_mahasiswa,
                    $record->daya_tampung_mahasiswa,
                    $record->kontribusi_lahan_praktek,
                ], ';', '"');
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
