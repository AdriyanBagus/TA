<?php

namespace App\Http\Controllers;
use App\Models\BimbinganTaDosen;
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
use App\Models\PublikasiPkm;
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
        $sortBy = $request->get('sort_by', 'nama_user');
        $sortOrder = $request->get('sort_order', 'asc');

        // Ambil semua tahun akademik dan tahun yang dipilih
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        // Ambil nama user yang difilter (jika ada)
        $userTerpilih = $request->get('user_id');

        // Query utama dengan filter tahun dan optional filter user
        $query = DB::table('visi_misi')
            ->join('users', 'visi_misi.user_id', '=', 'users.id')
            ->select('visi_misi.*', 'users.name as nama_user')
            ->where('visi_misi.tahun_akademik_id', $tahunTerpilih);

        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $visimisi = $query->orderBy($sortBy, $sortOrder)->get();

        // Komentar
        $tabel = (new VisiMisi())->getTable();
        $prodi = User::select('id', 'name')
            ->whereNotIn('usertype', ['admin', 'dosen'])
            ->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.visimisi', compact(
            'visimisi',
            'sortBy',
            'sortOrder',
            'tabel',
            'prodi',
            'komentar',
            'tahunList',
            'tahunTerpilih',
            'userTerpilih'
        ));
    }

    public function kerjasama(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user');
        $sortOrder = $request->get('sort_order', 'asc');

        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id');

        $query = DB::table('kerjasama')
            ->join('users', 'kerjasama.user_id', '=', 'users.id')
            ->select('kerjasama.*', 'users.name as nama_user')
            ->where('kerjasama.tahun_akademik_id', $tahunTerpilih);

        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $kerjasama = $query->orderBy($sortBy, $sortOrder)->get();

        $tabel = (new Kerjasama())->getTable();
        $prodi = User::select('id', 'name')
            ->whereNotIn('usertype', ['admin', 'dosen'])
            ->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.kerjasama', compact('kerjasama', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih', 'userTerpilih'));
    }

    public function ketersedian_dokumen(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user');
        $sortOrder = $request->get('sort_order', 'asc');

        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id');

        $query = DB::table('ketersediaan_dokumen')
            ->join('users', 'ketersediaan_dokumen.user_id', '=', 'users.id')
            ->select('ketersediaan_dokumen.*', 'users.name as nama_user')
            ->where('ketersediaan_dokumen.tahun_akademik_id', $tahunTerpilih);

        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $ketersediaan_dokumen = $query->orderBy($sortBy, $sortOrder)->get();

        $tabel = (new KetersediaanDokumen())->getTable();
        $prodi = User::select('id', 'name')
            ->whereNotIn('usertype', ['admin', 'dosen'])
            ->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.ketersedian_dokumen', compact('ketersediaan_dokumen', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih', 'userTerpilih'));
    }

    public function evaluasi_pelaksanaan(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user');
        $sortOrder = $request->get('sort_order', 'asc');

        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id');

        $query = DB::table('evaluasi_pelaksanaan')
            ->join('users', 'evaluasi_pelaksanaan.user_id', '=', 'users.id')
            ->select('evaluasi_pelaksanaan.*', 'users.name as nama_user')
            ->where('evaluasi_pelaksanaan.tahun_akademik_id', $tahunTerpilih);

        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $evaluasi_pelaksanaan = $query->orderBy($sortBy, $sortOrder)->get();

        $tabel = (new EvaluasiPelaksanaan())->getTable();
        $prodi = User::select('id', 'name')
            ->whereNotIn('usertype', ['admin', 'dosen'])
            ->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.evaluasi_pelaksanaan', compact('evaluasi_pelaksanaan', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih', 'userTerpilih'));
    }

    public function profil_dosen(Request $request)
    {
        $sortBy = $request->get('sort_by', 'users.name');
        $sortOrder = $request->get('sort_order', 'asc');

        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        // Ambil prodi yg dipilih
        $prodiTerpilih = $request->get('prodi_id');

        $query = DB::table('users')
            ->leftJoin('users as parent', 'users.parent_id', '=', 'parent.id')
            ->where('users.usertype', 'dosen')
            ->select(
                'users.id',
                'users.name',
                'users.nidn',
                'users.kualifikasi_pendidikan',
                'users.sertifikasi_pendidik_profesional',
                'users.bidang_keahlian',
                'users.bidang_ilmu_prodi',
                'users.jenis_dosen',
                'users.status_dosen',
                'users.parent_id',
                'parent.name as nama_parent'
            );

        // Filter berdasarkan prodi
        if ($prodiTerpilih) {
            $query->where('users.parent_id', $prodiTerpilih);
        }

        $profil_dosen = $query->orderBy($sortBy, $sortOrder)->get();

        $tabel = 'users';
        $prodi = User::select('id', 'name')
            ->where('usertype', 'user') // hanya ambil prodi
            ->get();

        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.profil_dosen', compact(
            'profil_dosen',
            'sortBy',
            'sortOrder',
            'tabel',
            'prodi',
            'komentar',
            'tahunList',
            'tahunTerpilih',
            'prodiTerpilih'
        ));
    }


    public function beban_kinerja_dosen(Request $request)
    {
        $sortBy = $request->get('sort_by', 'dosen.name');
        $sortOrder = $request->get('sort_order', 'asc');

        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $prodiTerpilih = $request->get('prodi_id');

        $query = DB::table('beban_kinerja_dosen')
            ->join('users as dosen', 'beban_kinerja_dosen.user_id', '=', 'dosen.id')
            ->leftJoin('users as prodi', 'beban_kinerja_dosen.parent_id', '=', 'prodi.id')
            ->select(
                'beban_kinerja_dosen.*',
                'dosen.name as nama_dosen',
                'dosen.nidn as nidn_dosen',
                'prodi.name as nama_prodi'
            )
            ->where('beban_kinerja_dosen.tahun_akademik_id', $tahunTerpilih);

        if ($prodiTerpilih) {
            $query->where('beban_kinerja_dosen.parent_id', $prodiTerpilih);
        }

        $beban_kinerja_dosen = $query->orderBy($sortBy, $sortOrder)->get();

        $tabel = (new BebanKinerjaDosen())->getTable();
        $prodi = User::select('id', 'name')->where('usertype', 'user')->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.beban_kinerja_dosen', compact(
            'beban_kinerja_dosen',
            'sortBy',
            'sortOrder',
            'tabel',
            'prodi',
            'komentar',
            'tahunList',
            'tahunTerpilih',
            'prodiTerpilih'
        ));
    }

    public function profile_dosen_tidak_tetap(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id');

        // Query dengan filter tahun akademik
        $query = DB::table('profil_dosen_tidak_tetap')
            ->join('users', 'profil_dosen_tidak_tetap.user_id', '=', 'users.id')
            ->select('profil_dosen_tidak_tetap.*', 'users.name as nama_user')
            ->where('profil_dosen_tidak_tetap.tahun_akademik_id', $tahunTerpilih);

        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $profile_dosen_tidak_tetap = $query->orderBy($sortBy, $sortOrder)->get();

        //Komentar
        $tabel = (new ProfilDosenTidakTetap())->getTable();
        $prodi = User::select('id', 'name')->where('usertype', '!=', 'admin')->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.profile_dosen_tidak_tetap', compact('profile_dosen_tidak_tetap', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih', 'userTerpilih'));
    }

    public function pelaksana_ta(Request $request)
    {
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');

        // Ambil semua dosen
        $semuaDosen = User::where('usertype', 'dosen')->get();

        // Ambil semua bimbingan untuk tahun akademik terpilih
        $semuaBimbingan = BimbinganTaDosen::where('tahun_akademik_id', $tahunTerpilih)->get();

        $pelaksanaan_ta = [];

        foreach ($semuaDosen as $dosen) {
            $bimbinganDosen = $semuaBimbingan->where('user_id', $dosen->id);

            // Filter berdasarkan prodi mahasiswa
            $psSendiri = $bimbinganDosen->where('prodi_mahasiswa', $dosen->bidang_ilmu_prodi);
            $psLain = $bimbinganDosen->where('prodi_mahasiswa', '!=', $dosen->bidang_ilmu_prodi);

            $pelaksanaan_ta[] = (object) [
                'nama' => $dosen->name,
                'nidn' => $dosen->nidn,
                'rata_rata_jumlah_bimbingan_ps_sendiri' => $psSendiri->unique('nama_mahasiswa')->count(),
                'rata_rata_jumlah_bimbingan_ps_lain' => $psLain->unique('nama_mahasiswa')->count(),
                'rata_rata_jumlah_bimbingan_seluruh_ps' => $bimbinganDosen->unique('nama_mahasiswa')->count(),
            ];
        }

        $tabel = (new BimbinganTaDosen())->getTable();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.pelaksana_ta', compact(
            'pelaksanaan_ta',
            'tahunList',
            'tahunTerpilih',
            'tabel',
            'komentar'
        ));

        // return view('admin.analisis.pelaksana_ta', compact('pelaksana_ta', 'tahunList', 'tahunTerpilih'));
    }


    public function lahan_praktek(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id');

        // Query dengan filter tahun akademik
        $query = DB::table('lahan_praktek')
            ->join('users', 'lahan_praktek.user_id', '=', 'users.id')
            ->select('lahan_praktek.*', 'users.name as nama_user')
            ->where('lahan_praktek.tahun_akademik_id', $tahunTerpilih);

        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $lahan_praktek = $query->orderBy($sortBy, $sortOrder)->get();

        //Komentar
        $tabel = (new LahanPraktek())->getTable();
        $prodi = User::select('id', 'name')
            ->where('usertype', 'user') // hanya ambil prodi
            ->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.lahanpraktek', compact('lahan_praktek', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih', 'userTerpilih'));
    }

    public function kinerjaDTPS(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id');

        // Query dengan filter tahun akademik
        $query = DB::table('kinerja_dtps')
            ->join('users', 'kinerja_dtps.user_id', '=', 'users.id')
            ->select('kinerja_dtps.*', 'users.name as nama_user')
            ->where('kinerja_dtps.tahun_akademik_id', $tahunTerpilih);

        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $kinerjaDTPS = $query->orderBy($sortBy, $sortOrder)->get();

        //Komentar
        $tabel = (new KinerjaDtps())->getTable();
        $prodi = User::select('id', 'name')->where('usertype', '!=', 'admin')->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.kinerja_dtps', compact('kinerjaDTPS', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih', 'userTerpilih'));
    }

    public function tenaga_kependidikan(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id');

        // Query dengan filter tahun akademik
        $query = DB::table('profil_tenaga_kependidikan')
            ->join('users', 'profil_tenaga_kependidikan.user_id', '=', 'users.id')
            ->select('profil_tenaga_kependidikan.*', 'users.name as nama_user')
            ->where('profil_tenaga_kependidikan.tahun_akademik_id', $tahunTerpilih);

        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $tenaga_kependidikan = $query->orderBy($sortBy, $sortOrder)->get();

        //Komentar
        $tabel = (new ProfilTenagaKependidikan())->getTable();
        $prodi = User::select('id', 'name')->where('usertype', '!=', 'admin')->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.tenaga_kependidikan', compact('tenaga_kependidikan', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih', 'userTerpilih'));
    }

    public function rekognisi_tenaga_kependidikan(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id');

        // Query dengan filter tahun akademik
        $query = DB::table('rekognisi_tenaga_kependidikan')
            ->join('users', 'rekognisi_tenaga_kependidikan.user_id', '=', 'users.id')
            ->select('rekognisi_tenaga_kependidikan.*', 'users.name as nama_user')
            ->where('rekognisi_tenaga_kependidikan.tahun_akademik_id', $tahunTerpilih);

        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $rekognisi_tenaga_kependidikan = $query->orderBy($sortBy, $sortOrder)->get();

        //Komentar
        $tabel = (new RekognisiTenagaKependidikan())->getTable();
        $prodi = User::select('id', 'name')
            ->where('usertype', 'user') // hanya ambil prodi
            ->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.rekognisi_tenaga_kependidikan', compact('rekognisi_tenaga_kependidikan', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih', 'userTerpilih'));
    }

    public function penelitian_dosen(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id');

        // Query dengan filter tahun akademik
        $query = DB::table('penelitian_dosen')
            ->join('users', 'penelitian_dosen.user_id', '=', 'users.id')
            ->select('penelitian_dosen.*', 'users.name as nama_user')
            ->where('penelitian_dosen.tahun_akademik_id', $tahunTerpilih);

        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $penelitian_dosen = $query->orderBy($sortBy, $sortOrder)->get();

        //Komentar
        $tabel = (new PenelitianDosen())->getTable();
        $prodi = User::select('id', 'name')
            ->where('usertype', 'user') // hanya ambil prodi
            ->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.penelitian_dosen', compact('penelitian_dosen', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih', 'userTerpilih'));
    }

    public function penelitian_mahasiswa(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id');

        // Query dengan filter tahun akademik
        $query = DB::table('penelitian_mahasiswa')
            ->join('users', 'penelitian_mahasiswa.user_id', '=', 'users.id')
            ->select('penelitian_mahasiswa.*', 'users.name as nama_user')
            ->where('penelitian_mahasiswa.tahun_akademik_id', $tahunTerpilih);

        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $penelitian_mahasiswa = $query->orderBy($sortBy, $sortOrder)->get();

        //Komentar
        $tabel = (new PenelitianMahasiswa())->getTable();
        $prodi = User::select('id', 'name')
            ->where('usertype', 'user') // hanya ambil prodi
            ->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.penelitian_mahasiswa', compact('penelitian_mahasiswa', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih', 'userTerpilih'));
    }

    public function publikasi_karya_ilmiah(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id');

        // Query dengan filter tahun akademik
        $query = DB::table('publikasi_karya_ilmiah')
            ->join('users', 'publikasi_karya_ilmiah.user_id', '=', 'users.id')
            ->select('publikasi_karya_ilmiah.*', 'users.name as nama_user')
            ->where('publikasi_karya_ilmiah.tahun_akademik_id', $tahunTerpilih);

        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $publikasi_karya_ilmiah = $query->orderBy($sortBy, $sortOrder)->get();

        //Komentar
        $tabel = (new PublikasiKaryaIlmiah())->getTable();
        $prodi = User::select('id', 'name')
            ->where('usertype', 'user') // hanya ambil prodi
            ->get();
        ;
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.publikasi_karya_ilmiah', compact('publikasi_karya_ilmiah', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih', 'userTerpilih'));
    }

    public function luaran_karya_ilmiah(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id');

        // Query dengan filter tahun akademik
        $query = DB::table('luaran_karya_ilmiah')
            ->join('users', 'luaran_karya_ilmiah.user_id', '=', 'users.id')
            ->select('luaran_karya_ilmiah.*', 'users.name as nama_user')
            ->where('luaran_karya_ilmiah.tahun_akademik_id', $tahunTerpilih)
            ->where('users.usertype', 'user'); // hanya ambil prodi


        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $luaran_karya_ilmiah = $query->orderBy($sortBy, $sortOrder)->get();

        //Komentar
        $tabel = (new LuaranKaryaIlmiah())->getTable();
        $prodi = User::select('id', 'name')
            ->where('usertype', 'user') // hanya ambil prodi
            ->get();
        ;
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.luaran_karya_ilmiah', compact('luaran_karya_ilmiah', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih', 'userTerpilih'));
    }

    public function sitasi_luaran_pd(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id');

        // Query dengan filter tahun akademik
        $query = DB::table('sitasi_luaran_penelitian_dosen')
            ->join('users', 'sitasi_luaran_penelitian_dosen.user_id', '=', 'users.id')
            ->select('sitasi_luaran_penelitian_dosen.*', 'users.name as nama_user')
            ->where('sitasi_luaran_penelitian_dosen.tahun_akademik_id', $tahunTerpilih);

        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $sitasi_luaran_pd = $query->orderBy($sortBy, $sortOrder)->get();

        //Komentar
        $tabel = (new SitasiLuaranPenelitianDosen())->getTable();
        $prodi = User::select('id', 'name')
            ->where('usertype', 'user') // hanya ambil prodi
            ->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.luaranPd', compact('sitasi_luaran_pd', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih', 'userTerpilih'));
    }

    public function pkm_dosen(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id');

        // Query dengan filter tahun akademik
        $query = DB::table('pkm_dosen')
            ->join('users', 'pkm_dosen.parent_id', '=', 'users.id')
            ->select('pkm_dosen.*', 'users.name as nama_user')
            ->where('pkm_dosen.tahun_akademik_id', $tahunTerpilih);

        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $pkm_dosen = $query->orderBy($sortBy, $sortOrder)->get();

        //Komentar
        $tabel = (new PkmDosen())->getTable();
        $prodi = User::select('id', 'name')
            ->where('usertype', 'user') // hanya ambil prodi
            ->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.pkm_dosen', compact('pkm_dosen', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih', 'userTerpilih'));
    }

    public function pkm_mahasiswa(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id');

        // Query dengan filter tahun akademik
        $query = DB::table('pkm_mahasiswa')
            ->join('users', 'pkm_mahasiswa.user_id', '=', 'users.id')
            ->select('pkm_mahasiswa.*', 'users.name as nama_user')
            ->where('pkm_mahasiswa.tahun_akademik_id', $tahunTerpilih);

        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $pkm_mahasiswa = $query->orderBy($sortBy, $sortOrder)->get();

        //Komentar
        $tabel = (new PkmMahasiswa())->getTable();
        $prodi = User::select('id', 'name')
            ->where('usertype', 'user') // hanya ambil prodi
            ->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.pkm_mahasiswa', compact('pkm_mahasiswa', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih', 'userTerpilih'));
    }

    public function publikasi_pkm(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id');

        // Query dengan filter tahun akademik
        $query = DB::table('publikasi_pkm')
            ->join('users', 'publikasi_pkm.user_id', '=', 'users.id')
            ->select('publikasi_pkm.*', 'users.name as nama_user')
            ->where('publikasi_pkm.tahun_akademik_id', $tahunTerpilih);

        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $publikasi_ki_pkm = $query->orderBy($sortBy, $sortOrder)->get();

        // Decode JSON pada detail_publikasi agar bisa di-loop di Blade
        foreach ($publikasi_ki_pkm as $data) {
            $data->detail_publikasi = json_decode($data->detail_publikasi, true);
        }

        //Komentar
        $tabel = (new PublikasiPkm())->getTable();
        $prodi = User::select('id', 'name')
            ->where('usertype', 'user') // hanya ambil prodi
            ->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.publikasi_ki_pkm', compact('publikasi_ki_pkm', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih', 'userTerpilih'));
    }


    public function sitasi_luaran_pkm_dosen(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_user'); // Default: Sort by nama_user
        $sortOrder = $request->get('sort_order', 'asc'); // Default: Ascending

        // Ambil daftar tahun akademik & tahun yang dipilih (atau default ke aktif)
        $tahunList = TahunAkademik::all();
        $tahunTerpilih = $request->get('tahun') ?? TahunAkademik::where('is_active', true)->value('id');
        $userTerpilih = $request->get('user_id');

        // Query dengan filter tahun akademik
        $query = DB::table('sitasi_luaran_pkm_dosen')
            ->join('users', 'sitasi_luaran_pkm_dosen.user_id', '=', 'users.id')
            ->select('sitasi_luaran_pkm_dosen.*', 'users.name as nama_user')
            ->where('sitasi_luaran_pkm_dosen.tahun_akademik_id', $tahunTerpilih);

        if ($userTerpilih) {
            $query->where('users.id', $userTerpilih);
        }

        $sitasi_luaran_pkm_dosen = $query->orderBy($sortBy, $sortOrder)->get();
        //Komentar
        $tabel = (new SitasiLuaranPkmDosen())->getTable();
        $prodi = User::select('id', 'name')
            ->where('usertype', 'user') // hanya ambil prodi
            ->get();
        $komentar = Komentar::where('nama_tabel', $tabel)->get();

        return view('admin.analisis.sitasi_luaran_pkm_dosen', compact('sitasi_luaran_pkm_dosen', 'sortBy', 'sortOrder', 'tabel', 'prodi', 'komentar', 'tahunList', 'tahunTerpilih', 'userTerpilih'));
    }
}
