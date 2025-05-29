<?php

namespace App\Http\Controllers;

use App\Models\KinerjaDtps;
use App\Models\Komentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KinerjaDtpsController extends Controller
{
    public function index()
    {
        return view('pages.kinerja_dtps');
    }

    public function show()
    {
        if (Auth::user()->id) {
            $kinerja_dtps = KinerjaDtps::where('user_id', Auth::user()->id)->get();

            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            // dan prodi_id yang sesuai dengan user yang sedang login
            $tabel = (new KinerjaDtps())->getTable(); 
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
        return view('pages.kinerja_dtps', compact('kinerja_dtps', 'komentar'));
    }

    public function add(Request $request)
    {

        KinerjaDtps::create([
            'user_id' => Auth::user()->id,
            'nama_dosen' => $request->nama_dosen,
            'nidn' => $request->nidn,
            'jenis_rekognisi' => $request->jenis_rekognisi,
            'nama_kegiatan' => $request->nama_kegiatan,
            'tingkat' => $request->tingkat,
            'tahun_perolehan' => $request->tahun_perolehan
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {

        $kinerja_dtps = KinerjaDtps::find($id);
        $kinerja_dtps->nama_dosen = $request->nama_dosen;
        $kinerja_dtps->nidn = $request->nidn;
        $kinerja_dtps->jenis_rekognisi = $request->jenis_rekognisi;
        $kinerja_dtps->nama_kegiatan = $request->nama_kegiatan;
        $kinerja_dtps->tingkat = $request->tingkat;
        $kinerja_dtps->tahun_perolehan = $request->tahun_perolehan;
        $kinerja_dtps->user_id = Auth::user()->id;
        $kinerja_dtps->save();

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $kinerja_dtps = KinerjaDtps::find($id);
        $kinerja_dtps->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
