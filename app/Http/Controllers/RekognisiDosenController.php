<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\ProfilDosen;
use App\Models\RekognisiDosen;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekognisiDosenController extends Controller
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
        return view('dosen.rekognisi_dosen');
    }

    public function show(Request $request)
    {
        if (Auth::user()->id) {
            $tahunList = TahunAkademik::all();
            $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

            $rekognisi_dosen = RekognisiDosen::where('user_id', Auth::user()->id)
                ->where('rekognisi_dosen.tahun_akademik_id', $tahunTerpilih)
                ->get();

            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            // dan prodi_id yang sesuai dengan user yang sedang login
            $tabel = (new RekognisiDosen())->getTable(); 
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
        return view('dosen.rekognisi_dosen', get_defined_vars());
    }

    public function add(Request $request)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();

        // Format URL
        $formattedUrl = $this->formatUrl($request->url);

        RekognisiDosen::create([
            'user_id' => Auth::user()->id,
            'tahun_akademik_id' => $tahunAktif->id,
            'nama' => ProfilDosen::where('user_id', Auth::user()->id)->value('nama'),
            'nidn' => ProfilDosen::where('user_id', Auth::user()->id)->value('nidn'),
            'nama_kegiatan_rekognisi' => $request->nama_kegiatan_rekognisi,
            'tingkat' => $request->tingkat,
            'bahan_ajar' => $request->bahan_ajar,
            'tahun_perolehan' => $request->tahun_perolehan,
            'url' => $formattedUrl,
            'parent_id' => Auth::user()->parent_id
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();
        // Format URL
        $formattedUrl = $this->formatUrl($request->url);

        $rekognisi_dosen = RekognisiDosen::find($id);
        $rekognisi_dosen->user_id = Auth::user()->id;
        $rekognisi_dosen->tahun_akademik_id = $tahunAktif->id;
        $rekognisi_dosen->nama = $request->nama;
        $rekognisi_dosen->nidn = $request->nidn;
        $rekognisi_dosen->nama_kegiatan_rekognisi = $request->nama_kegiatan_rekognisi;
        $rekognisi_dosen->tingkat = $request->tingkat;
        $rekognisi_dosen->bahan_ajar = $request->bahan_ajar;
        $rekognisi_dosen->tahun_perolehan = $request->tahun_perolehan;
        $rekognisi_dosen->url = $formattedUrl;
        $rekognisi_dosen->save();
        

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $rekognisi_dosen = RekognisiDosen::find($id);
        $rekognisi_dosen->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function exportCsv()
    {
        $records = RekognisiDosen::where('user_id', Auth::user()->id)
                            ->where('tahun_akademik_id', TahunAkademik::where('is_active', true)->value('id'))
                            ->get();

        $filename = 'Rekognisi Dosen_' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'No', 'Nama', 'NIDN', 'Nama Kegiatan Rekognisi', 'Tingkat', 'Bahan Ajar', 'Tahun Perolehan', 'URL'
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
