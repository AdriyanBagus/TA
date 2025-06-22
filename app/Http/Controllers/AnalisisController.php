<?php

namespace App\Http\Controllers;
use App\Models\KerjasamaPendidikan;
use App\Models\VisiMisi;
use App\Http\Controllers\Controller;
use App\Models\BebanKinerjaDosen;
use App\Models\EvaluasiPelaksanaan;
use App\Models\Kerjasama;
use App\Models\KetersediaanDokumen;
use App\Models\KinerjaDtps;
use App\Models\Komentar;
use App\Models\LahanPraktek;
use App\Models\LuaranKaryaIlmiah;
use App\Models\PelaksanaanTa;
use App\Models\PenelitianDosen;
use App\Models\PenelitianMahasiswa;
use App\Models\PkmDosen;
use App\Models\PkmMahasiswa;
use App\Models\ProfilDosen;
use App\Models\ProfilDosenTidakTetap;
use App\Models\ProfilTenagaKependidikan;
use App\Models\PublikasiKaryaIlmiah;
use App\Models\PublikasiKaryaIlmiahPkm;
use App\Models\RekognisiTenagaKependidikan;
use App\Models\SitasiLuaranPenelitianDosen;
use App\Models\SitasiLuaranPkmDosen;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalisisController extends Controller
{
    public function visimisi(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        $visimisi = DB::table('visi_misi')
            ->join('users', 'visi_misi.user_id', '=', 'users.id')
            ->select('visi_misi.*', 'users.name as nama_user')
            ->where('visi_misi.tahun_akademik_id', $tahunTerpilih)
            ->orderBy($sortBy, $sortOrder)
            ->get();

        //Komentar
        $tabel = (new VisiMisi())->getTable();
        $prodi = User::select('id', 'name')->where('usertype', '!=', 'admin')->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.visimisi', compact('visimisi', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function kerjasama(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        $kerjasama = DB::table('kerjasama')
            ->join('users', 'kerjasama.user_id', '=', 'users.id')
            ->select('kerjasama.*', 'users.name as nama_user')
            ->orderBy($sortBy, $sortOrder)
            ->get();

        //Komentar
        $tabel = (new Kerjasama())->getTable();
        $prodi = User::select('id', 'name')->where('usertype', '!=', 'admin')->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.kerjasama', compact('kerjasama', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function kerjasama_pendidikan(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        $pendidikan = DB::table('kerjasama_pendidikan')
            ->join('users', 'kerjasama_pendidikan.user_id', '=', 'users.id')
            ->select('kerjasama_pendidikan.*', 'users.name as nama_user')
            ->orderBy($sortBy, $sortOrder)
            ->get();

        return view('admin.analisis.kerjasama.pendidikan', compact('pendidikan', 'sortBy', 'sortOrder'));
    }

    public function kerjasama_penelitian(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        $penelitian = DB::table('kerjasama_penelitian')
            ->join('users', 'kerjasama_penelitian.user_id', '=', 'users.id')
            ->select('kerjasama_penelitian.*', 'users.name as nama_user')
            ->orderBy($sortBy, $sortOrder)
            ->get();

        return view('admin.analisis.kerjasama.penelitian', compact('penelitian', 'sortBy', 'sortOrder'));
    }

    public function kerjasama_pengabdian(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        $pengabdian = DB::table('kerjasama_pengabdian_kepada_masyarakat')
            ->join('users', 'kerjasama_pengabdian_kepada_masyarakat.user_id', '=', 'users.id')
            ->select('kerjasama_pengabdian_kepada_masyarakat.*', 'users.name as nama_user')
            ->orderBy($sortBy, $sortOrder)
            ->get();

        return view('admin.analisis.kerjasama.pengabdian', compact('pengabdian', 'sortBy', 'sortOrder'));
    }

    public function ketersedian_dokumen(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        $ketersediaan_dokumen = DB::table('ketersediaan_dokumen')
            ->join('users', 'ketersediaan_dokumen.user_id', '=', 'users.id')
            ->select('ketersediaan_dokumen.*', 'users.name as nama_user')
            ->orderBy($sortBy, $sortOrder)
            ->get();

        //Komentar
        $tabel = (new KetersediaanDokumen())->getTable();
        $prodi = User::select('id', 'name')->where('usertype', '!=', 'admin')->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.ketersedian_dokumen', compact('ketersediaan_dokumen', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function evaluasi_pelaksanaan(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        $evaluasi_pelaksanaan = DB::table('evaluasi_pelaksanaan')
            ->join('users', 'evaluasi_pelaksanaan.user_id', '=', 'users.id')
            ->select('evaluasi_pelaksanaan.*', 'users.name as nama_user')
            ->orderBy($sortBy, $sortOrder)
            ->get();

        //Komentar
        $tabel = (new EvaluasiPelaksanaan())->getTable();
        $prodi = User::select('id', 'name')->where('usertype', '!=', 'admin')->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();


        return view('admin.analisis.evaluasi_pelaksanaan', compact('evaluasi_pelaksanaan', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function profil_dosen(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        $profil_dosen = DB::table('profil_dosen')
            ->join('users', 'profil_dosen.user_id', '=', 'users.id')
            ->select('profil_dosen.*', 'users.name as nama_user')
            ->orderBy($sortBy, $sortOrder)
            ->get();

        //Komentar
        $tabel = (new ProfilDosen())->getTable();
        $prodi = User::select('id', 'name')->where('usertype', '!=', 'admin')->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.profil_dosen', compact('profil_dosen', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function beban_kinerja_dosen(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        // Query dengan filter tahun akademik
        $beban_kinerja_dosen = DB::table('beban_kinerja_dosen')
            ->join('users', 'beban_kinerja_dosen.user_id', '=', 'users.id')
            ->select('beban_kinerja_dosen.*', 'users.name as nama_user')
            ->where('beban_kinerja_dosen.tahun_akademik_id', $tahunTerpilih)
            ->orderBy($sortBy, $sortOrder)
            ->get();

        // Komentar
        $tabel = (new BebanKinerjaDosen())->getTable();
        $prodi = User::select('id', 'name')->where('usertype', '!=', 'admin')->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.beban_kinerja_dosen', compact(
            'beban_kinerja_dosen',
            'sortBy',
            'sortOrder',
            'tabel',
            'prodi',
            'komentar',
            'tahunList',
            'tahunTerpilih'
        ));
    }


    public function profile_dosen_tidak_tetap(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        $profile_dosen_tidak_tetap = DB::table('profil_dosen_tidak_tetap')
            ->join('users', 'profil_dosen_tidak_tetap.user_id', '=', 'users.id')
            ->select('profil_dosen_tidak_tetap.*', 'users.name as nama_user')
            ->orderBy($sortBy, $sortOrder)
            ->get();

        //Komentar
        $tabel = (new ProfilDosenTidakTetap())->getTable();
        $prodi = User::select('id', 'name')->where('usertype', '!=', 'admin')->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.profile_dosen_tidak_tetap', compact('profile_dosen_tidak_tetap', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function pelaksana_ta(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        $pelaksana_ta = DB::table('pelaksanaan_ta')
            ->join('users', 'pelaksanaan_ta.user_id', '=', 'users.id')
            ->select('pelaksanaan_ta.*', 'users.name as nama_user')
            ->orderBy($sortBy, $sortOrder)
            ->get();

        //Komentar
        $tabel = (new PelaksanaanTa())->getTable();
        $prodi = User::select('id', 'name')->where('usertype', '!=', 'admin')->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.pelaksana_ta', compact('pelaksana_ta', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function lahan_praktek(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        $lahan_praktek = DB::table('lahan_praktek')
            ->join('users', 'lahan_praktek.user_id', '=', 'users.id')
            ->select('lahan_praktek.*', 'users.name as nama_user')
            ->orderBy($sortBy, $sortOrder)
            ->get();

        //Komentar
        $tabel = (new LahanPraktek())->getTable();
        $prodi = User::select('id', 'name')->where('usertype', '!=', 'admin')->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.lahanpraktek', compact('lahan_praktek', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function kinerjaDTPS(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        $kinerjaDTPS = DB::table('kinerja_dtps')
            ->join('users', 'kinerja_dtps.user_id', '=', 'users.id')
            ->select('kinerja_dtps.*', 'users.name as nama_user')
            ->orderBy($sortBy, $sortOrder)
            ->get();

        //Komentar
        $tabel = (new KinerjaDtps())->getTable();
        $prodi = User::select('id', 'name')->where('usertype', '!=', 'admin')->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.kinerja_dtps', compact('kinerjaDTPS', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function tenaga_kependidikan(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        $tenaga_kependidikan = DB::table('profil_tenaga_kependidikan')
            ->join('users', 'profil_tenaga_kependidikan.user_id', '=', 'users.id')
            ->select('profil_tenaga_kependidikan.*', 'users.name as nama_user')
            ->orderBy($sortBy, $sortOrder)
            ->get();

        //Komentar
        $tabel = (new ProfilTenagaKependidikan())->getTable();
        $prodi = User::select('id', 'name')->where('usertype', '!=', 'admin')->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.tenaga_kependidikan', compact('tenaga_kependidikan', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function rekognisi_tenaga_kependidikan(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        $rekognisi_tenaga_kependidikan = DB::table('rekognisi_tenaga_kependidikan')
            ->join('users', 'rekognisi_tenaga_kependidikan.user_id', '=', 'users.id')
            ->select('rekognisi_tenaga_kependidikan.*', 'users.name as nama_user')
            ->orderBy($sortBy, $sortOrder)
            ->get();

        //Komentar
        $tabel = (new RekognisiTenagaKependidikan())->getTable();
        $prodi = User::select('id', 'name')->where('usertype', '!=', 'admin')->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.rekognisi_tenaga_kependidikan', compact('rekognisi_tenaga_kependidikan', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function penelitian_dosen(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        $penelitian_dosen = DB::table('penelitian_dosen')
            ->join('users', 'penelitian_dosen.user_id', '=', 'users.id')
            ->select('penelitian_dosen.*', 'users.name as nama_user')
            ->orderBy($sortBy, $sortOrder)
            ->get();

        //Komentar
        $tabel = (new PenelitianDosen())->getTable();
        $prodi = User::select('id', 'name')->where('usertype', '!=', 'admin')->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.penelitian_dosen', compact('penelitian_dosen', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function penelitian_mahasiswa(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        $penelitian_mahasiswa = DB::table('penelitian_mahasiswa')
            ->join('users', 'penelitian_mahasiswa.user_id', '=', 'users.id')
            ->select('penelitian_mahasiswa.*', 'users.name as nama_user')
            ->orderBy($sortBy, $sortOrder)
            ->get();

        //Komentar
        $tabel = (new PenelitianMahasiswa())->getTable();
        $prodi = User::select('id', 'name')->where('usertype', '!=', 'admin')->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.penelitian_mahasiswa', compact('penelitian_mahasiswa', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function publikasi_karya_ilmiah(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        $publikasi_karya_ilmiah = DB::table('publikasi_karya_ilmiah')
            ->join('users', 'publikasi_karya_ilmiah.user_id', '=', 'users.id')
            ->select('publikasi_karya_ilmiah.*', 'users.name as nama_user')
            ->orderBy($sortBy, $sortOrder)
            ->get();

        //Komentar
        $tabel = (new PublikasiKaryaIlmiah())->getTable();
        $prodi = User::select('id', 'name')->where('usertype', '!=', 'admin')->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.publikasi_karya_ilmiah', compact('publikasi_karya_ilmiah', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function luaran_karya_ilmiah(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        $luaran_karya_ilmiah = DB::table('luaran_karya_ilmiah')
            ->join('users', 'luaran_karya_ilmiah.user_id', '=', 'users.id')
            ->select('luaran_karya_ilmiah.*', 'users.name as nama_user')
            ->orderBy($sortBy, $sortOrder)
            ->get();

        //Komentar
        $tabel = (new LuaranKaryaIlmiah())->getTable();
        $prodi = User::select('id', 'name')->where('usertype', '!=', 'admin')->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.luaran_karya_ilmiah', compact('luaran_karya_ilmiah', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function sitasi_luaran_pd(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        $sitasi_luaran_pd = DB::table('sitasi_luaran_penelitian_dosen')
            ->join('users', 'sitasi_luaran_penelitian_dosen.user_id', '=', 'users.id')
            ->select('sitasi_luaran_penelitian_dosen.*', 'users.name as nama_user')
            ->orderBy($sortBy, $sortOrder)
            ->get();

        //Komentar
        $tabel = (new SitasiLuaranPenelitianDosen())->getTable();
        $prodi = User::select('id', 'name')->where('usertype', '!=', 'admin')->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.luaranPd', compact('sitasi_luaran_pd', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function pkm_dosen(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        $pkm_dosen = DB::table('pkm_dosen')
            ->join('users', 'pkm_dosen.user_id', '=', 'users.id')
            ->select('pkm_dosen.*', 'users.name as nama_user')
            ->orderBy($sortBy, $sortOrder)
            ->get();

        //Komentar
        $tabel = (new PkmDosen())->getTable();
        $prodi = User::select('id', 'name')->where('usertype', '!=', 'admin')->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.pkm_dosen', compact('pkm_dosen', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function pkm_mahasiswa(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        $pkm_mahasiswa = DB::table('pkm_mahasiswa')
            ->join('users', 'pkm_mahasiswa.user_id', '=', 'users.id')
            ->select('pkm_mahasiswa.*', 'users.name as nama_user')
            ->orderBy($sortBy, $sortOrder)
            ->get();

        //Komentar
        $tabel = (new PkmMahasiswa())->getTable();
        $prodi = User::select('id', 'name')->where('usertype', '!=', 'admin')->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.pkm_mahasiswa', compact('pkm_mahasiswa', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

/*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Halaman analisis publikasi karya ilmiah pkm.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
/*******  8f8c4820-b4f7-4415-a181-13ceedb8ed54  *******/    public function publikasi_ki_pkm(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        $publikasi_ki_pkm = DB::table('publikasi_karya_ilmiah_pkm')
            ->join('users', 'publikasi_karya_ilmiah_pkm.user_id', '=', 'users.id')
            ->select('publikasi_karya_ilmiah_pkm.*', 'users.name as nama_user')
            ->orderBy($sortBy, $sortOrder)
            ->get();

        //Komentar
        $tabel = (new PublikasiKaryaIlmiahPkm())->getTable();
        $prodi = User::select('id', 'name')->where('usertype', '!=', 'admin')->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.publikasi_ki_pkm', compact('publikasi_ki_pkm', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function luaran_ki_pkm(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        $luaran_ki_pkm = DB::table('luaran_karya_ilmiah_pkm')
            ->join('users', 'luaran_karya_ilmiah_pkm.user_id', '=', 'users.id')
            ->select('luaran_karya_ilmiah_pkm.*', 'users.name as nama_user')
            ->orderBy($sortBy, $sortOrder)
            ->get();

        //Komentar
        $tabel = (new PublikasiKaryaIlmiahPkm())->getTable();
        $prodi = User::select('id', 'name')->where('usertype', '!=', 'admin')->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.luaran_ki_pkm', compact('luaran_ki_pkm', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih'));
    }

    public function sitasi_luaran_pkm_dosen(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        $sitasi_luaran_pkm_dosen = DB::table('sitasi_luaran_pkm_dosen')
            ->join('users', 'sitasi_luaran_pkm_dosen.user_id', '=', 'users.id')
            ->select('sitasi_luaran_pkm_dosen.*', 'users.name as nama_user')
            ->orderBy($sortBy, $sortOrder)
            ->get();

        //Komentar
        $tabel = (new SitasiLuaranPkmDosen())->getTable();
        $prodi = User::select('id', 'name')->where('usertype', '!=', 'admin')->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.sitasi_luaran_pkm_dosen', compact('sitasi_luaran_pkm_dosen', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih'));
    }
}
