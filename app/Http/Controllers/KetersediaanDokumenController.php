<?php

namespace App\Http\Controllers;

use App\Models\KetersediaanDokumen;
use App\Models\Komentar;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KetersediaanDokumenController extends Controller
{
    public function index()
    {
        return view('pages.ketersediaan_dokumen');
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
            
            $ketersediaan_dokumen = KetersediaanDokumen::where('user_id', Auth::user()->id)
                ->where('ketersediaan_dokumen.tahun_akademik_id', $tahunTerpilih)
                ->get();

            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            // dan prodi_id yang sesuai dengan user yang sedang login
            $tabel = (new KetersediaanDokumen())->getTable(); 
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
        return view('pages.ketersediaan_dokumen', compact('ketersediaan_dokumen', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function add(Request $request)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();

        $formattedUrl = $this->formatUrl($request->url);

        KetersediaanDokumen::create([
            'user_id' => Auth::user()->id,
            'tahun_akademik_id' => $tahunAktif->id,
            'ketersediaan_dokumen' => $request->ketersediaan_dokumen,
            'nomor_dokumen' => $request->nomor_dokumen,
            'url' => $formattedUrl,
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();

        $formattedUrl = $this->formatUrl($request->url);

        $ketersediaan_dokumen = KetersediaanDokumen::find($id);
        $ketersediaan_dokumen->tahun_akademik_id = $tahunAktif->id;
        $ketersediaan_dokumen->ketersediaan_dokumen = $request->ketersediaan_dokumen;
        $ketersediaan_dokumen->nomor_dokumen = $request->nomor_dokumen;
        $ketersediaan_dokumen->url = $formattedUrl;
        $ketersediaan_dokumen->user_id = Auth::user()->id;
        $ketersediaan_dokumen->save();

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $ketersediaan_dokumen = KetersediaanDokumen::find($id);
        $ketersediaan_dokumen->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function exportCsv()
    {
        $records = KetersediaanDokumen::where('user_id', Auth::user()->id)
                            ->where('tahun_akademik_id', TahunAkademik::where('is_active', true)->value('id'))
                            ->get();

        $filename = 'Ketersediaan Dokumen' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'No', 'Ketersediaan Dokumen', 'Nomor Dokumen', 'URL'
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
                    $record->ketersediaan_dokumen,
                    $record->nomor_dokumen,
                    $record->url
                ], ';', '"');
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
