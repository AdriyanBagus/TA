<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\PengembanganTenagaKependidikan;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengembanganTenagaKependidikanController extends Controller
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
        return view('pages.pengembangan_tenaga_kependidikan');
    }

    public function show()
    {
        if (Auth::user()->id) {
            // Ambil daftar tahun akademik
            $tahunList = TahunAkademik::all();
            $tahunTerpilih = request()->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

            $pengembangan_tenaga_kependidikan = PengembanganTenagaKependidikan::where('user_id', Auth::user()->id)
                ->where('pengembangan_tenaga_kependidikan.tahun_akademik_id', $tahunTerpilih)
                ->get();

            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            // dan prodi_id yang sesuai dengan user yang sedang login
            $tabel = (new PengembanganTenagaKependidikan())->getTable(); 
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
        return view('pages.pengembangan_tenaga_kependidikan', compact('pengembangan_tenaga_kependidikan', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function add(Request $request)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();

        // Format URL
        $formattedUrl = $this->formatUrl($request->url);

        PengembanganTenagaKependidikan::create([
            'user_id' => Auth::user()->id,
            'tahun_akademik_id' => $tahunAktif->id,
            'nama' => $request->nama,
            'nipy' => $request->nipy,
            'nama_kegiatan' => $request->nama_kegiatan,
            'waktu_pelaksanaan' => $request->waktu_pelaksanaan,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'url' => $formattedUrl,
        ]);

        return redirect()->back()->with('success', 'Data Visi & Misi berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();
        // Format URL
        $formattedUrl = $this->formatUrl($request->url);

        $pengembangan_tenaga_kependidikan = PengembanganTenagaKependidikan::find($id);
        $pengembangan_tenaga_kependidikan->user_id = Auth::user()->id;
        $pengembangan_tenaga_kependidikan->tahun_akademik_id = $tahunAktif->id;
        $pengembangan_tenaga_kependidikan->nama = $request->nama;
        $pengembangan_tenaga_kependidikan->nipy = $request->nipy;
        $pengembangan_tenaga_kependidikan->nama_kegiatan = $request->nama_kegiatan;
        $pengembangan_tenaga_kependidikan->waktu_pelaksanaan = $request->waktu_pelaksanaan;
        $pengembangan_tenaga_kependidikan->jenis_kegiatan = $request->jenis_kegiatan;
        $pengembangan_tenaga_kependidikan->url = $formattedUrl;
        $pengembangan_tenaga_kependidikan->save();

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $pengembangan_tenaga_kependidikan = PengembanganTenagaKependidikan::find($id);
        $pengembangan_tenaga_kependidikan->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function exportCsv()
    {
        $records = PengembanganTenagaKependidikan::where('user_id', Auth::user()->id)
                            ->where('tahun_akademik_id', TahunAkademik::where('is_active', true)->value('id'))
                            ->get();

        $filename = 'Pengembangan Tenaga Kependidikan_' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'No', 'Nama', 'NIPY','Nama Kegiatan', 'Waktu Pelaksanaan', 'Jenis Kegiatan','Url'
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
                    $record->nipy,
                    $record->nama_kegiatan,
                    $record->waktu_pelaksanaan,
                    $record->jenis_kegiatan,
                    $record->url
                ], ';', '"');
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
