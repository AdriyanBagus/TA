<?php

namespace App\Http\Controllers;

use App\Models\BebanKinerjaDosen;
use App\Models\Komentar;
use App\Models\ProfilDosen;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BebanKinerjaDosenController extends Controller
{
    public function index()
    {
        return view('dosen.beban_kinerja_dosen');
    }

    public function show(Request $request)
    {
        if (Auth::user()->id) {
            // Ambil daftar tahun akademik
            $tahunList = TahunAkademik::all();
            $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

            $beban_kinerja_dosen = BebanKinerjaDosen::where('user_id', Auth::user()->id)
                ->where('beban_kinerja_dosen.tahun_akademik_id', $tahunTerpilih)
                ->get();

            // Cek apakah sudah ada data
            $sudahAdaData = BebanKinerjaDosen::where('user_id', Auth::user()->id)
                ->where('beban_kinerja_dosen.tahun_akademik_id', $tahunTerpilih)
                ->exists();

            $tabel = (new BebanKinerjaDosen())->getTable();
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
        return view('dosen.beban_kinerja_dosen', get_defined_vars());
    }

    public function add(Request $request)
    {
        $numericFields = [
            'ps_sendiri',
            'ps_lain',
            'ps_diluar_pt',
            'pengajaran',
            'penelitian',
            'pkm',
            'penunjang',
            'jumlah_sks',
            'rata_rata_sks'
        ];
        foreach ($numericFields as $field) {
            $value = $request->input($field);

            // Ganti koma jadi titik
            $value = str_replace(',', '.', $value);

            // Kosong => null
            $request[$field] = $value === '' ? null : $value;
        }

        $tahunAktif = TahunAkademik::where('is_active', true)->first();

        //Rumus untuk Beban Kinerja Dosen
        $jumlah_sks = $request->ps_sendiri + $request->ps_lain + $request->ps_diluar_pt + $request->penelitian + $request->pkm + $request->penunjang;
        $rata_rata_sks = $jumlah_sks / 2;

        BebanKinerjaDosen::create([
            'user_id' => Auth::user()->id,
            'tahun_akademik_id' => $tahunAktif->id,
            'nama' => ProfilDosen::where('user_id', Auth::user()->id)->value('nama'),
            'nidn' => ProfilDosen::where('user_id', Auth::user()->id)->value('nidn'),
            'ps_sendiri' => $request->ps_sendiri,
            'ps_lain' => $request->ps_lain,
            'ps_diluar_pt' => $request->ps_diluar_pt,
            'penelitian' => $request->penelitian,
            'pkm' => $request->pkm,
            'penunjang' => $request->penunjang,
            'jumlah_sks' => $jumlah_sks,
            'rata_rata_sks' => $rata_rata_sks,
            'parent_id' => Auth::user()->parent_id
        ]);

        return redirect()->back()->with('success', 'Data Evaluasi Pelaksanaan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $tahunAktif = TahunAkademik::where('is_active', true)->first();

        //Rumus untuk Beban Kinerja Dosen
        $jumlah_sks = $request->ps_sendiri + $request->ps_lain + $request->ps_diluar_pt + $request->penelitian + $request->pkm + $request->penunjang;
        $rata_rata_sks = $jumlah_sks / 2;

        $beban_kinerja_dosen = BebanKinerjaDosen::find($id);
        $beban_kinerja_dosen->user_id = Auth::user()->id;
        $beban_kinerja_dosen->tahun_akademik_id = $tahunAktif->id;
        $beban_kinerja_dosen->nama = $request->nama;
        $beban_kinerja_dosen->nidn = $request->nidn;
        $beban_kinerja_dosen->ps_sendiri = $request->ps_sendiri;
        $beban_kinerja_dosen->ps_lain = $request->ps_lain;
        $beban_kinerja_dosen->ps_diluar_pt = $request->ps_diluar_pt;
        $beban_kinerja_dosen->penelitian = $request->penelitian;
        $beban_kinerja_dosen->pkm = $request->pkm;
        $beban_kinerja_dosen->penunjang = $request->penunjang;
        $beban_kinerja_dosen->jumlah_sks = $jumlah_sks;
        $beban_kinerja_dosen->rata_rata_sks = $rata_rata_sks;
        $beban_kinerja_dosen->user_id = Auth::user()->id;
        $beban_kinerja_dosen->save();

        return redirect()->back()->with('success', 'Data Profil Dosen berhasil diubah!');
    }

    public function destroy($id)
    {
        $beban_kinerja_dosen = BebanKinerjaDosen::find($id);
        $beban_kinerja_dosen->delete();

        return redirect()->back()->with('success', 'Data Profil Dosen berhasil dihapus!');
    }

    public function exportCsv()
    {
        $records = BebanKinerjaDosen::where('user_id', Auth::user()->id)
            ->where('tahun_akademik_id', TahunAkademik::where('is_active', true)->value('id'))
            ->get();

        $filename = 'Beban Kinerja Dosen_' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'No',
            'Nama',
            'NIDN',
            'PS Sendiri',
            'PS Lain',
            'PS Diluar PT',
            'Penelitian',
            'PKM',
            'Penunjang',
            'Jumlah SKS',
            'Rata-Rata SKS'
        ];

        $callback = function () use ($records, $columns) {
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
                    $record->ps_sendiri,
                    $record->ps_lain,
                    $record->ps_diluar_pt,
                    $record->penelitian,
                    $record->pkm,
                    $record->penunjang,
                    $record->jumlah_sks,
                    $record->rata_rata_sks
                ], ';', '"');
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
