<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\PrestasiMahasiswa;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrestasiMahasiswaController extends Controller
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
        return view('pages.prestasi_mahasiswa');
    }

    public function show(Request $request)
    {
        if (Auth::user()->id) {
            
            $tahunList = TahunAkademik::all();
            $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

            $prestasi_mahasiswa = PrestasiMahasiswa::where('user_id', Auth::user()->id)
                                                ->where('prestasi_mahasiswa.tahun_akademik_id', $tahunTerpilih)
                                                ->get();

            // dan prodi_id yang sesuai dengan user yang sedang login
            $tabel = (new PrestasiMahasiswa())->getTable(); 
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
        return view('pages.prestasi_mahasiswa', compact('prestasi_mahasiswa', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function add(Request $request)
    {
        // Ambil tahun akademik aktif
        $tahunAktif = TahunAkademik::where('is_active', true)->first();
        // Format URL
        $formattedUrl = $this->formatUrl($request->url);

        PrestasiMahasiswa::create([
            'user_id' => Auth::user()->id,
            'tahun_akademik_id' => $tahunAktif->id,
            'nama' => $request->nama,
            'jenis_prestasi' => $request->jenis_prestasi,
            'nama_prestasi' => $request->nama_prestasi,
            'tingkat' => $request->tingkat,
            'tahun' => $request->tahun,
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

        $prestasi_mahasiswa = PrestasiMahasiswa::find($id);
        $prestasi_mahasiswa->user_id = Auth::user()->id;
        $prestasi_mahasiswa->tahun_akademik_id = $tahunAktif->id;
        $prestasi_mahasiswa->nama = $request->nama;
        $prestasi_mahasiswa->jenis_prestasi = $request->jenis_prestasi;
        $prestasi_mahasiswa->nama_prestasi = $request->nama_prestasi;
        $prestasi_mahasiswa->tingkat = $request->tingkat;
        $prestasi_mahasiswa->tahun = $request->tahun;
        $prestasi_mahasiswa->url = $formattedUrl;
        $prestasi_mahasiswa->save();

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $prestasi_mahasiswa = PrestasiMahasiswa::find($id);
        $prestasi_mahasiswa->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function exportCsv()
    {
        $records = PrestasiMahasiswa::where('user_id', Auth::user()->id)
                            ->where('tahun_akademik_id', TahunAkademik::where('is_active', true)->value('id'))
                            ->get();

        $filename = 'Prestasi Mahasiswa_' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'No', 'Nama', 'Jenis Prestasi','Nama Prestasi', 'Tingkat', 'Tahun', 'Url'
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
                    $record->jenis_prestasi,
                    $record->nama_prestasi,
                    $record->tingkat,
                    $record->tahun,
                    $record->url
                ], ';', '"');
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
