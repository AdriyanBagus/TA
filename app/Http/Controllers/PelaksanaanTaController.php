<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\PelaksanaanTa;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelaksanaanTaController extends Controller
{
    public function index()
    {
        return view('pages.pelaksanaan_ta');
    }

    public function show(Request $request)
    {
        if (Auth::user()->id) {
            // Ambil daftar tahun akademik
            $tahunList = TahunAkademik::all();
            $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

            $pelaksanaan_ta = PelaksanaanTa::where('user_id', Auth::user()->id)
                                          ->where('pelaksanaan_ta.tahun_akademik_id', $tahunTerpilih)
                                          ->get();

            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            $tabel = (new PelaksanaanTa())->getTable(); 
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
        return view('pages.pelaksanaan_ta', compact('pelaksanaan_ta', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function add(Request $request)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();

        //Rumus jumlah bimbingan
        $rata_rata_jumlah_bimbingan_ps_sendiri = $request->bimbingan_mahasiswa_ps_sendiri;
        $rata_rata_jumlah_bimbingan_ps_lain = $request->bimbingan_mahasiswa_ps_lain;
        $rata_rata_jumlah_bimbingan_seluruh_ps = $request->bimbingan_mahasiswa_ps_sendiri + $request->bimbingan_mahasiswa_ps_lain;

        PelaksanaanTa::create([
            'user_id' => Auth::user()->id,
            'tahun_akademik_id' => $tahunAktif->id,
            'nama' => $request->nama,
            'nidn' => $request->nidn,
            'bimbingan_mahasiswa_ps_sendiri' => $request->bimbingan_mahasiswa_ps_sendiri,
            'rata_rata_jumlah_bimbingan_ps_sendiri' => $rata_rata_jumlah_bimbingan_ps_sendiri,
            'bimbingan_mahasiswa_ps_lain' => $request->bimbingan_mahasiswa_ps_lain,
            'rata_rata_jumlah_bimbingan_ps_lain' => $rata_rata_jumlah_bimbingan_ps_lain,
            'rata_rata_jumlah_bimbingan_seluruh_ps' => $rata_rata_jumlah_bimbingan_seluruh_ps,
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();

        $rata_rata_jumlah_bimbingan_ps_sendiri = $request->bimbingan_mahasiswa_ps_sendiri;
        $rata_rata_jumlah_bimbingan_ps_lain = $request->bimbingan_mahasiswa_ps_lain;
        $rata_rata_jumlah_bimbingan_seluruh_ps = $request->bimbingan_mahasiswa_ps_sendiri + $request->bimbingan_mahasiswa_ps_lain;

        $pelaksanaan_ta = PelaksanaanTa::find($id);
        $pelaksanaan_ta->user_id = Auth::user()->id;
        $pelaksanaan_ta->tahun_akademik_id = $tahunAktif->id;
        $pelaksanaan_ta->nama = $request->nama;
        $pelaksanaan_ta->nidn = $request->nidn;
        $pelaksanaan_ta->bimbingan_mahasiswa_ps_sendiri = $request->bimbingan_mahasiswa_ps_sendiri;
        $pelaksanaan_ta->rata_rata_jumlah_bimbingan_ps_sendiri = $rata_rata_jumlah_bimbingan_ps_sendiri;
        $pelaksanaan_ta->bimbingan_mahasiswa_ps_lain = $request->bimbingan_mahasiswa_ps_lain;
        $pelaksanaan_ta->rata_rata_jumlah_bimbingan_ps_lain = $rata_rata_jumlah_bimbingan_ps_lain;
        $pelaksanaan_ta->rata_rata_jumlah_bimbingan_seluruh_ps = $rata_rata_jumlah_bimbingan_seluruh_ps;
        $pelaksanaan_ta->save();
        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $pelaksanaan_ta = PelaksanaanTa::find($id);
        $pelaksanaan_ta->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function exportCsv()
    {
        $records = PelaksanaanTa::where('user_id', Auth::user()->id)
                            ->where('tahun_akademik_id', TahunAkademik::where('is_active', true)->value('id'))
                            ->get();

        $filename = 'Pelaksanaan TA_' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'No', 'Nama', 'NIDN', 'Bimbingan Mahasiswa PS Sendiri', 'Jumlah Bimbingan PS Sendiri',
            'Bimbingan Mahasiswa PS Lain', 'Jumlah Bimbingan PS Lain', 'Jumlah Bimbingan Seluruh PS'
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
                    $record->nama,
                    $record->nidn,
                    $record->bimbingan_mahasiswa_ps_sendiri,
                    $record->rata_rata_jumlah_bimbingan_ps_sendiri,
                    $record->bimbingan_mahasiswa_ps_lain,
                    $record->rata_rata_jumlah_bimbingan_ps_lain,
                    $record->rata_rata_jumlah_bimbingan_seluruh_ps
                ], ';', '"');
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
