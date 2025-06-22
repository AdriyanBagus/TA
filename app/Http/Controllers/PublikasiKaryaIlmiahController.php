<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\PublikasiKaryaIlmiah;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublikasiKaryaIlmiahController extends Controller
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
        return view('pages.publikasi_karya_ilmiah');
    }

    public function show(Request $request)
    {
        if (Auth::user()->id) {
            $tahunList = TahunAkademik::all();
            $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

            $publikasi_karya_ilmiah = PublikasiKaryaIlmiah::where('user_id', Auth::user()->id)
                ->where('publikasi_karya_ilmiah.tahun_akademik_id', $tahunTerpilih)
                ->get();

            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            // dan prodi_id yang sesuai dengan user yang sedang login
            $tabel = (new PublikasiKaryaIlmiah())->getTable(); 
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
    
        return view('pages.publikasi_karya_ilmiah', compact('publikasi_karya_ilmiah', 'komentar','tahunList', 'tahunTerpilih'));
    }

    public function add(Request $request)
    {
        $tahunAktif = TahunAkademik::where('is_active', true)->first();
        $formattedUrl = $this->formatUrl($request->url);

        PublikasiKaryaIlmiah::create([
            'user_id' => Auth::user()->id,
            'judul_penelitian' => $request->judul_penelitian,
            'judul_publikasi' => $request->judul_publikasi,
            'nama_author' => $request->nama_author,
            'nama_jurnal' => $request->nama_jurnal,
            'jenis' => $request->jenis,
            'tingkat' => $request->tingkat,
            'url' =>  $formattedUrl,
            'tahun_akademik_id' => $tahunAktif->id
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $formattedUrl = $this->formatUrl($request->url);
        $tahunAktif = TahunAkademik::where('is_active', true)->first();
        
        $publikasi_karya_ilmiah = PublikasiKaryaIlmiah::find($id);
        $publikasi_karya_ilmiah->judul_penelitian = $request->judul_penelitian;
        $publikasi_karya_ilmiah->judul_publikasi = $request->judul_publikasi;
        $publikasi_karya_ilmiah->nama_author = $request->nama_author;
        $publikasi_karya_ilmiah->nama_jurnal = $request->nama_jurnal;
        $publikasi_karya_ilmiah->jenis = $request->jenis;
        $publikasi_karya_ilmiah->tingkat = $request->tingkat;
        $publikasi_karya_ilmiah->url =  $formattedUrl;
        $publikasi_karya_ilmiah->tahun_akademik_id = $tahunAktif->id;
        $publikasi_karya_ilmiah->user_id = Auth::user()->id;
        $publikasi_karya_ilmiah->save();

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $publikasi_karya_ilmiah = PublikasiKaryaIlmiah::find($id);
        $publikasi_karya_ilmiah->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function exportCsv()
    {
        $records = PublikasiKaryaIlmiah::where('user_id', Auth::user()->id)
                            ->where('tahun_akademik_id', TahunAkademik::where('is_active', true)->value('id'))
                            ->get();

        $filename = 'Publikasi Karya Ilmiah_' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'No', 'Judul Penelitian', 'Judul Publikasi','Nama Author', 'Nama Jurnal', 'Jenis','Tingkat', 'Url'
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
                    $record->judul_penelitian,
                    $record->judul_publikasi,
                    $record->nama_author,
                    $record->nama_jurnal,
                    $record->jenis,
                    $record->tingkat,
                    $record->url
                ], ';', '"');
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
