<?php

namespace App\Http\Controllers;

use App\Models\BebanKinerjaDosen;
use App\Models\Komentar;
use App\Models\LuaranKaryaIlmiah;
use App\Models\LuaranPkm;
use App\Models\PelaksanaanTa;
use App\Models\PenelitianDosen;
use App\Models\PkmDosen;
use App\Models\ProfilDosen;
use App\Models\PublikasiKaryaIlmiah;
use App\Models\PublikasiPkm;
use App\Models\RekognisiDosen;
use App\Models\RekognisiTenagaKependidikan;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProdiController extends Controller
{
    //Beban Kinerja Dosen
    public function bebankinerjadosen(Request $request)
    {

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        $beban_kinerja_dosen = BebanKinerjaDosen::where('parent_id', Auth::user()->id)
            ->where('beban_kinerja_dosen.tahun_akademik_id', $tahunTerpilih)
            ->get();

        //Komentar
        $tabel = (new BebanKinerjaDosen())->getTable();
        $dosen = User::select('id', 'name')
            ->where('usertype', 'dosen')
            ->where('parent_id', Auth::user()->id)
            ->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('pages.beban_kinerja_dosen', get_defined_vars());
    }

    //Pelaksanaan TA
    public function pelaksanaanta(Request $request)
    {
        if (Auth::user()->id) {
            // Ambil daftar tahun akademik
            $tahunList = TahunAkademik::all();
            $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

            $pelaksanaan_ta = PelaksanaanTa::where('parent_id', Auth::user()->id)
                ->where('pelaksanaan_ta.tahun_akademik_id', $tahunTerpilih)
                ->get();

            $dosen = User::select('id', 'name')
                ->where('usertype', 'dosen')
                ->where('parent_id', Auth::user()->id)
                ->get();

            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            $tabel = (new PelaksanaanTa())->getTable();
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
        return view('pages.pelaksanaan_ta', get_defined_vars());
    }

    //Rekognisi Dosen
    public function rekognisidosen(Request $request)
    {
        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        $rekognisi_dosen = RekognisiDosen::where('parent_id', Auth::user()->id)
            ->where('rekognisi_dosen.tahun_akademik_id', $tahunTerpilih)
            ->get();

        //Komentar
        $tabel = (new RekognisiDosen())->getTable();
        $dosen = User::select('id', 'name')
            ->where('usertype', 'dosen')
            ->where('parent_id', Auth::user()->id)
            ->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('pages.rekognisi_dosen', get_defined_vars());
    }

    public function validasiRekognisi(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', Rule::in(['Diproses', 'Disetujui', 'Ditolak'])],
        ]);

        $rekognisi = RekognisiDosen::where('parent_id', Auth::user()->id)->findOrFail($id);
        $rekognisi->update([
            'status' => $request->status,
            'catatan' => $request->status === 'Ditolak' ? $request->catatan : null,
        ]);

        return redirect()->back()->with('success', 'Status berhasil diperbarui!');
    }

    //Rekognisi Tenaga Kependidikan
    public function rekognisitendik(Request $request)
    {
        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        $rekognisi_tenaga_kependidikan = RekognisiTenagaKependidikan::where('parent_id', Auth::user()->id)
            ->where('rekognisi_tenaga_kependidikan.tahun_akademik_id', $tahunTerpilih)
            ->get();

        //Komentar
        $tabel = (new RekognisiTenagaKependidikan())->getTable();
        $dosen = User::select('id', 'name')
            ->where('usertype', 'dosen')
            ->where('parent_id', Auth::user()->id)
            ->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('pages.rekognisi_tenaga_kependidikan', get_defined_vars());
    }
    public function validasiRekognisiTenagaKependidikan(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', Rule::in(['Diproses', 'Disetujui', 'Ditolak'])],
        ]);

        $rekognisi = RekognisiDosen::where('parent_id', Auth::user()->id)->findOrFail($id);
        $rekognisi->update([
            'status' => $request->status,
            'catatan' => $request->status === 'Ditolak' ? $request->catatan : null,
        ]);

        return redirect()->back()->with('success', 'Status berhasil diperbarui!');
    }

    public function penelitiandosen(Request $request)
    {
        if (Auth::user()->id) {
            // Ambil daftar tahun akademik
            $tahunList = TahunAkademik::all();
            $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

            $penelitian_dosen = PenelitianDosen ::where('parent_id', Auth::user()->id)
                ->where('penelitian_dosen.tahun_akademik_id', $tahunTerpilih)
                ->get();

            $dosen = User::select('id', 'name')
            ->where('usertype', 'dosen')
            ->where('parent_id', Auth::user()->id)
            ->get();
            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            $tabel = (new PenelitianDosen())->getTable();
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
        return view('pages.penelitian_dosen', get_defined_vars());
    }

    public function validasiPenelitianDosen(Request $request, $id)
    {
        $request->validate([
            'kesesuaian_roadmap' => [Rule::in(['Sesuai', 'Kurang Sesuai', 'Tidak Sesuai'])],
        ]);

        $penelitian_dosen = PenelitianDosen::where('parent_id', Auth::user()->id)->findOrFail($id);
        $penelitian_dosen->update([
            'kesesuaian_roadmap' => $request->kesesuaian_roadmap,
        ]);

        return redirect()->back()->with('success', 'Roadmap berhasil diperbarui!');
    }

    public function publikasikaryailmiah(Request $request)
    {
        if (Auth::user()->id) {
            // Ambil daftar tahun akademik
            $tahunList = TahunAkademik::all();
            $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

            $publikasi_karya_ilmiah = PublikasiKaryaIlmiah ::where('parent_id', Auth::user()->id)
                ->where('publikasi_karya_ilmiah.tahun_akademik_id', $tahunTerpilih)
                ->get();

            $dosen = User::select('id', 'name')
            ->where('usertype', 'dosen')
            ->where('parent_id', Auth::user()->id)
            ->get();
            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            $tabel = (new PublikasiKaryaIlmiah())->getTable();
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
        return view('pages.publikasi_karya_ilmiah', get_defined_vars());
    }

    public function luarankaryailmiah(Request $request)
    {
        if (Auth::user()->id) {
            // Ambil daftar tahun akademik
            $tahunList = TahunAkademik::all();
            $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

            $luaran_karya_ilmiah = LuaranKaryaIlmiah ::where('parent_id', Auth::user()->id)
                ->where('luaran_karya_ilmiah.tahun_akademik_id', $tahunTerpilih)
                ->get();

            $dosen = User::select('id', 'name')
            ->where('usertype', 'dosen')
            ->where('parent_id', Auth::user()->id)
            ->get();
            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            $tabel = (new LuaranKaryaIlmiah())->getTable();
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
        return view('pages.luaran_karya_ilmiah', get_defined_vars());
    }

    //PKM Dosen
    
    public function pkmdosen(Request $request)
    {
        if (Auth::user()->id) {
            // Ambil daftar tahun akademik
            $tahunList = TahunAkademik::all();
            $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

            $pkm_dosen = PkmDosen ::where('parent_id', Auth::user()->id)
                ->where('pkm_dosen.tahun_akademik_id', $tahunTerpilih)
                ->get();

            $dosen = User::select('id', 'name')
            ->where('usertype', 'dosen')
            ->where('parent_id', Auth::user()->id)
            ->get();
            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            $tabel = (new PkmDosen())->getTable();
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
        return view('pages.pkm_dosen', get_defined_vars());
    }

    public function validasiPkmDosen(Request $request, $id)
    {
        $request->validate([
            'kesesuaian_roadmap' => [Rule::in(['Sesuai', 'Kurang Sesuai', 'Tidak Sesuai'])],
        ]);

        $pkm_dosen = PkmDosen::where('parent_id', Auth::user()->id)->findOrFail($id);
        $pkm_dosen->update([
            'kesesuaian_roadmap' => $request->kesesuaian_roadmap,
        ]);

        return redirect()->back()->with('success', 'Roadmap berhasil diperbarui!');
    }

    public function luaranpkm(Request $request)
    {
        if (Auth::user()->id) {
            // Ambil daftar tahun akademik
            $tahunList = TahunAkademik::all();
            $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

            $luaran_pkm = LuaranPkm ::where('parent_id', Auth::user()->id)
                ->where('luaran_pkm.tahun_akademik_id', $tahunTerpilih)
                ->get();

            $dosen = User::select('id', 'name')
            ->where('usertype', 'dosen')
            ->where('parent_id', Auth::user()->id)
            ->get();
            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            $tabel = (new LuaranPkm())->getTable();
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
        return view('pages.luaran_pkm', get_defined_vars());
    }
    public function publikasipkm(Request $request)
    {
        if (Auth::user()->id) {
            // Ambil daftar tahun akademik
            $tahunList = TahunAkademik::all();
            $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

            $publikasi_pkm = PublikasiPkm ::where('parent_id', Auth::user()->id)
                ->where('publikasi_pkm.tahun_akademik_id', $tahunTerpilih)
                ->get();

            $dosen = User::select('id', 'name')
            ->where('usertype', 'dosen')
            ->where('parent_id', Auth::user()->id)
            ->get();
            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            $tabel = (new PublikasiPkm())->getTable();
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
        return view('pages.publikasi_pkm', get_defined_vars());
    }
}
