<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BimbinganTaDosen;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TahunAkademik;
use Illuminate\Support\Facades\DB;


class ImportExportController extends Controller
{
    public function exportVisiMisiCSV(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user');
        $sortOrder = $request->get('sort_order', 'asc');

        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id');

        $query = DB::table('visi_misi')
            ->join('users', 'visi_misi.user_id', '=', 'users.id')
            ->select('visi_misi.visi', 'visi_misi.misi', 'visi_misi.deskripsi', 'users.name as nama_user')
            ->where('visi_misi.tahun_akademik_id', $tahunTerpilih);

        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $records = $query->orderBy($sortBy, $sortOrder)->get();

        $filename = "visi_misi_" . date('Y-m-d_H-i-s') . ".xls";

        $headers = [
            "Content-Type" => "application/vnd.ms-excel; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Expires" => "0",
        ];

        $callback = function () use ($records) {
            echo "<table border='1'>";
            echo "<tr>
                <th>No</th>
                <th>Nama Prodi</th>
                <th>Visi</th>
                <th>Misi</th>
                <th>Deskripsi</th>
              </tr>";

            foreach ($records as $i => $record) {
                echo "<tr>";
                echo "<td>" . ($i + 1) . "</td>";
                echo "<td>" . htmlspecialchars($record->nama_user) . "</td>";
                echo "<td>" . htmlspecialchars($record->visi) . "</td>";
                echo "<td>" . htmlspecialchars($record->misi) . "</td>";
                echo "<td>" . htmlspecialchars($record->deskripsi) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportKerjasamaCSV(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user');
        $sortOrder = $request->get('sort_order', 'asc');

        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id');

        // Ambil data
        $query = DB::table('kerjasama')
            ->join('users', 'kerjasama.user_id', '=', 'users.id')
            ->select(
                'kerjasama.lembaga_mitra',
                'kerjasama.jenis_kerjasama',
                'kerjasama.tingkat',
                'kerjasama.judul_kerjasama',
                'kerjasama.waktu_durasi',
                'kerjasama.realisasi_kerjasama',
                'kerjasama.spk',
                'users.name as nama_user'
            )
            ->where('kerjasama.tahun_akademik_id', $tahunTerpilih);

        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $records = $query->orderBy($sortBy, $sortOrder)->get();

        $filename = "kerjasama_" . date('Y-m-d_H-i-s') . ".xls";

        $headers = [
            "Content-Type" => "application/vnd.ms-excel; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Expires" => "0",
        ];

        $callback = function () use ($records) {
            echo "<table border='1'>";
            echo "<tr>
                <th>No</th>
                <th>Nama Prodi</th>
                <th>Lembaga Mitra</th>
                <th>Jenis Kerjasama</th>
                <th>Tingkat</th>
                <th>Judul Kerjasama</th>
                <th>Waktu Durasi</th>
                <th>Realisasi Kerjasama</th>
                <th>SPK</th>
              </tr>";

            foreach ($records as $i => $record) {
                echo "<tr>";
                echo "<td>" . ($i + 1) . "</td>";
                echo "<td>" . htmlspecialchars($record->nama_user) . "</td>";
                echo "<td>" . htmlspecialchars($record->lembaga_mitra) . "</td>";
                echo "<td>" . htmlspecialchars($record->jenis_kerjasama) . "</td>";
                echo "<td>" . htmlspecialchars($record->tingkat) . "</td>";
                echo "<td>" . htmlspecialchars($record->judul_kerjasama) . "</td>";
                echo "<td>" . htmlspecialchars($record->waktu_durasi) . "</td>";
                echo "<td>" . htmlspecialchars($record->realisasi_kerjasama) . "</td>";
                echo "<td>" . htmlspecialchars($record->spk) . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportKetersediaanDokumenCSV(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user');
        $sortOrder = $request->get('sort_order', 'asc');

        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id'); // Tangkap user_id

        // Query data
        $query = DB::table('ketersediaan_dokumen')
            ->join('users', 'ketersediaan_dokumen.user_id', '=', 'users.id')
            ->select(
                'ketersediaan_dokumen.dokumen',
                'ketersediaan_dokumen.nomor_dokumen',
                'ketersediaan_dokumen.url',
                'users.name as nama_user'
            )
            ->where('ketersediaan_dokumen.tahun_akademik_id', $tahunTerpilih);

        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $records = $query->orderBy($sortBy, $sortOrder)->get();

        $filename = 'ketersediaan_dokumen_' . date('Y-m-d_H-i-s') . '.xls';

        $headers = [
            "Content-Type" => "application/vnd.ms-excel; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Expires" => "0",
        ];

        $callback = function () use ($records) {
            echo "<table border='1'>";
            echo "<tr>
                <th>No</th>
                <th>Nama Prodi</th>
                <th>Dokumen</th>
                <th>Nomor Dokumen</th>
                <th>Link Dokumen</th>
              </tr>";

            foreach ($records as $i => $record) {
                echo "<tr>";
                echo "<td>" . ($i + 1) . "</td>";
                echo "<td>" . htmlspecialchars($record->nama_user) . "</td>";
                echo "<td>" . htmlspecialchars($record->dokumen) . "</td>";
                echo "<td>" . htmlspecialchars($record->nomor_dokumen) . "</td>";
                // kalau URL mau bisa diklik di Excel → kasih hyperlink
                echo "<td><a href='" . htmlspecialchars($record->url) . "'>" . htmlspecialchars($record->url) . "</a></td>";
                echo "</tr>";
            }

            echo "</table>";
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportEvaluasiPelaksanaanCSV(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user');
        $sortOrder = $request->get('sort_order', 'asc');

        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id'); // Tangkap user_id

        // Query data
        $query = DB::table('evaluasi_pelaksanaan')
            ->join('users', 'evaluasi_pelaksanaan.user_id', '=', 'users.id')
            ->select(
                'evaluasi_pelaksanaan.nomor_ptk',
                'evaluasi_pelaksanaan.kategori_ptk',
                'evaluasi_pelaksanaan.rencana_penyelesaian',
                'evaluasi_pelaksanaan.realisasi_perbaikan',
                'evaluasi_pelaksanaan.penanggungjawab_perbaikan',
                'users.name as nama_user'
            )
            ->where('evaluasi_pelaksanaan.tahun_akademik_id', $tahunTerpilih);

        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $records = $query->orderBy($sortBy, $sortOrder)->get();

        $filename = 'evaluasi_pelaksanaan_' . date('Y-m-d_H-i-s') . '.xls';

        $headers = [
            "Content-Type" => "application/vnd.ms-excel; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Expires" => "0",
        ];

        $callback = function () use ($records) {
            echo "<table border='1'>";
            echo "<tr>
                <th>No</th>
                <th>Nama Prodi</th>
                <th>Nomor PTK</th>
                <th>Kategori PTK</th>
                <th>Rencana Penyelesaian</th>
                <th>Realisasi Perbaikan</th>
                <th>Penanggung Jawab Perbaikan</th>
              </tr>";

            foreach ($records as $i => $record) {
                echo "<tr>";
                echo "<td>" . ($i + 1) . "</td>";
                echo "<td>" . htmlspecialchars($record->nama_user) . "</td>";
                echo "<td>" . htmlspecialchars($record->nomor_ptk) . "</td>";
                echo "<td>" . htmlspecialchars($record->kategori_ptk) . "</td>";
                echo "<td>" . htmlspecialchars($record->rencana_penyelesaian) . "</td>";
                echo "<td>" . htmlspecialchars($record->realisasi_perbaikan) . "</td>";
                echo "<td>" . htmlspecialchars($record->penanggungjawab_perbaikan) . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportProfileDosenCSV(Request $request)
    {
        $sortBy = $request->get('sort_by', 'name'); // 'name' = nama dosen
        $sortOrder = $request->get('sort_order', 'asc');

        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id');

        $query = DB::table('profil_dosen')
            ->join('users', 'profil_dosen.user_id', '=', 'users.id')
            ->leftJoin('users as parent', 'users.parent_id', '=', 'parent.id')
            ->select(
                'users.name as name',
                'parent.name as nama_parent',
                'profil_dosen.kualifikasi_pendidikan',
                'profil_dosen.sertifikasi_pendidik_profesional',
                'profil_dosen.bidang_keahlian',
                'profil_dosen.bidang_ilmu_prodi'
            )
            ->where('profil_dosen.tahun_akademik_id', $tahunTerpilih);

        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $records = $query->orderBy($sortBy, $sortOrder)->get();

        $filename = 'profil_dosen_' . date('Y-m-d_H-i-s') . '.xls';

        $headers = [
            "Content-Type" => "application/vnd.ms-excel; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Expires" => "0",
        ];

        $callback = function () use ($records) {
            echo "<table border='1'>";
            echo "<tr>
            <th>No</th>
            <th>Nama Prodi</th>
            <th>Nama Dosen</th>
            <th>Kualifikasi Pendidikan</th>
            <th>Sertifikat Pendidik Profesional</th>
            <th>Bidang Keahlian</th>
            <th>Bidang Ilmu Prodi</th>
          </tr>";

            foreach ($records as $i => $record) {
                echo "<tr>";
                echo "<td>" . ($i + 1) . "</td>";
                echo "<td>" . htmlspecialchars($record->nama_parent ?? $record->name) . "</td>";
                echo "<td>" . htmlspecialchars($record->name) . "</td>";
                echo "<td>" . htmlspecialchars($record->kualifikasi_pendidikan) . "</td>";
                echo "<td>" . htmlspecialchars($record->sertifikasi_pendidik_profesional) . "</td>";
                echo "<td>" . htmlspecialchars($record->bidang_keahlian) . "</td>";
                echo "<td>" . htmlspecialchars($record->bidang_ilmu_prodi) . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        };

        return response()->stream($callback, 200, $headers);
    }


    public function exportBebanKinerjaDosenCSV(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user');
        $sortOrder = $request->get('sort_order', 'asc');

        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id'); // Tangkap user_id

        // Bangun query
        $query = DB::table('beban_kinerja_dosen')
            ->join('users', 'beban_kinerja_dosen.parent_id', '=', 'users.id')
            ->select(
                'beban_kinerja_dosen.nama',
                'beban_kinerja_dosen.nidn',
                'beban_kinerja_dosen.ps_sendiri',
                'beban_kinerja_dosen.ps_lain',
                'beban_kinerja_dosen.ps_diluar_pt',
                'beban_kinerja_dosen.penelitian',
                'beban_kinerja_dosen.pkm',
                'beban_kinerja_dosen.penunjang',
                'beban_kinerja_dosen.jumlah_sks',
                'beban_kinerja_dosen.rata_rata_sks',
                'users.name as nama_user'
            )
            ->where('beban_kinerja_dosen.tahun_akademik_id', $tahunTerpilih);

        // Tambahkan filter user jika ada
        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $records = $query->orderBy($sortBy, $sortOrder)->get();

        $filename = 'beban_kinerja_dosen' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $columns = ['No', 'Nama Prodi', 'Nama Dosen', 'NIDN', 'Prodi Sendiri', 'Prodi Lain', 'Prodi diluar PT', 'Penelitian', 'PKM', 'Penunjang', 'Jumlah SKS', 'Rata-rata SKS'];

        $callback = function () use ($records, $columns) {
            $handle = fopen('php://output', 'w');
            echo chr(239) . chr(187) . chr(191); // UTF-8 BOM

            fputcsv($handle, $columns, ';', '"');

            foreach ($records as $index => $record) {
                fputcsv($handle, [
                    $index + 1,
                    $record->nama_user,
                    str_replace(["\n", "\r"], ' ', $record->nama),
                    str_replace(["\n", "\r"], ' ', $record->nidn),
                    str_replace(["\n", "\r"], ' ', $record->ps_sendiri),
                    str_replace(["\n", "\r"], ' ', $record->ps_lain),
                    str_replace(["\n", "\r"], ' ', $record->ps_diluar_pt),
                    str_replace(["\n", "\r"], ' ', $record->penelitian),
                    str_replace(["\n", "\r"], ' ', $record->pkm),
                    str_replace(["\n", "\r"], ' ', $record->penunjang),
                    str_replace(["\n", "\r"], ' ', $record->jumlah_sks),
                    str_replace(["\n", "\r"], ' ', $record->rata_rata_sks)
                ], ';', '"');
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportDosenTidakTetapCSV(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user');
        $sortOrder = $request->get('sort_order', 'asc');

        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id'); // Tangkap user_id

        // Bangun query
        $query = DB::table('beban_kinerja_dosen')
            ->join('users', 'beban_kinerja_dosen.user_id', '=', 'users.id')
            ->select(
                'beban_kinerja_dosen.nama',
                'beban_kinerja_dosen.nidn',
                'beban_kinerja_dosen.ps_sendiri',
                'beban_kinerja_dosen.ps_lain',
                'beban_kinerja_dosen.ps_diluar_pt',
                'beban_kinerja_dosen.penelitian',
                'beban_kinerja_dosen.pkm',
                'beban_kinerja_dosen.penunjang',
                'beban_kinerja_dosen.jumlah_sks',
                'beban_kinerja_dosen.rata_rata_sks',
                'users.name as nama_user'
            )
            ->where('beban_kinerja_dosen.tahun_akademik_id', $tahunTerpilih);

        // Tambahkan filter user jika ada
        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $records = $query->orderBy($sortBy, $sortOrder)->get();

        $filename = 'beban_kinerja_dosen' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $columns = ['No', 'Nama Prodi', 'Nama Dosen', 'NIDN', 'Prodi Sendiri', 'Prodi Lain', 'Prodi diluar PT', 'Penelitian', 'PKM', 'Penunjang', 'Jumlah SKS', 'Rata-rata SKS'];

        $callback = function () use ($records, $columns) {
            $handle = fopen('php://output', 'w');
            echo chr(239) . chr(187) . chr(191); // UTF-8 BOM

            fputcsv($handle, $columns, ';', '"');

            foreach ($records as $index => $record) {
                fputcsv($handle, [
                    $index + 1,
                    $record->nama_user,
                    str_replace(["\n", "\r"], ' ', $record->nama),
                    str_replace(["\n", "\r"], ' ', $record->nidn),
                    str_replace(["\n", "\r"], ' ', $record->ps_sendiri),
                    str_replace(["\n", "\r"], ' ', $record->ps_lain),
                    str_replace(["\n", "\r"], ' ', $record->ps_diluar_pt),
                    str_replace(["\n", "\r"], ' ', $record->penelitian),
                    str_replace(["\n", "\r"], ' ', $record->pkm),
                    str_replace(["\n", "\r"], ' ', $record->penunjang),
                    str_replace(["\n", "\r"], ' ', $record->jumlah_sks),
                    str_replace(["\n", "\r"], ' ', $record->rata_rata_sks)
                ], ';', '"');
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPelaksanaTACSV(Request $request)
    {
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        // Ambil semua dosen
        $semuaDosen = User::where('usertype', 'dosen')->get();

        // Ambil semua data bimbingan berdasarkan tahun akademik
        $semuaBimbingan = BimbinganTaDosen::where('tahun_akademik_id', $tahunTerpilih)->get();

        // Siapkan array data
        $records = [];

        foreach ($semuaDosen as $dosen) {
            $bimbinganDosen = $semuaBimbingan->where('user_id', $dosen->id);

            $psSendiri = $bimbinganDosen->where('prodi_mahasiswa', $dosen->bidang_ilmu_prodi);
            $psLain = $bimbinganDosen->where('prodi_mahasiswa', '!=', $dosen->bidang_ilmu_prodi);

            $records[] = (object) [
                'nama_user' => User::find($dosen->parent_id)->name,
                'nama' => $dosen->name,
                'nidn' => $dosen->nidn,
                'bimbingan_mahasiswa_ps' => $psSendiri->unique('nama_mahasiswa')->count(),
                'rata_rata_jumlah_bimbingan' => $psSendiri->unique('nama_mahasiswa')->count(),
                'bimbingan_mahasiswa_ps_lain' => $psLain->unique('nama_mahasiswa')->count(),
                'rata_rata_jumlah_bimbingan_seluruh_ps' => $bimbinganDosen->unique('nama_mahasiswa')->count(),
            ];
        }

        $filename = 'pelaksanaan_ta_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $columns = ['No', 'Nama Prodi', 'Nama Dosen', 'NIDN', 'Bimbingan Mahasiswa', 'Rata-rata Jumlah Bimbingan', 'Bimbingan Mahasiswa Program Studi Lain', 'Rata-rata jumlah bimbingan seluruh program studi'];

        $callback = function () use ($records, $columns) {
            $handle = fopen('php://output', 'w');
            echo chr(239) . chr(187) . chr(191); // UTF-8 BOM

            fputcsv($handle, $columns, ';', '"');

            foreach ($records as $index => $record) {
                fputcsv($handle, [
                    $index + 1,
                    $record->nama_user,
                    $record->nama,
                    $record->nidn,
                    $record->bimbingan_mahasiswa_ps,
                    $record->rata_rata_jumlah_bimbingan,
                    $record->bimbingan_mahasiswa_ps_lain,
                    $record->rata_rata_jumlah_bimbingan_seluruh_ps,
                ], ';', '"');
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }


    public function exportLahanPraktekCSV(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user');
        $sortOrder = $request->get('sort_order', 'asc');

        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id'); // Tangkap user_id

        // Bangun query
        $query = DB::table('lahan_praktek')
            ->join('users', 'lahan_praktek.user_id', '=', 'users.id')
            ->select(
                'lahan_praktek.lahan_praktek',
                'lahan_praktek.akreditasi',
                'lahan_praktek.kesesuaian_bidang_keilmuan',
                'lahan_praktek.jumlah_mahasiswa',
                'lahan_praktek.daya_tampung_mahasiswa',
                'lahan_praktek.kontribusi_lahan_praktek',
                'users.name as nama_user'
            )
            ->where('lahan_praktek.tahun_akademik_id', $tahunTerpilih);

        // Tambahkan filter user jika ada
        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $records = $query->orderBy($sortBy, $sortOrder)->get();

        $filename = 'lahan_praktek_' . date('Y-m-d_H-i-s') . '.xls';

        $headers = [
            "Content-Type" => "application/vnd.ms-excel; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Expires" => "0",
        ];

        $callback = function () use ($records) {
            echo "<table border='1'>";
            echo "<tr>
            <th>No</th>
            <th>Nama Prodi</th>
            <th>Lahan Praktek</th>
            <th>Akreditasi</th>
            <th>Kesesuaian Bidang Keilmuan</th>
            <th>Jumlah Mahasiswa</th>
            <th>Daya Tampung Mahasiswa</th>
            <th>Kontribusi Lahan Praktek</th>
          </tr>";

            foreach ($records as $i => $record) {
                echo "<tr>";
                echo "<td>" . ($i + 1) . "</td>";
                echo "<td>" . htmlspecialchars($record->nama_user) . "</td>";
                echo "<td>" . htmlspecialchars($record->lahan_praktek) . "</td>";
                echo "<td>" . htmlspecialchars($record->akreditasi) . "</td>";
                echo "<td>" . htmlspecialchars($record->kesesuaian_bidang_keilmuan) . "</td>";
                echo "<td>" . htmlspecialchars($record->jumlah_mahasiswa) . "</td>";
                echo "<td>" . htmlspecialchars($record->daya_tampung_mahasiswa) . "</td>";
                echo "<td>" . htmlspecialchars($record->kontribusi_lahan_praktek) . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportKinerjaDTPSCSV(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user');
        $sortOrder = $request->get('sort_order', 'asc');

        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id'); // Tangkap user_id

        // Bangun query
        $query = DB::table('kinerja_dtps')
            ->join('users', 'kinerja_dtps.user_id', '=', 'users.id')
            ->select(
                'kinerja_dtps.nama_dosen',
                'kinerja_dtps.nidn',
                'kinerja_dtps.jenis_rekognisi',
                'kinerja_dtps.nama_kegiatan',
                'kinerja_dtps.tingkat',
                'kinerja_dtps.tahun_perolehan',
                'users.name as nama_user'
            )
            ->where('kinerja_dtps.tahun_akademik_id', $tahunTerpilih);

        // Tambahkan filter user jika ada
        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $records = $query->orderBy($sortBy, $sortOrder)->get();

        $filename = 'kinerja_dtps' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $columns = ['No', 'Nama Prodi', 'Nama Dosen', 'NIDN', 'Jenis Rekognisi', 'Nama kegiatan', 'Tingkat', 'Tahun Perolehan'];

        $callback = function () use ($records, $columns) {
            $handle = fopen('php://output', 'w');
            echo chr(239) . chr(187) . chr(191); // UTF-8 BOM

            fputcsv($handle, $columns, ';', '"');

            foreach ($records as $index => $record) {
                fputcsv($handle, [
                    $index + 1,
                    $record->nama_user,
                    str_replace(["\n", "\r"], ' ', $record->nama_dosen),
                    str_replace(["\n", "\r"], ' ', $record->nidn),
                    str_replace(["\n", "\r"], ' ', $record->jenis_rekognisi),
                    str_replace(["\n", "\r"], ' ', $record->nama_kegiatan),
                    str_replace(["\n", "\r"], ' ', $record->tingkat),
                    str_replace(["\n", "\r"], ' ', $record->tahun_perolehan),
                ], ';', '"');
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportProfileTenagaKependidikanCSV(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user');
        $sortOrder = $request->get('sort_order', 'asc');

        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id'); // Tangkap user_id

        // Bangun query
        $query = DB::table('profil_tenaga_kependidikan')
            ->join('users', 'profil_tenaga_kependidikan.user_id', '=', 'users.id')
            ->select(
                'profil_tenaga_kependidikan.nama',
                'profil_tenaga_kependidikan.nipy',
                'profil_tenaga_kependidikan.kualifikasi_pendidikan',
                'profil_tenaga_kependidikan.jabatan',
                'profil_tenaga_kependidikan.kesesuaian_bidang_kerja',
                'users.name as nama_user'
            )
            ->where('profil_tenaga_kependidikan.tahun_akademik_id', $tahunTerpilih);

        // Tambahkan filter user jika ada
        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $records = $query->orderBy($sortBy, $sortOrder)->get();

        $filename = 'profil_tenaga_kependidikan' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $columns = ['No', 'Nama Prodi', 'Nama', 'NIPY', 'Kualifikasi Pendidikan', 'Jabatan', 'Kesesuaian Bidang Kerja'];

        $callback = function () use ($records, $columns) {
            $handle = fopen('php://output', 'w');
            echo chr(239) . chr(187) . chr(191); // UTF-8 BOM

            fputcsv($handle, $columns, ';', '"');

            foreach ($records as $index => $record) {
                fputcsv($handle, [
                    $index + 1,
                    $record->nama_user,
                    str_replace(["\n", "\r"], ' ', $record->nama),
                    str_replace(["\n", "\r"], ' ', $record->nipy),
                    str_replace(["\n", "\r"], ' ', $record->kualifikasi_pendidikan),
                    str_replace(["\n", "\r"], ' ', $record->jabatan),
                    str_replace(["\n", "\r"], ' ', $record->kesesuaian_bidang_kerja),
                ], ';', '"');
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportRekognisiTenagaKependidikanCSV(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user');
        $sortOrder = $request->get('sort_order', 'asc');

        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id'); // Tangkap user_id

        // Bangun query
        $query = DB::table('rekognisi_tenaga_kependidikan')
            ->join('users', 'rekognisi_tenaga_kependidikan.user_id', '=', 'users.id')
            ->select(
                'rekognisi_tenaga_kependidikan.nama',
                'rekognisi_tenaga_kependidikan.bidang_keahlian',
                'rekognisi_tenaga_kependidikan.jenis_rekognisi',
                'rekognisi_tenaga_kependidikan.tingkat',
                'rekognisi_tenaga_kependidikan.tahun_perolehan',
                'users.name as nama_user'
            )
            ->where('rekognisi_tenaga_kependidikan.tahun_akademik_id', $tahunTerpilih);

        // Tambahkan filter user jika ada
        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $records = $query->orderBy($sortBy, $sortOrder)->get();

        $filename = 'rekognisi_tenaga_kependidikan' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $columns = ['No', 'Nama Prodi', 'Nama', 'Bidang Keahlian', 'Jenis Rekognisi', 'Tingkat', 'Tahun Perolehan'];

        $callback = function () use ($records, $columns) {
            $handle = fopen('php://output', 'w');
            echo chr(239) . chr(187) . chr(191); // UTF-8 BOM

            fputcsv($handle, $columns, ';', '"');

            foreach ($records as $index => $record) {
                fputcsv($handle, [
                    $index + 1,
                    $record->nama_user,
                    str_replace(["\n", "\r"], ' ', $record->nama),
                    str_replace(["\n", "\r"], ' ', $record->bidang_keahlian),
                    str_replace(["\n", "\r"], ' ', $record->jenis_rekognisi),
                    str_replace(["\n", "\r"], ' ', $record->tingkat),
                    str_replace(["\n", "\r"], ' ', $record->tahun_perolehan),
                ], ';', '"');
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPenelitianDosenCSV(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user');
        $sortOrder = $request->get('sort_order', 'asc');

        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id'); // Tangkap user_id

        // Bangun query
        $query = DB::table('penelitian_dosen')
            ->join('users', 'penelitian_dosen.user_id', '=', 'users.id')
            ->select(
                'penelitian_dosen.judul_penelitian',
                'penelitian_dosen.nama_dosen_peneliti',
                'penelitian_dosen.nama_mahasiswa',
                'penelitian_dosen.tingkat',
                'penelitian_dosen.sumber_dana',
                'penelitian_dosen.kesesuaian_roadmap',
                'penelitian_dosen.bentuk_integrasi',
                'penelitian_dosen.mata_kuliah',
                'users.name as nama_user'
            )
            ->where('penelitian_dosen.tahun_akademik_id', $tahunTerpilih);

        // Tambahkan filter user jika ada
        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $records = $query->orderBy($sortBy, $sortOrder)->get();

        $filename = 'rekognisi_tenaga_kependidikan' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $columns = ['No', 'Nama Prodi', 'Judul Penelitian', 'Nama Dosen Peneliti', 'Nama Mahasiswa', 'Tingkat', 'Sumber dana', 'Kesesuaian Roadmap', 'Bentuk Integrasi', 'Mata Kuliah'];

        $callback = function () use ($records, $columns) {
            $handle = fopen('php://output', 'w');
            echo chr(239) . chr(187) . chr(191); // UTF-8 BOM

            fputcsv($handle, $columns, ';', '"');

            foreach ($records as $index => $record) {
                fputcsv($handle, [
                    $index + 1,
                    $record->nama_user,
                    str_replace(["\n", "\r"], ' ', $record->judul_penelitian),
                    str_replace(["\n", "\r"], ' ', $record->nama_dosen_peneliti),
                    str_replace(["\n", "\r"], ' ', $record->nama_mahasiswa),
                    str_replace(["\n", "\r"], ' ', $record->tingkat),
                    str_replace(["\n", "\r"], ' ', $record->sumber_dana),
                    str_replace(["\n", "\r"], ' ', $record->kesesuaian_roadmap),
                    str_replace(["\n", "\r"], ' ', $record->bentuk_integrasi),
                    str_replace(["\n", "\r"], ' ', $record->mata_kuliah),
                ], ';', '"');
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPenelitianMahasiswaCSV(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user');
        $sortOrder = $request->get('sort_order', 'asc');

        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id'); // Tangkap user_id

        // Bangun query
        $query = DB::table('penelitian_mahasiswa')
            ->join('users', 'penelitian_mahasiswa.user_id', '=', 'users.id')
            ->select(
                'penelitian_mahasiswa.judul_penelitian',
                'penelitian_mahasiswa.nama_mahasiswa',
                'penelitian_mahasiswa.nama_pembimbing',
                'penelitian_mahasiswa.tingkat',
                'penelitian_mahasiswa.sumber_dana',
                'penelitian_mahasiswa.kesesuaian_roadmap',
                'users.name as nama_user'
            )
            ->where('penelitian_mahasiswa.tahun_akademik_id', $tahunTerpilih);

        // Tambahkan filter user jika ada
        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $records = $query->orderBy($sortBy, $sortOrder)->get();

        $filename = 'penelitian_mahasiswa' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $columns = ['No', 'Nama Prodi', 'Judul Penelitian', 'Nama Dosen Peneliti', 'Nama Mahasiswa', 'Tingkat', 'Sumber dana', 'Kesesuaian Roadmap', 'Bentuk Integrasi', 'Mata Kuliah'];

        $callback = function () use ($records, $columns) {
            $handle = fopen('php://output', 'w');
            echo chr(239) . chr(187) . chr(191); // UTF-8 BOM

            fputcsv($handle, $columns, ';', '"');

            foreach ($records as $index => $record) {
                fputcsv($handle, [
                    $index + 1,
                    $record->nama_user,
                    str_replace(["\n", "\r"], ' ', $record->judul_penelitian),
                    str_replace(["\n", "\r"], ' ', $record->nama_mahasiswa),
                    str_replace(["\n", "\r"], ' ', $record->nama_pembimbing),
                    str_replace(["\n", "\r"], ' ', $record->tingkat),
                    str_replace(["\n", "\r"], ' ', $record->sumber_dana),
                    str_replace(["\n", "\r"], ' ', $record->kesesuaian_roadmap),
                ], ';', '"');
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPublikasiKaryaIlmiahCSV(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user');
        $sortOrder = $request->get('sort_order', 'asc');

        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id'); // Tangkap user_id

        // Bangun query
        $query = DB::table('publikasi_karya_ilmiah')
            ->join('users', 'publikasi_karya_ilmiah.user_id', '=', 'users.id')
            ->select(
                'publikasi_karya_ilmiah.judul_penelitian',
                'publikasi_karya_ilmiah.judul_publikasi',
                'publikasi_karya_ilmiah.dosen',
                'publikasi_karya_ilmiah.mahasiswa',
                'publikasi_karya_ilmiah.dipublikasikan',
                'publikasi_karya_ilmiah.penerbit',
                'publikasi_karya_ilmiah.jenis',
                'publikasi_karya_ilmiah.tingkat',
                'publikasi_karya_ilmiah.penyusun',
                'publikasi_karya_ilmiah.status',
                'users.name as nama_user'
            )
            ->where('publikasi_karya_ilmiah.tahun_akademik_id', $tahunTerpilih);

        // Tambahkan filter user jika ada
        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $records = $query->orderBy($sortBy, $sortOrder)->get();

        $filename = 'Publikasi_karya_ilmiah' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $columns = ['No', 'Nama Prodi', 'Judul Penelitian', 'Judul Publikasi', 'Dosen', 'Mahasiswa', 'Di Publikasikan', 'Penerbit', 'Jenis', 'Tingkat', 'Penyusun', 'Status'];

        $callback = function () use ($records, $columns) {
            $handle = fopen('php://output', 'w');
            echo chr(239) . chr(187) . chr(191); // UTF-8 BOM

            fputcsv($handle, $columns, ';', '"');

            foreach ($records as $index => $record) {
                fputcsv($handle, [
                    $index + 1,
                    $record->nama_user,
                    str_replace(["\n", "\r"], ' ', $record->judul_penelitian),
                    str_replace(["\n", "\r"], ' ', $record->judul_publikasi),
                    str_replace(["\n", "\r"], ' ', $record->dosen),
                    str_replace(["\n", "\r"], ' ', $record->mahasiswa),
                    str_replace(["\n", "\r"], ' ', $record->dipublikasikan),
                    str_replace(["\n", "\r"], ' ', $record->penerbit),
                    str_replace(["\n", "\r"], ' ', $record->jenis),
                    str_replace(["\n", "\r"], ' ', $record->tingkat),
                    str_replace(["\n", "\r"], ' ', $record->penyusun),
                    str_replace(["\n", "\r"], ' ', $record->status),
                ], ';', '"');
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportLuaranKaryaIlmiahCSV(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user');
        $sortOrder = $request->get('sort_order', 'asc');

        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id'); // Tangkap user_id

        // Bangun query
        $query = DB::table('luaran_karya_ilmiah')
            ->join('users', 'luaran_karya_ilmiah.user_id', '=', 'users.id')
            ->select(
                'luaran_karya_ilmiah.judul_kegiatan_pkm',
                'luaran_karya_ilmiah.judul_karya',
                'luaran_karya_ilmiah.dosen',
                'luaran_karya_ilmiah.mahasiswa',
                'luaran_karya_ilmiah.penyusun_utama',
                'luaran_karya_ilmiah.jenis',
                'luaran_karya_ilmiah.nomor_karya',
                'luaran_karya_ilmiah.keterangan',
                'users.name as nama_user'
            )
            ->where('luaran_karya_ilmiah.tahun_akademik_id', $tahunTerpilih);

        // Tambahkan filter user jika ada
        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $records = $query->orderBy($sortBy, $sortOrder)->get();

        $filename = 'luaran_karya_ilmiah' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $columns = ['No', 'Nama Prodi', 'Judul Kegiatan PKM', 'Judul Karya', 'Dosen', 'Mahasiswa', 'Penyusun Utama', 'jenis', 'Nomor Karya', 'Keterangan'];

        $callback = function () use ($records, $columns) {
            $handle = fopen('php://output', 'w');
            echo chr(239) . chr(187) . chr(191); // UTF-8 BOM

            fputcsv($handle, $columns, ';', '"');

            foreach ($records as $index => $record) {
                fputcsv($handle, [
                    $index + 1,
                    $record->nama_user,
                    str_replace(["\n", "\r"], ' ', $record->judul_kegiatan_pkm),
                    str_replace(["\n", "\r"], ' ', $record->judul_karya),
                    str_replace(["\n", "\r"], ' ', $record->dosen),
                    str_replace(["\n", "\r"], ' ', $record->mahasiswa),
                    str_replace(["\n", "\r"], ' ', $record->penyusun_utama),
                    str_replace(["\n", "\r"], ' ', $record->jenis),
                    str_replace(["\n", "\r"], ' ', $record->nomor_karya),
                    str_replace(["\n", "\r"], ' ', $record->keterangan),
                ], ';', '"');
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportSitasiLuaranPenelitianDosenCSV(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user');
        $sortOrder = $request->get('sort_order', 'asc');

        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id'); // Tangkap user_id

        // Bangun query
        $query = DB::table('sitasi_luaran_penelitian_dosen')
            ->join('users', 'sitasi_luaran_penelitian_dosen.user_id', '=', 'users.id')
            ->select(
                'sitasi_luaran_penelitian_dosen.nama',
                'sitasi_luaran_penelitian_dosen.judul_artikel',
                'sitasi_luaran_penelitian_dosen.jumlah_sitasi',
                'sitasi_luaran_penelitian_dosen.link_sitasi',
                'users.name as nama_user'
            )
            ->where('sitasi_luaran_penelitian_dosen.tahun_akademik_id', $tahunTerpilih);

        // Tambahkan filter user jika ada
        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $records = $query->orderBy($sortBy, $sortOrder)->get();

        $filename = 'sitasi_luaran_penelitian_dosen' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $columns = ['No', 'Nama Prodi', 'Nama', 'Judul Artikel', 'Jumlah Sitasi', 'Link Sitasi'];

        $callback = function () use ($records, $columns) {
            $handle = fopen('php://output', 'w');
            echo chr(239) . chr(187) . chr(191); // UTF-8 BOM

            fputcsv($handle, $columns, ';', '"');

            foreach ($records as $index => $record) {
                fputcsv($handle, [
                    $index + 1,
                    $record->nama_user,
                    str_replace(["\n", "\r"], ' ', $record->nama),
                    str_replace(["\n", "\r"], ' ', $record->judul_artikel),
                    str_replace(["\n", "\r"], ' ', $record->jumlah_sitasi),
                    str_replace(["\n", "\r"], ' ', $record->link_sitasi),
                ], ';', '"');
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPKMDosenCSV(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user');
        $sortOrder = $request->get('sort_order', 'asc');

        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id'); // Tangkap user_id

        // Bangun query
        $query = DB::table('pkm_dosen')
            ->join('users', 'pkm_dosen.user_id', '=', 'users.id')
            ->select(
                'pkm_dosen.judul_pkm',
                'pkm_dosen.dosen',
                'pkm_dosen.mahasiswa',
                'pkm_dosen.tingkat',
                'pkm_dosen.sumber_dana',
                'pkm_dosen.kesesuaian_roadmap',
                'pkm_dosen.bentuk_integrasi',
                'pkm_dosen.mata_kuliah',
                'users.name as nama_user'
            )
            ->where('pkm_dosen.tahun_akademik_id', $tahunTerpilih);

        // Tambahkan filter user jika ada
        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $records = $query->orderBy($sortBy, $sortOrder)->get();

        $filename = 'pkm_dosen' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $columns = ['No', 'Nama Prodi', 'Judul PKM', 'Nama Dosen', 'Nama Mahasiswa', 'Tingkat', 'Sumber Dana', 'Kesesuaian Roadmap', 'Bentuk Integrasi', 'Mata Kuliah'];

        $callback = function () use ($records, $columns) {
            $handle = fopen('php://output', 'w');
            echo chr(239) . chr(187) . chr(191); // UTF-8 BOM

            fputcsv($handle, $columns, ';', '"');

            foreach ($records as $index => $record) {
                fputcsv($handle, [
                    $index + 1,
                    $record->nama_user,
                    str_replace(["\n", "\r"], ' ', $record->judul_pkm),
                    str_replace(["\n", "\r"], ' ', $record->dosen),
                    str_replace(["\n", "\r"], ' ', $record->mahasiswa),
                    str_replace(["\n", "\r"], ' ', $record->tingkat),
                    str_replace(["\n", "\r"], ' ', $record->sumber_dana),
                    str_replace(["\n", "\r"], ' ', $record->kesesuaian_roadmap),
                    str_replace(["\n", "\r"], ' ', $record->bentuk_integrasi),
                    str_replace(["\n", "\r"], ' ', $record->mata_kuliah),
                ], ';', '"');
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPKMMahasiswaCSV(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user');
        $sortOrder = $request->get('sort_order', 'asc');

        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id'); // Tangkap user_id

        // Bangun query
        $query = DB::table('pkm_mahasiswa')
            ->join('users', 'pkm_mahasiswa.user_id', '=', 'users.id')
            ->select(
                'pkm_mahasiswa.mahasiswa',
                'pkm_mahasiswa.pembimbing',
                'pkm_mahasiswa.judul_pkm',
                'pkm_mahasiswa.tingkat',
                'pkm_mahasiswa.sumber_dana',
                'pkm_mahasiswa.kesesuaian_roadmap',
                'users.name as nama_user'
            )
            ->where('pkm_mahasiswa.tahun_akademik_id', $tahunTerpilih);

        // Tambahkan filter user jika ada
        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $records = $query->orderBy($sortBy, $sortOrder)->get();

        $filename = 'pkm_mahasiswa' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $columns = ['No', 'Nama Prodi', 'Mahasiswa', 'Pembimbing', 'Judul PKM', 'Tingkat', 'Sumber Dana', 'Kesesuaian Roadmap'];

        $callback = function () use ($records, $columns) {
            $handle = fopen('php://output', 'w');
            echo chr(239) . chr(187) . chr(191); // UTF-8 BOM

            fputcsv($handle, $columns, ';', '"');

            foreach ($records as $index => $record) {
                fputcsv($handle, [
                    $index + 1,
                    $record->nama_user,
                    str_replace(["\n", "\r"], ' ', $record->mahasiswa),
                    str_replace(["\n", "\r"], ' ', $record->pembimbing),
                    str_replace(["\n", "\r"], ' ', $record->judul_pkm),
                    str_replace(["\n", "\r"], ' ', $record->tingkat),
                    str_replace(["\n", "\r"], ' ', $record->sumber_dana),
                    str_replace(["\n", "\r"], ' ', $record->kesesuaian_roadmap),
                ], ';', '"');
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPublikasiKaryaIlmiahPKMCSV(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user');
        $sortOrder = $request->get('sort_order', 'asc');

        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id'); // Tangkap user_id

        // Bangun query
        $query = DB::table('publikasi_karya_ilmiah_pkm')
            ->join('users', 'publikasi_karya_ilmiah_pkm.user_id', '=', 'users.id')
            ->select(
                'publikasi_karya_ilmiah_pkm.judul_penelitian',
                'publikasi_karya_ilmiah_pkm.judul_publikasi',
                'publikasi_karya_ilmiah_pkm.dosen',
                'publikasi_karya_ilmiah_pkm.mahasiswa',
                'publikasi_karya_ilmiah_pkm.dipublikasikan',
                'publikasi_karya_ilmiah_pkm.penerbit',
                'publikasi_karya_ilmiah_pkm.jenis',
                'publikasi_karya_ilmiah_pkm.tingkat',
                'publikasi_karya_ilmiah_pkm.penyusun',
                'publikasi_karya_ilmiah_pkm.status',
                'users.name as nama_user'
            )
            ->where('publikasi_karya_ilmiah_pkm.tahun_akademik_id', $tahunTerpilih);

        // Tambahkan filter user jika ada
        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $records = $query->orderBy($sortBy, $sortOrder)->get();

        $filename = 'publikasi_karya_ilmiah_pkm' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $columns = ['No', 'Nama Prodi', 'Judul Penelitian', 'Judul Publikasi', 'Dosen', 'Mahasiswa', 'Di Publikasikan', 'Penerbit', 'jenis', 'tingkat', 'penyusun', 'status'];

        $callback = function () use ($records, $columns) {
            $handle = fopen('php://output', 'w');
            echo chr(239) . chr(187) . chr(191); // UTF-8 BOM

            fputcsv($handle, $columns, ';', '"');

            foreach ($records as $index => $record) {
                fputcsv($handle, [
                    $index + 1,
                    $record->nama_user,
                    str_replace(["\n", "\r"], ' ', $record->judul_penelitian),
                    str_replace(["\n", "\r"], ' ', $record->judul_publikasi),
                    str_replace(["\n", "\r"], ' ', $record->dosen),
                    str_replace(["\n", "\r"], ' ', $record->mahasiswa),
                    str_replace(["\n", "\r"], ' ', $record->dipublikasikan),
                    str_replace(["\n", "\r"], ' ', $record->penerbit),
                    str_replace(["\n", "\r"], ' ', $record->jenis),
                    str_replace(["\n", "\r"], ' ', $record->tingkat),
                    str_replace(["\n", "\r"], ' ', $record->penyusun),
                    str_replace(["\n", "\r"], ' ', $record->status),
                ], ';', '"');
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportLuaranKaryaIlmiahPKMCSV(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user');
        $sortOrder = $request->get('sort_order', 'asc');

        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id'); // Tangkap user_id

        // Bangun query
        $query = DB::table('luaran_karya_ilmiah_pkm')
            ->join('users', 'luaran_karya_ilmiah_pkm.user_id', '=', 'users.id')
            ->select(
                'luaran_karya_ilmiah_pkm.judul_kegiatan_pkm',
                'luaran_karya_ilmiah_pkm.judul_karya',
                'luaran_karya_ilmiah_pkm.dosen',
                'luaran_karya_ilmiah_pkm.mahasiswa',
                'luaran_karya_ilmiah_pkm.penyusun_utama',
                'luaran_karya_ilmiah_pkm.jenis',
                'luaran_karya_ilmiah_pkm.nomor_karya',
                'luaran_karya_ilmiah_pkm.keterangan',
                'users.name as nama_user'
            )
            ->where('luaran_karya_ilmiah_pkm.tahun_akademik_id', $tahunTerpilih);

        // Tambahkan filter user jika ada
        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $records = $query->orderBy($sortBy, $sortOrder)->get();

        $filename = 'luaran_karya_ilmiah_pkm' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $columns = ['No', 'Nama Prodi', 'Judul Kegiatan PKM', 'Judul Karya', 'Dosen', 'Mahasiswa', 'Penyusun Utama', 'jenis', 'Nomor Karya', 'Keterangan'];

        $callback = function () use ($records, $columns) {
            $handle = fopen('php://output', 'w');
            echo chr(239) . chr(187) . chr(191); // UTF-8 BOM

            fputcsv($handle, $columns, ';', '"');

            foreach ($records as $index => $record) {
                fputcsv($handle, [
                    $index + 1,
                    $record->nama_user,
                    str_replace(["\n", "\r"], ' ', $record->judul_kegiatan_pkm),
                    str_replace(["\n", "\r"], ' ', $record->judul_karya),
                    str_replace(["\n", "\r"], ' ', $record->dosen),
                    str_replace(["\n", "\r"], ' ', $record->mahasiswa),
                    str_replace(["\n", "\r"], ' ', $record->penyusun_utama),
                    str_replace(["\n", "\r"], ' ', $record->jenis),
                    str_replace(["\n", "\r"], ' ', $record->nomor_karya),
                    str_replace(["\n", "\r"], ' ', $record->keterangan),
                ], ';', '"');
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

}