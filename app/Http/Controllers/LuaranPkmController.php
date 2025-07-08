<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\LuaranPkm;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LuaranPkmController extends Controller
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
        return view('dosen.luaran_pkm');
    }

    public function show(Request $request)
    {
        if (Auth::user()->id) {
            $tahunList = TahunAkademik::all();
            $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

            $luaran_pkm = LuaranPkm::where('user_id', Auth::user()->id)
                ->where('luaran_pkm.tahun_akademik_id', $tahunTerpilih)
                ->get();

            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            // dan prodi_id yang sesuai dengan user yang sedang login
            $tabel = (new LuaranPkm())->getTable(); 
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
    
        return view('dosen.luaran_pkm', get_defined_vars()); 
    }

    public function add(Request $request)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();
        // Format URL
        $formattedUrl = $this->formatUrl($request->url);
        
        LuaranPkm::create([
            'user_id' => Auth::user()->id,
            'tahun_akademik_id' => $tahunAktif->id,
            'judul_pkm' => $request->judul_pkm,
            'judul_karya' => $request->judul_karya,
            'pencipta_utama' => $request->pencipta_utama,
            'jenis' => $request->jenis,
            'nomor_karya' => $request->nomor_karya,
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

        $luaran_pkm = LuaranPkm::find($id);
        $luaran_pkm->tahun_akademik_id = $tahunAktif->id;
        $luaran_pkm->judul_pkm = $request->judul_pkm;
        $luaran_pkm->judul_karya = $request->judul_karya;
        $luaran_pkm->pencipta_utama = $request->pencipta_utama;
        $luaran_pkm->jenis = $request->jenis;
        $luaran_pkm->nomor_karya = $request->nomor_karya;
        $luaran_pkm->url = $formattedUrl;
        $luaran_pkm->user_id = Auth::user()->id;
        $luaran_pkm->save();

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $luaran_pkm = LuaranPkm::find($id);
        $luaran_pkm->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function exportCsv()
    {
        $records = LuaranPkm::where('user_id', Auth::user()->id)
                            ->where('tahun_akademik_id', TahunAkademik::where('is_active', true)->value('id'))
                            ->get();

        $filename = 'Luaran PKM_' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'No', 'Judul Penelitian', 'Judul Karya','Pencipta Utama', 'Jenis Karya', 'Nomor Karya', 'Url'
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
                    $record->judul_pkm,
                    $record->judul_karya,
                    $record->pencipta_utama,
                    $record->jenis,
                    $record->nomor_karya,
                    $record->url
                ], ';', '"');
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
