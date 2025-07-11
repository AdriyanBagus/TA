<?php

use App\Http\Controllers\AnalisisController;
use App\Http\Controllers\BebanKinerjaDosenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KerjasamaPendidikanController;
use App\Http\Controllers\KerjasamaPenelitianController;
use App\Http\Controllers\KerjasamaPengabdianKepadaMasyarakatController;
use App\Http\Controllers\VisiMisiController;
use App\Http\Controllers\FormSettingController;
use App\Models\KerjasamaPenelitian;
use App\Models\KerjasamaPengabdianKepadaMasyarakat;
use App\Http\Controllers\DiagramController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\EvaluasiPelaksanaanController;
use App\Http\Controllers\KerjasamaController;
use App\Http\Controllers\KetersediaanDokumenController;
use App\Http\Controllers\LahanPraktekController;
use App\Http\Controllers\PelaksanaanTaController;
use App\Http\Controllers\ProfilDosenController;
use App\Http\Controllers\ProfilDosenTidakTetapController;
use App\Http\Controllers\KinerjaDtpsController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\LuaranKaryaIlmiahController;
use App\Http\Controllers\luaranpkmController;
use App\Http\Controllers\PenelitianDosenController;
use App\Http\Controllers\PenelitianMahasiswaController;
use App\Http\Controllers\PengembanganDosenController;
use App\Http\Controllers\PengembanganTenagaKependidikanController;
use App\Http\Controllers\PkmDosenController;
use App\Http\Controllers\PkmMahasiswaController;
use App\Http\Controllers\PrestasiMahasiswaController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ProfilTenagaKependidikanController;
use App\Http\Controllers\PublikasiKaryaIlmiahController;
use App\Http\Controllers\PublikasiPkmController;
use App\Http\Controllers\RekognisiDosenController;
use App\Http\Controllers\RekognisiTenagaKependidikanController;
use App\Http\Controllers\SitasiLuaranPenelitianDosenController;
use App\Http\Controllers\SitasiLuaranPkmDosenController;
use App\Http\Controllers\TahunAkademikController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckFormStatus;
use App\Models\KinerjaDtps;
use App\Models\PublikasiPkm;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [UserController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:user'])
    ->name('dashboard');

Route::middleware(['auth','verified','role:user'])->group(function () {

    //Tambah Dosen
    Route::resource('/tambah-dosen', DosenController::class);

    Route::get('/visimisi', [VisiMisiController::class, 'show'])->middleware([CheckFormStatus::class . ':visi misi'])->name('pages.visi_misi');
    Route::post('/visimisi', [VisiMisiController::class, 'add'])->name('pages.visi_misi.add');
    Route::put('/visimisi/{id}', [VisiMisiController::class, 'update'])->name('pages.visi_misi.update');
    Route::delete('/visimisi/{id}', [VisiMisiController::class, 'destroy'])->name('pages.visi_misi.destroy');
    Route::get('/visimisi/export', [VisiMisiController::class, 'exportCsv'])->name('pages.visi_misi.export');

    Route::get('/kerjasama', [KerjasamaController::class, 'show'])->name('pages.kerjasama.show');
    Route::post('/kerjasama', [KerjasamaController::class, 'add'])->name('pages.kerjasama.add');
    Route::put('/kerjasama/{id}', [KerjasamaController::class, 'update'])->name('pages.kerjasama.update');
    Route::delete('/kerjasama/{id}', [KerjasamaController::class, 'destroy'])->name('pages.kerjasama.destroy');
    Route::get('/kerjasama/export', [KerjasamaController::class, 'exportCsv'])->name('pages.kerjasama.export');

    Route::get('/kerjasamapendidikan', [KerjasamaPendidikanController::class, 'show'])->name('pages.kerjasama_pendidikan');
    Route::post('/kerjasamapendidikan', [KerjasamaPendidikanController::class, 'add'])->name('pages.kerjasama_pendidikan.add');
    Route::put('/kerjasamapendidikan/{id}', [KerjasamaPendidikanController::class, 'update'])->name('pages.kerjasama_pendidikan.update');

    Route::get('/kerjasamapenelitian', [KerjasamaPenelitianController::class, 'show'])->name('pages.kerjasama_penelitian');
    Route::post('/kerjasamapenelitian', [KerjasamaPenelitianController::class, 'add'])->name('pages.kerjasama_penelitian.add');
    Route::put('/kerjasamapenelitian/{id}', [KerjasamaPenelitianController::class, 'update'])->name('pages.kerjasama_penelitian.update');

    Route::get('/kerjasamapengabiankepadamasyarakat', [KerjasamaPengabdianKepadaMasyarakatController::class, 'show'])->name('pages.kerjasama_pengabdian_kepada_masyarakat');
    Route::post('/kerjasamapengabiankepadamasyarakat', [KerjasamaPengabdianKepadaMasyarakatController::class, 'add'])->name('pages.kerjasama_pengabdian_kepada_masyarakat.add');
    Route::put('/kerjasamapengabiankepadamasyarakat/{id}', [KerjasamaPengabdianKepadaMasyarakatController::class, 'update'])->name('pages.kerjasama_pengabdian_kepada_masyarakat.update');

    Route::get('/ketersediaandokumen', [KetersediaanDokumenController::class, 'show'])->name('pages.ketersediaan_dokumen');
    Route::post('/ketersediaandokumen', [KetersediaanDokumenController::class, 'add'])->name('pages.ketersediaan_dokumen.add');
    Route::put('/ketersediaandokumen/{id}', [KetersediaanDokumenController::class, 'update'])->name('pages.ketersediaan_dokumen.update');
    Route::delete('/ketersediaandokumen/{id}', [KetersediaanDokumenController::class, 'destroy'])->name('pages.ketersediaan_dokumen.destroy');
    Route::get('/ketersediaandokumen/export', [KetersediaanDokumenController::class, 'exportCsv'])->name('pages.ketersediaan_dokumen.export');

    Route::get('/profildosen', [ProfilDosenController::class, 'show'])->middleware([CheckFormStatus::class . ':profil dosen'])->name('pages.profil_dosen');
    Route::post('/profildosen', [ProfilDosenController::class, 'add'])->name('pages.profil_dosen.add');
    Route::put('/profildosen/{id}', [ProfilDosenController::class, 'update'])->name('pages.profil_dosen.update');
    Route::delete('/profildosen/{id}', [ProfilDosenController::class, 'destroy'])->name('pages.profil_dosen.destroy');
    Route::get('/profildosen/export', [ProfilDosenController::class, 'exportCsv'])->name('pages.profil_dosen.export');

    Route::get('/evaluasipelaksanaan', [EvaluasiPelaksanaanController::class, 'show'])->name('pages.evaluasi_pelaksanaan');
    Route::post('/evaluasipelaksanaan', [EvaluasiPelaksanaanController::class, 'add'])->name('pages.evaluasi_pelaksanaan.add');
    Route::put('/evaluasipelaksanaan/{id}', [EvaluasiPelaksanaanController::class, 'update'])->name('pages.evaluasi_pelaksanaan.update');
    Route::delete('/evaluasipelaksanaan/{id}', [EvaluasiPelaksanaanController::class, 'destroy'])->name('pages.evaluasi_pelaksanaan.destroy');
    Route::get('/evaluasipelaksanaan/export', [EvaluasiPelaksanaanController::class, 'exportCsv'])->name('pages.evaluasi_pelaksanaan.export');

    Route::get('/bebankinerjadosen', [BebanKinerjaDosenController::class, 'show'])->name('pages.beban_kinerja_dosen');
    Route::post('/bebankinerjadosen', [BebanKinerjaDosenController::class, 'add'])->name('pages.beban_kinerja_dosen.add');
    Route::put('/bebankinerjadosen/{id}', [BebanKinerjaDosenController::class, 'update'])->name('pages.beban_kinerja_dosen.update');
    Route::delete('/bebankinerjadosen/{id}', [BebanKinerjaDosenController::class, 'destroy'])->name('pages.beban_kinerja_dosen.destroy');
    Route::get('/bebankinerjadosen/export', [BebanKinerjaDosenController::class, 'exportCsv'])->name('pages.beban_kinerja_dosen.export');

    Route::get('/profildosentidaktetap', [ProfilDosenTidakTetapController::class, 'show'])->name('pages.profil_dosen_tidak_tetap');
    Route::post('/profildosentidaktetap', [ProfilDosenTidakTetapController::class, 'add'])->name('pages.profil_dosen_tidak_tetap.add');
    Route::put('/profildosentidaktetap/{id}', [ProfilDosenTidakTetapController::class, 'update'])->name('pages.profil_dosen_tidak_tetap.update');
    Route::delete('/profildosentidaktetap/{id}', [ProfilDosenTidakTetapController::class, 'destroy'])->name('pages.profil_dosen_tidak_tetap.destroy');
    Route::get('/profildosentidaktetap/export', [ProfilDosenTidakTetapController::class, 'exportCsv'])->name('pages.profil_dosen_tidak_tetap.export');

    Route::get('/pelaksanaanta', [PelaksanaanTaController::class, 'show'])->name('pages.pelaksanaan_ta');
    Route::post('/pelaksanaanta', [PelaksanaanTaController::class, 'add'])->name('pages.pelaksanaan_ta.add');
    Route::put('/pelaksanaanta/{id}', [PelaksanaanTaController::class, 'update'])->name('pages.pelaksanaan_ta.update');
    Route::delete('/pelaksanaanta/{id}', [PelaksanaanTaController::class, 'destroy'])->name('pages.pelaksanaan_ta.destroy');
    Route::get('/pelaksanaanta/export', [PelaksanaanTaController::class, 'exportCsv'])->name('pages.pelaksanaan_ta.export');

    Route::get('/lahanpraktek', [LahanPraktekController::class, 'show'])->name('pages.lahan_praktek');
    Route::post('/lahanpraktek', [LahanPraktekController::class, 'add'])->name('pages.lahan_praktek.add');
    Route::put('/lahanpraktek/{id}', [LahanPraktekController::class, 'update'])->name('pages.lahan_praktek.update');
    Route::delete('/lahanpraktek/{id}', [LahanPraktekController::class, 'destroy'])->name('pages.lahan_praktek.destroy');
    Route::get('/lahanpraktek/export', [LahanPraktekController::class, 'exportCsv'])->name('pages.lahan_praktek.export');

    Route::get('/rekognisidosen', [RekognisiDosenController::class, 'show'])->name('pages.rekognisi_dosen');
    Route::post('/rekognisidosen', [RekognisiDosenController::class, 'add'])->name('pages.rekognisi_dosen.add');
    Route::put('/rekognisidosen/{id}', [RekognisiDosenController::class, 'update'])->name('pages.rekognisi_dosen.update');
    Route::delete('/rekognisidosen/{id}', [RekognisiDosenController::class, 'destroy'])->name('pages.rekognisi_dosen.destroy');
    Route::get('/rekognisidosen/export', [RekognisiDosenController::class, 'exportCsv'])->name('pages.rekognisi_dosen.export');

    Route::get('/profiltenagakependidikan', [ProfilTenagaKependidikanController::class, 'show'])->name('pages.profil_tenaga_kependidikan');
    Route::post('/profiltenagakependidikan', [ProfilTenagaKependidikanController::class, 'add'])->name('pages.profil_tenaga_kependidikan.add');
    Route::put('/profiltenagakependidikan/{id}', [ProfilTenagaKependidikanController::class, 'update'])->name('pages.profil_tenaga_kependidikan.update');
    Route::delete('/profiltenagakependidikan/{id}', [ProfilTenagaKependidikanController::class, 'destroy'])->name('pages.profil_tenaga_kependidikan.destroy');
    Route::get('/profiltenagakependidikan/export', [ProfilTenagaKependidikanController::class, 'exportCsv'])->name('pages.profil_tenaga_kependidikan.export');

    Route::get('/rekognisitenagakependidikan', [RekognisiTenagaKependidikanController::class, 'show'])->name('pages.rekognisi_tenaga_kependidikan');
    Route::post('/rekognisitenagakependidikan', [RekognisiTenagaKependidikanController::class, 'add'])->name('pages.rekognisi_tenaga_kependidikan.add');
    Route::put('/rekognisitenagakependidikan/{id}', [RekognisiTenagaKependidikanController::class, 'update'])->name('pages.rekognisi_tenaga_kependidikan.update');
    Route::delete('/rekognisitenagakependidikan/{id}', [RekognisiTenagaKependidikanController::class, 'destroy'])->name('pages.rekognisi_tenaga_kependidikan.destroy');
    Route::get('/rekognisitenagakependidikan/export', [RekognisiTenagaKependidikanController::class, 'exportCsv'])->name('pages.rekognisi_tenaga_kependidikan.export');

    Route::get('/penelitiandosen', [PenelitianDosenController::class, 'show'])->name('pages.penelitian_dosen');
    Route::post('/penelitiandosen', [PenelitianDosenController::class, 'add'])->name('pages.penelitian_dosen.add');
    Route::put('/penelitiandosen/{id}', [PenelitianDosenController::class, 'update'])->name('pages.penelitian_dosen.update');
    Route::delete('/penelitiandosen/{id}', [PenelitianDosenController::class, 'destroy'])->name('pages.penelitian_dosen.destroy');
    Route::get('/penelitiandosen/export', [PenelitianDosenController::class, 'exportCsv'])->name('pages.penelitian_dosen.export');

    Route::get('/penelitianmahasiswa', [PenelitianMahasiswaController::class, 'show'])->name('pages.penelitian_mahasiswa');
    Route::post('/penelitianmahasiswa', [PenelitianMahasiswaController::class, 'add'])->name('pages.penelitian_mahasiswa.add');
    Route::put('/penelitianmahasiswa/{id}', [PenelitianMahasiswaController::class, 'update'])->name('pages.penelitian_mahasiswa.update');
    Route::delete('/penelitianmahasiswa/{id}', [PenelitianMahasiswaController::class, 'destroy'])->name('pages.penelitian_mahasiswa.destroy');
    Route::get('/penelitianmahasiswa/export', [PenelitianMahasiswaController::class, 'exportCsv'])->name('pages.penelitian_mahasiswa.export');

    Route::get('/publikasikaryailmiah', [PublikasiKaryaIlmiahController::class, 'show'])->name('pages.publikasi_karya_ilmiah');
    Route::post('/publikasikaryailmiah', [PublikasiKaryaIlmiahController::class, 'add'])->name('pages.publikasi_karya_ilmiah.add');
    Route::put('/publikasikaryailmiah/{id}', [PublikasiKaryaIlmiahController::class, 'update'])->name('pages.publikasi_karya_ilmiah.update');
    Route::delete('/publikasikaryailmiah/{id}', [PublikasiKaryaIlmiahController::class, 'destroy'])->name('pages.publikasi_karya_ilmiah.destroy');
    Route::get('/publikasikaryailmiah/export', [PublikasiKaryaIlmiahController::class, 'exportCsv'])->name('pages.publikasi_karya_ilmiah.export');

    Route::get('/luarankaryailmiah', [LuaranKaryaIlmiahController::class, 'show'])->name('pages.luaran_karya_ilmiah');
    Route::post('/luarankaryailmiah', [LuaranKaryaIlmiahController::class, 'add'])->name('pages.luaran_karya_ilmiah.add');
    Route::put('/luarankaryailmiah/{id}', [LuaranKaryaIlmiahController::class, 'update'])->name('pages.luaran_karya_ilmiah.update');
    Route::delete('/luarankaryailmiah/{id}', [LuaranKaryaIlmiahController::class, 'destroy'])->name('pages.luaran_karya_ilmiah.destroy');
    Route::get('/luarankaryailmiah/export', [LuaranKaryaIlmiahController::class, 'exportCsv'])->name('pages.luaran_karya_ilmiah.export');

    Route::get('/sitasiluaranpenelitiandosen', [SitasiLuaranPenelitianDosenController::class, 'show'])->name('pages.sitasi_luaran_penelitian_dosen');
    Route::post('/sitasiluaranpenelitiandosen', [SitasiLuaranPenelitianDosenController::class, 'add'])->name('pages.sitasi_luaran_penelitian_dosen.add');
    Route::put('/sitasiluaranpenelitiandosen/{id}', [SitasiLuaranPenelitianDosenController::class, 'update'])->name('pages.sitasi_luaran_penelitian_dosen.update');
    Route::delete('/sitasiluaranpenelitiandosen/{id}', [SitasiLuaranPenelitianDosenController::class, 'destroy'])->name('pages.sitasi_luaran_penelitian_dosen.destroy');
    Route::get('/sitasiluaranpenelitiandosen/export', [SitasiLuaranPenelitianDosenController::class, 'exportCsv'])->name('pages.sitasi_luaran_penelitian_dosen.export');

    Route::get('/pkmmahasiswa', [PkmMahasiswaController::class, 'show'])->name('pages.pkm_mahasiswa');
    Route::post('/pkmmahasiswa', [PkmMahasiswaController::class, 'add'])->name('pages.pkm_mahasiswa.add');
    Route::put('/pkmmahasiswa/{id}', [PkmMahasiswaController::class, 'update'])->name('pages.pkm_mahasiswa.update');
    Route::delete('/pkmmahasiswa/{id}', [PkmMahasiswaController::class, 'destroy'])->name('pages.pkm_mahasiswa.destroy');
    Route::get('/pkmmahasiswa/export', [PkmMahasiswaController::class, 'exportCsv'])->name('pages.pkm_mahasiswa.export');

    Route::get('/pkmdosen', [PkmDosenController::class, 'show'])->name('pages.pkm_dosen');
    Route::post('/pkmdosen', [PkmDosenController::class, 'add'])->name('pages.pkm_dosen.add');
    Route::put('/pkmdosen/{id}', [PkmDosenController::class, 'update'])->name('pages.pkm_dosen.update');
    Route::delete('/pkmdosen/{id}', [PkmDosenController::class, 'destroy'])->name('pages.pkm_dosen.destroy');
    Route::get('/pkmdosen/export', [PkmDosenController::class, 'exportCsv'])->name('pages.pkm_dosen.export');

    Route::get('/publikasipkm', [PublikasiPkmController::class, 'show'])->name('pages.publikasi_pkm');
    Route::post('/publikasipkm', [PublikasiPkmController::class, 'add'])->name('pages.publikasi_pkm.add');
    Route::put('/publikasipkm/{id}', [PublikasiPkmController::class, 'update'])->name('pages.publikasi_pkm.update');
    Route::delete('/publikasipkm/{id}', [PublikasiPkmController::class, 'destroy'])->name('pages.publikasi_pkm.destroy');
    Route::get('/publikasipkm/export', [PublikasiPkmController::class, 'exportCsv'])->name('pages.publikasi_pkm.export');

    Route::get('/luaranpkm', [luaranpkmController::class, 'show'])->name('pages.luaran_pkm');
    Route::post('/luaranpkm', [luaranpkmController::class, 'add'])->name('pages.luaran_pkm.add');
    Route::put('/luaranpkm/{id}', [luaranpkmController::class, 'update'])->name('pages.luaran_pkm.update');
    Route::delete('/luaranpkm/{id}', [luaranpkmController::class, 'destroy'])->name('pages.luaran_pkm.destroy');
    Route::get('/luaranpkm/export', [luaranpkmController::class, 'exportCsv'])->name('pages.luaran_pkm.export');

    Route::get('/sitasiluaranpkmdosen', [SitasiLuaranPkmDosenController::class, 'show'])->name('pages.sitasi_luaran_pkm_dosen');
    Route::post('/sitasiluaranpkmdosen', [SitasiLuaranPkmDosenController::class, 'add'])->name('pages.sitasi_luaran_pkm_dosen.add');
    Route::put('/sitasiluaranpkmdosen/{id}', [SitasiLuaranPkmDosenController::class, 'update'])->name('pages.sitasi_luaran_pkm_dosen.update');
    Route::delete('/sitasiluaranpkmdosen/{id}', [SitasiLuaranPkmDosenController::class, 'destroy'])->name('pages.sitasi_luaran_pkm_dosen.destroy');
    Route::get('/sitasiluaranpkmdosen/export', [SitasiLuaranPkmDosenController::class, 'exportCsv'])->name('pages.sitasi_luaran_pkm_dosen.export');

    Route::get('/pengembangandosen', [PengembanganDosenController::class, 'show'])->name('pages.pengembangan_dosen');
    Route::post('/pengembangandosen', [PengembanganDosenController::class, 'add'])->name('pages.pengembangan_dosen.add');
    Route::put('/pengembangandosen/{id}', [PengembanganDosenController::class, 'update'])->name('pages.pengembangan_dosen.update');
    Route::delete('/pengembangandosen/{id}', [PengembanganDosenController::class, 'destroy'])->name('pages.pengembangan_dosen.destroy');
    Route::get('/pengembangandosen/export', [PengembanganDosenController::class, 'exportCsv'])->name('pages.pengembangan_dosen.export');

    Route::get('/pengembangantenagakependidikan', [PengembanganTenagaKependidikanController::class, 'show'])->name('pages.pengembangan_tenaga_kependidikan');
    Route::post('/pengembangantenagakependidikan', [PengembanganTenagaKependidikanController::class, 'add'])->name('pages.pengembangan_tenaga_kependidikan.add');
    Route::put('/pengembangantenagakependidikan/{id}', [PengembanganTenagaKependidikanController::class, 'update'])->name('pages.pengembangan_tenaga_kependidikan.update');
    Route::delete('/pengembangantenagakependidikan/{id}', [PengembanganTenagaKependidikanController::class, 'destroy'])->name('pages.pengembangan_tenaga_kependidikan.destroy');
    Route::get('/pengembangantenagakependidikan/export', [PengembanganTenagaKependidikanController::class, 'exportCsv'])->name('pages.pengembangan_tenaga_kependidikan.export');

    Route::get('/prestasimahasiswa', [PrestasiMahasiswaController::class, 'show'])->name('pages.prestasi_mahasiswa');
    Route::post('/prestasimahasiswa', [PrestasiMahasiswaController::class, 'add'])->name('pages.prestasi_mahasiswa.add');
    Route::put('/prestasimahasiswa/{id}', [PrestasiMahasiswaController::class, 'update'])->name('pages.prestasi_mahasiswa.update');
    Route::delete('/prestasimahasiswa/{id}', [PrestasiMahasiswaController::class, 'destroy'])->name('pages.prestasi_mahasiswa.destroy');
    Route::get('/prestasimahasiswa/export', [PrestasiMahasiswaController::class, 'exportCsv'])->name('pages.prestasi_mahasiswa.export');




});

Route::get('/diagram', [DiagramController::class, 'show'], function() {
    return view('pages.diagram_view');
})->middleware(['auth','verified','user'])->name('pages.diagram_view');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/form-off', function () {
    return view('form_off');
})->name('form.off');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');

    Route::get('/tambah-user', function () {
        return view('admin.tambah-user');
    })->middleware(['verified'])->name('admin.tambah-user');

    Route::get('/show', [HomeController::class, 'show'])->name('admin.show');

    //Route untuk komentar
    Route::post('/komentar', [KomentarController::class, 'store'])->name('admin.komentar');

     //route tahun_akademik
    Route::get('/tahun-akademik', [TahunAkademikController::class, 'index'])->name('tahun.index');
    Route::post('/tahun-akademik', [TahunAkademikController::class, 'store'])->name('tahun.store');
    Route::post('/tahun-akademik/{id}/aktifkan', [TahunAkademikController::class, 'setAktif'])->name('tahun.setAktif');

    // Route untuk edit user
    Route::get('/edit-user/{id}', [HomeController::class, 'edit'])->name('admin.edit-user');
    Route::put('/update-user/{id}', [HomeController::class, 'update'])->name('admin.update-user');

    // Route untuk delete user
    Route::delete('/delete-user/{id}', [HomeController::class, 'destroy'])->name('admin.delete-user');

     Route::get('/form-settings', [FormSettingController::class, 'index'])->name('form.settings');
    Route::post('/form-settings/{id}', [FormSettingController::class, 'update'])->name('form.settings.update');

    //route tahun_akademik
    Route::get('/tahun-akademik', [TahunAkademikController::class, 'index'])->name('tahun.index');
    Route::post('/tahun-akademik', [TahunAkademikController::class, 'store'])->name('tahun.store');
    Route::post('/tahun-akademik/{id}/aktifkan', [TahunAkademikController::class, 'setAktif'])->name('tahun.setAktif');

    // Route untuk tampilan analisis
    Route::get('/visimisi', [AnalisisController::class, 'visimisi'])->name('visimisi');
    Route::get('/kerjasamaAdmin', [AnalisisController::class, 'kerjasama'])->name('kerjasama_admin');
    Route::get('/kerjasama-pendidikan', [AnalisisController::class, 'kerjasama_pendidikan'])->name('pendidikan');
    Route::get('/kerjasama-penelitian', [AnalisisController::class, 'kerjasama_penelitian'])->name('penelitian');
    Route::get('/kerjasama-pengabdian', [AnalisisController::class, 'kerjasama_pengabdian'])->name('pengabdian');
    Route::get('/ketersediaan-dokumen', [AnalisisController::class, 'ketersedian_dokumen'])->name('ketersediaan_dokumen');
    Route::get('/evaluasi-pelaksanaan', [AnalisisController::class, 'evaluasi_pelaksanaan'])->name('evaluasi_pelaksanaan');
    Route::get('/profil_dosen', [AnalisisController::class, 'profil_dosen'])->name('profil_dosen');
    Route::get('/beban_kinerja_dosen', [AnalisisController::class, 'beban_kinerja_dosen'])->name('beban_kinerja_dosen');
    Route::get('/dosen-tidak-tetap', [AnalisisController::class, 'profile_dosen_tidak_tetap'])->name('profile_dosen_tidak_tetap');
    Route::get('/pelaksana-ta', [AnalisisController::class, 'pelaksana_ta'])->name('pelaksana_ta');
    Route::get('/lahan-praktek', [AnalisisController::class, 'lahan_praktek'])->name('lahan_praktek');
    Route::get('/kinerja-dtps', [AnalisisController::class, 'kinerjaDTPS'])->name('kinerjaDTPS');
    Route::get('/tenaga-kependidikan', [AnalisisController::class, 'tenaga_kependidikan'])->name('tenaga_kependidikan');
    Route::get('/rekognisi-tenaga-kependidikan', [AnalisisController::class, 'rekognisi_tenaga_kependidikan'])->name('rekognisi_tenaga_kependidikan');
    Route::get('/penelitian-dosen', [AnalisisController::class, 'penelitian_dosen'])->name('penelitian_dosen');
    Route::get('/penelitian-mahasiswa', [AnalisisController::class, 'penelitian_mahasiswa'])->name('penelitian_mahasiswa');
    Route::get('/publikasi-karya-ilmiah', [AnalisisController::class, 'publikasi_karya_ilmiah'])->name('publikasi_karya_ilmiah');
    Route::get('/luaran-karyailmiah', [AnalisisController::class, 'luaran_karya_ilmiah'])->name('luaran_karya_ilmiah');
    Route::get('/sitasi-luaranpd', [AnalisisController::class, 'sitasi_luaran_pd'])->name('sitasi_luaran_pd');
    Route::get('/pkm-dosen', [AnalisisController::class, 'pkm_dosen'])->name('pkm_dosen');
    Route::get('/pkm-mahasiswa', [AnalisisController::class, 'pkm_mahasiswa'])->name('pkm_mahasiswa');
    Route::get('/publikasi-ki-pkm', [AnalisisController::class, 'publikasi_ki_pkm'])->name('publikasi_ki_pkm');
    Route::get('/luaran-ki-pkm', [AnalisisController::class, 'luaran_ki_pkm'])->name('luaran_ki_pkm');
    Route::get('/luaran-pkm-dosen', [AnalisisController::class, 'sitasi_luaran_pkm_dosen'])->name('luaran_pkm_dosen');

});

// Dosen Route
Route::middleware(['auth', 'role:dosen'])->group(function () {
    Route::resource('/profil-dosen', ProfilController::class);

    Route::get('/dosen/dashboard', fn() => view('dosen.dashboard'))->name('dosen.dashboard');

    Route::get('/dosen/profildosen', [ProfilDosenController::class, 'show'])->middleware([CheckFormStatus::class . ':profil dosen'])->name('dosen.profil_dosen');
    Route::post('/dosen/profildosen', [ProfilDosenController::class, 'add'])->name('dosen.profil_dosen.add');
    Route::put('/dosen/profildosen/{id}', [ProfilDosenController::class, 'update'])->name('dosen.profil_dosen.update');
    Route::delete('/dosen/profildosen/{id}', [ProfilDosenController::class, 'destroy'])->name('dosen.profil_dosen.destroy');
    Route::get('/dosen/profildosen/export', [ProfilDosenController::class, 'exportCsv'])->name('dosen.profil_dosen.export');

    Route::get('/dosen/bebankinerjadosen', [BebanKinerjaDosenController::class, 'show'])->name('dosen.beban_kinerja_dosen');
    Route::post('/dosen/bebankinerjadosen', [BebanKinerjaDosenController::class, 'add'])->name('dosen.beban_kinerja_dosen.add');
    Route::put('/dosen/bebankinerjadosen/{id}', [BebanKinerjaDosenController::class, 'update'])->name('dosen.beban_kinerja_dosen.update');
    Route::delete('/dosen/bebankinerjadosen/{id}', [BebanKinerjaDosenController::class, 'destroy'])->name('dosen.beban_kinerja_dosen.destroy');
    Route::get('/dosen/bebankinerjadosen/export', [BebanKinerjaDosenController::class, 'exportCsv'])->name('dosen.beban_kinerja_dosen.export');

    Route::get('/dosen/rekognisidosen', [RekognisiDosenController::class, 'show'])->name('dosen.rekognisi_dosen');
    Route::post('/dosen/rekognisidosen', [RekognisiDosenController::class, 'add'])->name('dosen.rekognisi_dosen.add');
    Route::put('/dosen/rekognisidosen/{id}', [RekognisiDosenController::class, 'update'])->name('dosen.rekognisi_dosen.update');
    Route::delete('/dosen/rekognisidosen/{id}', [RekognisiDosenController::class, 'destroy'])->name('dosen.rekognisi_dosen.destroy');
    Route::get('/dosen/rekognisidosen/export', [RekognisiDosenController::class, 'exportCsv'])->name('dosen.rekognisi_dosen.export');

    Route::get('/dosen/penelitiandosen', [PenelitianDosenController::class, 'show'])->name('dosen.penelitian_dosen');
    Route::post('/dosen/penelitiandosen', [PenelitianDosenController::class, 'add'])->name('dosen.penelitian_dosen.add');
    Route::put('/dosen/penelitiandosen/{id}', [PenelitianDosenController::class, 'update'])->name('dosen.penelitian_dosen.update');
    Route::delete('/dosen/penelitiandosen/{id}', [PenelitianDosenController::class, 'destroy'])->name('dosen.penelitian_dosen.destroy');
    Route::get('/dosen/penelitiandosen/export', [PenelitianDosenController::class, 'exportCsv'])->name('dosen.penelitian_dosen.export');

    Route::get('/dosen/publikasikaryailmiah', [PublikasiKaryaIlmiahController::class, 'show'])->name('dosen.publikasi_karya_ilmiah');
    Route::post('/dosen/publikasikaryailmiah', [PublikasiKaryaIlmiahController::class, 'add'])->name('dosen.publikasi_karya_ilmiah.add');
    Route::put('/dosen/publikasikaryailmiah/{id}', [PublikasiKaryaIlmiahController::class, 'update'])->name('dosen.publikasi_karya_ilmiah.update');
    Route::delete('/dosen/publikasikaryailmiah/{id}', [PublikasiKaryaIlmiahController::class, 'destroy'])->name('dosen.publikasi_karya_ilmiah.destroy');
    Route::get('/dosen/publikasikaryailmiah/export', [PublikasiKaryaIlmiahController::class, 'exportCsv'])->name('dosen.publikasi_karya_ilmiah.export');

    Route::get('/dosen/luarankaryailmiah', [LuaranKaryaIlmiahController::class, 'show'])->name('dosen.luaran_karya_ilmiah');
    Route::post('/dosen/luarankaryailmiah', [LuaranKaryaIlmiahController::class, 'add'])->name('dosen.luaran_karya_ilmiah.add');
    Route::put('/dosen/luarankaryailmiah/{id}', [LuaranKaryaIlmiahController::class, 'update'])->name('dosen.luaran_karya_ilmiah.update');
    Route::delete('/dosen/luarankaryailmiah/{id}', [LuaranKaryaIlmiahController::class, 'destroy'])->name('dosen.luaran_karya_ilmiah.destroy');
    Route::get('/dosen/luarankaryailmiah/export', [LuaranKaryaIlmiahController::class, 'exportCsv'])->name('dosen.luaran_karya_ilmiah.export');

    Route::get('/dosen/pkmdosen', [PkmDosenController::class, 'show'])->name('dosen.pkm_dosen');
    Route::post('/dosen/pkmdosen', [PkmDosenController::class, 'add'])->name('dosen.pkm_dosen.add');
    Route::put('/dosen/pkmdosen/{id}', [PkmDosenController::class, 'update'])->name('dosen.pkm_dosen.update');
    Route::delete('/dosen/pkmdosen/{id}', [PkmDosenController::class, 'destroy'])->name('dosen.pkm_dosen.destroy');
    Route::get('/dosen/pkmdosen/export', [PkmDosenController::class, 'exportCsv'])->name('dosen.pkm_dosen.export');

    Route::get('/dosen/publikasipkm', [PublikasiPkmController::class, 'show'])->name('dosen.publikasi_pkm');
    Route::post('/dosen/publikasipkm', [PublikasiPkmController::class, 'add'])->name('dosen.publikasi_pkm.add');
    Route::put('/dosen/publikasipkm/{id}', [PublikasiPkmController::class, 'update'])->name('dosen.publikasi_pkm.update');
    Route::delete('/dosen/publikasipkm/{id}', [PublikasiPkmController::class, 'destroy'])->name('dosen.publikasi_pkm.destroy');
    Route::get('/dosen/publikasipkm/export', [PublikasiPkmController::class, 'exportCsv'])->name('dosen.publikasi_pkm.export');

    Route::get('/dosen/luaranpkm', [luaranpkmController::class, 'show'])->name('dosen.luaran_pkm');
    Route::post('/dosen/luaranpkm', [luaranpkmController::class, 'add'])->name('dosen.luaran_pkm.add');
    Route::put('/dosen/luaranpkm/{id}', [luaranpkmController::class, 'update'])->name('dosen.luaran_pkm.update');
    Route::delete('/dosen/luaranpkm/{id}', [luaranpkmController::class, 'destroy'])->name('dosen.luaran_pkm.destroy');
    Route::get('/dosen/luaranpkm/export', [luaranpkmController::class, 'exportCsv'])->name('dosen.luaran_pkm.export');

    Route::get('/dosen/pengembangandosen', [PengembanganDosenController::class, 'show'])->name('dosen.pengembangan_dosen');
    Route::post('/dosen/pengembangandosen', [PengembanganDosenController::class, 'add'])->name('dosen.pengembangan_dosen.add');
    Route::put('/dosen/pengembangandosen/{id}', [PengembanganDosenController::class, 'update'])->name('dosen.pengembangan_dosen.update');
    Route::delete('/dosen/pengembangandosen/{id}', [PengembanganDosenController::class, 'destroy'])->name('dosen.pengembangan_dosen.destroy');
    Route::get('/dosen/pengembangandosen/export', [PengembanganDosenController::class, 'exportCsv'])->name('dosen.pengembangan_dosen.export');

    Route::get('/dosen/pelaksanaanta', [PelaksanaanTaController::class, 'show'])->name('dosen.pelaksanaan_ta');
    Route::post('/dosen/pelaksanaanta', [PelaksanaanTaController::class, 'add'])->name('dosen.pelaksanaan_ta.add');
    Route::put('/dosen/pelaksanaanta/{id}', [PelaksanaanTaController::class, 'update'])->name('dosen.pelaksanaan_ta.update');
    Route::delete('/dosen/pelaksanaanta/{id}', [PelaksanaanTaController::class, 'destroy'])->name('dosen.pelaksanaan_ta.destroy');
    Route::get('/dosen/pelaksanaanta/export', [PelaksanaanTaController::class, 'exportCsv'])->name('dosen.pelaksanaan_ta.export');
});