<?php

namespace App\Http\Controllers;

use App\Models\Kerjasama;
use App\Models\Komentar;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KerjasamaController extends Controller
{
    public function index()
    {
        return view('pages.kerjasama');
    }
    private function formatUrl($url)
    {
        if (!preg_match('/^https?:\/\//i', $url)) {
            return 'https://' . $url;
        }
        return $url;
    }

    public function show(Request $request)
    {
        if (Auth::user()->id) {
            // Ambil daftar tahun akademik
            $tahunList = TahunAkademik::all();
            $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
            
            $kerjasama = Kerjasama::where('user_id', Auth::user()->id)
                ->where('kerjasama.tahun_akademik_id', $tahunTerpilih)
                ->get();

            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            // dan prodi_id yang sesuai dengan user yang sedang login
            $tabel = (new Kerjasama())->getTable(); 
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
        return view('pages.kerjasama', compact('kerjasama', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function add(Request $request)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();

        $formattedUrl = $this->formatUrl($request->url);

        Kerjasama::create([
            'user_id' => Auth::user()->id,
            'tahun_akademik_id' => $tahunAktif->id,
            'lembaga_mitra' => $request->lembaga_mitra,
            'jenis_kerjasama' => $request->jenis_kerjasama,
            'tingkat' => $request->tingkat,
            'judul_kerjasama' => $request->judul_kerjasama,
            'waktu_durasi' => $request->waktu_durasi,
            'realisasi_kerjasama' => $request->realisasi_kerjasama,
            'spk' => $request->spk,
            'url' => $formattedUrl, // Dokumen Kerjasama
        ]);

        return redirect()->back()->with('success', 'Data Visi & Misi berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();
        // Format URL
        $formattedUrl = $this->formatUrl($request->url);

        $kerjasama = Kerjasama::find($id);
        $kerjasama->tahun_akademik_id = $tahunAktif->id;
        $kerjasama->lembaga_mitra = $request->lembaga_mitra;
        $kerjasama->jenis_kerjasama = $request->jenis_kerjasama;
        $kerjasama->tingkat = $request->tingkat;
        $kerjasama->judul_kerjasama = $request->judul_kerjasama;
        $kerjasama->waktu_durasi = $request->waktu_durasi;
        $kerjasama->realisasi_kerjasama = $request->realisasi_kerjasama;
        $kerjasama->spk = $request->spk;
        $kerjasama->url = $formattedUrl; // Dokumen Kerjasama
        $kerjasama->user_id = Auth::user()->id;
        $kerjasama->save();

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $kerjasama = Kerjasama::find($id);
        $kerjasama->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function exportCsv()
    {
        $records = Kerjasama::where('user_id', Auth::user()->id)
                            ->where('tahun_akademik_id', TahunAkademik::where('is_active', true)->value('id'))
                            ->get();

        $filename = 'Kerjasama_' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'No', 'Lembaga Mitra', 'Jenis Kerjasama', 'Tingkat', 'Judul Kerjasama',
            'Waktu Durasi', 'Realisasi Kerjasama', 'SPK', 'Url'
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
                    $record->lembaga_mitra,
                    $record->jenis_kerjasama,
                    $record->tingkat,
                    $record->judul_kerjasama,
                    $record->waktu_durasi,
                    $record->realisasi_kerjasama,
                    $record->spk,
                    $record->url
                ], ';', '"');
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
