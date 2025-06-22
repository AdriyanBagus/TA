<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\RekognisiTenagaKependidikan;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekognisiTenagaKependidikanController extends Controller
{
    private function formatUrl($url)
    {
        if (!preg_match('/^https?:\/\//i', $url)) {
            return 'https://' . $url;
        }
        return $url;
    }
    public function index()
    {
        return view('pages.rekognisi_tenaga_kependidikan');
    }

    public function show(Request $request)
    {
        if (Auth::user()->id) {
            
            $tahunList = TahunAkademik::all();
            $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

            $rekognisi_tenaga_kependidikan = RekognisiTenagaKependidikan::where('user_id', Auth::user()->id)->get();

            // dan prodi_id yang sesuai dengan user yang sedang login
            $tabel = (new RekognisiTenagaKependidikan())->getTable(); 
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
        return view('pages.rekognisi_tenaga_kependidikan', compact('rekognisi_tenaga_kependidikan', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function add(Request $request)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();

        // Format URL
        $formattedUrl = $this->formatUrl($request->url);

        RekognisiTenagaKependidikan::create([
            'user_id' => Auth::user()->id,
            'tahun_akademik_id' => $tahunAktif->id,
            'nama' => $request->nama,
            'nama_kegiatan_rekognisi' => $request->nama_kegiatan_rekognisi,
            'tingkat' => $request->tingkat,
            'bahan_ajar' => $request->bahan_ajar,
            'tahun_perolehan' => $request->tahun_perolehan,
            'url' => $formattedUrl,
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();
        // Format URL
        $formattedUrl = $this->formatUrl($request->url);

        $rekognisi_tenaga_kependidikan = RekognisiTenagaKependidikan::find($id);
        $rekognisi_tenaga_kependidikan->user_id = Auth::user()->id;
        $rekognisi_tenaga_kependidikan->tahun_akademik_id = $tahunAktif->id;
        $rekognisi_tenaga_kependidikan->nama = $request->nama;
        $rekognisi_tenaga_kependidikan->nama_kegiatan_rekognisi = $request->nama_kegiatan_rekognisi;
        $rekognisi_tenaga_kependidikan->tingkat = $request->tingkat;
        $rekognisi_tenaga_kependidikan->bahan_ajar = $request->bahan_ajar;
        $rekognisi_tenaga_kependidikan->tahun_perolehan = $request->tahun_perolehan;
        $rekognisi_tenaga_kependidikan->url = $formattedUrl;
        $rekognisi_tenaga_kependidikan->save();

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $rekognisi_tenaga_kependidikan = RekognisiTenagaKependidikan::find($id);
        $rekognisi_tenaga_kependidikan->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function exportCsv()
    {
        $records = RekognisiTenagaKependidikan::where('user_id', Auth::user()->id)
                            ->where('tahun_akademik_id', TahunAkademik::where('is_active', true)->value('id'))
                            ->get();

        $filename = 'Rekognisi Tenaga Kependidikan_' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'No', 'Nama', 'Nama Kegiatan Rekognisi', 'Tingkat', 'Bahan Ajar', 'Tahun Perolehan', 'URL'
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
                    $record->nama_kegiatan_rekognisi,
                    $record->tingkat,
                    $record->bahan_ajar,
                    $record->tahun_perolehan,
                    $record->url
                ], ';', '"');
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
