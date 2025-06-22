<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\PengembanganDosen;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengembanganDosenController extends Controller
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
        return view('pages.pengembangan_dosen');
    }

    public function show()
    {
        if (Auth::user()->id) {
            // Ambil daftar tahun akademik
            $tahunList = TahunAkademik::all();
            $tahunTerpilih = request()->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

            $pengembangan_dosen = PengembanganDosen::where('user_id', Auth::user()->id)
                ->where('pengembangan_dosen.tahun_akademik_id', $tahunTerpilih)
                ->get();

            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            // dan prodi_id yang sesuai dengan user yang sedang login
            $tabel = (new PengembanganDosen())->getTable(); 
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
        return view('pages.pengembangan_dosen', compact('pengembangan_dosen', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function add(Request $request)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();

        // Format URL
        $formattedUrl = $this->formatUrl($request->url);

        PengembanganDosen::create([
            'user_id' => Auth::user()->id,
            'tahun_akademik_id' => $tahunAktif->id,
            'nama_dosen' => $request->nama_dosen,
            'nidn' => $request->nidn,
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

        $pengembangan_dosen = PengembanganDosen::find($id);
        $pengembangan_dosen->user_id = Auth::user()->id;
        $pengembangan_dosen->tahun_akademik_id = $tahunAktif->id;
        $pengembangan_dosen->nama_dosen = $request->nama_dosen;
        $pengembangan_dosen->nidn = $request->nidn;
        $pengembangan_dosen->nama_kegiatan = $request->nama_kegiatan;
        $pengembangan_dosen->waktu_pelaksanaan = $request->waktu_pelaksanaan;
        $pengembangan_dosen->jenis_kegiatan = $request->jenis_kegiatan;
        $pengembangan_dosen->url = $formattedUrl;
        $pengembangan_dosen->save();

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $pengembangan_dosen = PengembanganDosen::find($id);
        $pengembangan_dosen->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function exportCsv()
    {
        $records = PengembanganDosen::where('user_id', Auth::user()->id)
                            ->where('tahun_akademik_id', TahunAkademik::where('is_active', true)->value('id'))
                            ->get();

        $filename = 'Pengembangan Dosen_' . date('Y-m-d') . '.csv';
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
