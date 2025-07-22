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
        // Diarahkan ke fungsi show() saja agar logikanya terpusat
        return $this->show(new Request());
    }

    public function show(Request $request)
    {
        if (Auth::user()->id) {
            $tahunList = TahunAkademik::all();
            $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

            $publikasi_karya_ilmiah = PublikasiKaryaIlmiah::where('user_id', Auth::id())
                ->where('publikasi_karya_ilmiah.tahun_akademik_id', $tahunTerpilih)
                ->get();

            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            // dan prodi_id yang sesuai dengan user yang sedang login
            $tabel = (new PublikasiKaryaIlmiah())->getTable();
            // Untuk komentar, mungkin masih menggunakan parent_id agar admin prodi bisa lihat. 
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->parent_id)->get();
        }
    
        return view('dosen.publikasi_karya_ilmiah', get_defined_vars());
    }

    public function add(Request $request)
    {
        $tahunAktif = TahunAkademik::where('is_active', true)->first();
        $formattedUrl = $this->formatUrl($request->url);

        // Gemi's Edit: Mengambil data 'detail' sebagai array
        $detailPublikasi = $request->input('detail', []);

        PublikasiKaryaIlmiah::create([
            // Simpan data dengan user_id yang sesuai dengan dosen yang sedang login
            'user_id' => Auth::id(),
            'judul_penelitian' => $request->judul_penelitian,
            'judul_publikasi' => $request->judul_publikasi,
            'nama_author' => $request->nama_author,
            // 'nama_jurnal' => $request->jenis === 'Jurnal' ? $request->nama_jurnal : null, // Hanya simpan jika jenisnya Jurnal
            'jenis' => $request->jenis,
            'tingkat' => $request->tingkat,
            'url' =>  $formattedUrl,
            'detail_publikasi' => $detailPublikasi, // Menyimpan semua data 'ajaib' ke dalam satu kolom
            'tahun_akademik_id' => $tahunAktif->id,
            'parent_id' => Auth::user()->parent_id
        ]);

        return redirect()->route('dosen.publikasi_karya_ilmiah')->with('success', 'Data Publikasi Karya Ilmiah berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $formattedUrl = $this->formatUrl($request->url);
        $tahunAktif = TahunAkademik::where('is_active', true)->first();
        
        $publikasi_karya_ilmiah = PublikasiKaryaIlmiah::find($id);

        // Pastikan hanya pemilik data yang bisa mengedit
        if ($publikasi_karya_ilmiah->user_id != Auth::id()) {
            abort(403);
        }

        $detailPublikasi = $request->input('detail', []);

        $publikasi_karya_ilmiah->update([
            'judul_penelitian' => $request->judul_penelitian, 
            'judul_publikasi' => $request->judul_publikasi,
            'nama_author' => $request->nama_author,
            'jenis' => $request->jenis,
            'tingkat' => $request->tingkat,
            'url' => $formattedUrl,
            'detail_publikasi' => $detailPublikasi,
        ]);

        return redirect()->route('dosen.publikasi_karya_ilmiah')->with('success', 'Data Publikasi Karya Ilmiah berhasil diubah!');
    }

    public function destroy($id)
    {
        $publikasi_karya_ilmiah = PublikasiKaryaIlmiah::find($id);

        // Pastikan hanya pemilik data yang bisa menghapus
        if ($publikasi_karya_ilmiah->user_id != Auth::id()) {
            abort(403);
        }

        $publikasi_karya_ilmiah->delete();

        return redirect()->route('dosen.publikasi_karya_ilmiah')->with('success', 'Data Publikasi Karya Ilmiah berhasil dihapus!');
    }

    public function exportCsv()
    {
        $records = PublikasiKaryaIlmiah::where('user_id', Auth::user()->id)
            ->where('tahun_akademik_id', TahunAkademik::where('is_active', true)->value('id'))
            ->get();

        $filename = 'Publikasi_Karya_Ilmiah_' . date('Y-m-d') . '.csv';
        $headers = [ "Content-type" => "text/csv", "Content-Disposition" => "attachment; filename=$filename", "Pragma" => "no-cache", "Cache-Control" => "must-revalidate, post-check=0, pre-check=0", "Expires" => "0" ];

        // Gemi's Edit: Menyiapkan semua kemungkinan kolom detail
        $possibleDetails = [
            'nama_jurnal', 'volume_nomor_jurnal', 'link_doi_jurnal', 'nama_penerbit', 'tahun_terbit', 'isbn',
            'nama_konferensi', 'penyelenggara', 'tanggal_pelaksanaan', 'nama_acara', 'peran', 'penyelenggara_seminar',
            'judul_buku_induk', 'nama_editor', 'penerbit_buku', 'nama_media', 'tanggal_tayang', 'link_berita'
        ];
        
        $baseColumns = ['No', 'Judul Penelitian', 'Judul Publikasi', 'Nama Author', 'Jenis', 'Tingkat', 'URL Pendukung'];
        $columns = array_merge($baseColumns, $possibleDetails);

        $callback = function() use ($records, $columns, $possibleDetails) {
            $handle = fopen('php://output', 'w');
            echo chr(239) . chr(187) . chr(191);
            fputcsv($handle, $columns, ';', '"');

            $no = 1;
            foreach ($records as $record) {
                $rowData = [
                    $no++,
                    $record->judul_penelitian,
                    $record->judul_publikasi,
                    $record->nama_author,
                    $record->jenis,
                    $record->tingkat,
                    $record->url,
                ];

                // "Membongkar" isi laci serbaguna dan meletakkannya di kolom yang benar
                foreach($possibleDetails as $detailKey) {
                    $rowData[] = $record->detail_publikasi[$detailKey] ?? '';
                }
                
                fputcsv($handle, $rowData, ';', '"');
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}