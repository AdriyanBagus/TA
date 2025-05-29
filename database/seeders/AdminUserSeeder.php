<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\menuAdmin;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin456'), // Gantilah password sesuai kebutuhan Anda
            'usertype' => 'Admin', // Pastikan kolom role ada di tabel User
        ]);

        // menu admin
        $menus = [
            ['menu' => 'Visi Misi', 'menu_id' => '2.1.1', 'link' => 'visimisi'],
            ['menu' => 'Kerja Sama', 'menu_id' => '2.2.1', 'link' => 'kerjasama_admin'],
            ['menu' => 'Ketersediaan Dokumen ', 'menu_id' => '2.2.2', 'link' => 'ketersediaan_dokumen'],
            ['menu' => 'Evaluasi pelaksanaan', 'menu_id' => '2.2.3', 'link' => 'evaluasi_pelaksanaan'],
            ['menu' => 'Profile Dosen', 'menu_id' => '2.4.1 ', 'link' => 'profil_dosen'],
            ['menu' => 'Beban Kinerja Dosen', 'menu_id' => '2.4.2', 'link' => 'beban_kinerja_dosen'],
            ['menu' => 'Profil Dosen tidak tetap', 'menu_id' => '2.4.3', 'link' => 'profile_dosen_tidak_tetap'],
            ['menu' => 'Pelaksanaan TA', 'menu_id' => '2.4.4', 'link' => 'pelaksana_ta'],
            ['menu' => 'Lahan Praktek', 'menu_id' => '2.4.5', 'link' => 'lahan_praktek'],
            ['menu' => 'Kinerja DTPS', 'menu_id' => '2.4.6', 'link' => 'kinerjaDTPS'],
            ['menu' => 'Profil Tenaga Kependidikan', 'menu_id' => '2.4.7', 'link' => 'tenaga_kependidikan'],
            ['menu' => 'Rekognisi Tenaga Kependidikan', 'menu_id' => '2.4.8', 'link' => 'rekognisi_tenaga_kependidikan'],
            ['menu' => 'Penelitian Dosen', 'menu_id' => '2.7.1', 'link' => 'penelitian_dosen'],
            ['menu' => 'Penelitian Mahasiswa', 'menu_id' => '2.7.2', 'link' => 'penelitian_mahasiswa'],
            ['menu' => 'Publikasi Karya Ilmiah', 'menu_id' => '2.7.3', 'link' => 'publikasi_karya_ilmiah'],
            ['menu' => 'Luaran Karya Ilmiah', 'menu_id' => '2.7.4', 'link' => 'luaran_karya_ilmiah'],
            ['menu' => 'Sitasi Luaran Penelitian Dosen', 'menu_id' => '2.7.5', 'link' => 'sitasi_luaran_pd'],
            ['menu' => 'PKM Dosen', 'menu_id' => '2.8.1', 'link' => 'pkm_dosen'],
            ['menu' => 'PKM Mahasiswa', 'menu_id' => '2.8.2', 'link' => 'pkm_mahasiswa'],
            ['menu' => 'Publikasi Karya Ilmiah PKM', 'menu_id' => '2.8.3', 'link' => 'publikasi_ki_pkm'],
            ['menu' => 'Luaran Karya Ilmiah PKM', 'menu_id' => '2.8.4', 'link' => 'luaran_ki_pkm'],
            ['menu' => 'Sitasi Luaran PKM Dosen', 'menu_id' => '2.8.5', 'link' => 'luaran_pkm_dosen'],
        ];

        foreach ($menus as $menu) {
            MenuAdmin::create($menu);
        }

        // menu user
        $menuUser = [
            ['menu' => 'Analisis Ketercapaian', 'link' => 'pages.visi_misi', 'menu_id' => '2.1.1'],
            ['menu' => 'Kerjasama', 'link' => 'pages.kerjasama', 'menu_id' => '2.2.1'],
            ['menu' => 'Ketersediaan Dokumen', 'link' => 'pages.ketersediaan_dokumen', 'menu_id' => '2.2.2'],
            ['menu' => 'Evaluasi Pelaksanaan', 'link' => 'pages.evaluasi_pelaksanaan', 'menu_id' => '2.2.3'],
            ['menu' => 'Profil Dosen', 'link' => 'pages.profil_dosen', 'menu_id' => '2.4.1'],
            ['menu' => 'Beban Kinerja Dosen', 'link' => 'pages.beban_kinerja_dosen', 'menu_id' => '2.4.2'],
            ['menu' => 'Profil Dosen Tidak Tetap', 'link' => 'pages.profil_dosen_tidak_tetap', 'menu_id' => '2.4.3'],
            ['menu' => 'Pelaksanaan TA', 'link' => 'pages.pelaksanaan_ta', 'menu_id' => '2.4.4'],
            ['menu' => 'Lahan Praktek', 'link' => 'pages.lahan_praktek', 'menu_id' => '2.4.5'],
            ['menu' => 'Kinerja DTPS', 'link' => 'pages.kinerja_dtps', 'menu_id' => '2.4.6'],
            ['menu' => 'Profil Tenaga Kependidikan', 'link' => 'pages.profil_tenaga_kependidikan', 'menu_id' => '2.4.7'],
            ['menu' => 'Rekognisi Tenaga Kependidikan', 'link' => 'pages.rekognisi_tenaga_kependidikan', 'menu_id' => '2.4.8'],
            ['menu' => 'Penelitian Dosen', 'link' => 'pages.penelitian_dosen', 'menu_id' => '2.7.1'],
            ['menu' => 'Penelitian Mahasiswa', 'link' => 'pages.penelitian_mahasiswa', 'menu_id' => '2.7.2'],
            ['menu' => 'Publikasi Karya Ilmiah', 'link' => 'pages.publikasi_karya_ilmiah', 'menu_id' => '2.7.3'],
            ['menu' => 'Luaran Karya Ilmiah', 'link' => 'pages.luaran_karya_ilmiah', 'menu_id' => '2.7.4'],
            ['menu' => 'Sitasi Luaran Penelitian Dosen', 'link' => 'pages.sitasi_luaran_penelitian_dosen', 'menu_id' => '2.7.5'],
            ['menu' => 'PKM Dosen', 'link' => 'pages.pkm_dosen', 'menu_id' => '2.8.1'],
            ['menu' => 'PKM Mahasiswa', 'link' => 'pages.pkm_mahasiswa', 'menu_id' => '2.8.2'],
            ['menu' => 'Publikasi Karya Ilmiah PKM', 'link' => 'pages.publikasi_karya_ilmiah_pkm', 'menu_id' => '2.8.3'],
            ['menu' => 'Luaran Karya Ilmiah PKM', 'link' => 'pages.luaran_karya_ilmiah_pkm', 'menu_id' => '2.8.4'],
            ['menu' => 'Sitasi Luaran PKM Dosen', 'link' => 'pages.sitasi_luaran_pkm_dosen', 'menu_id' => '2.8.5'],
        ];

        foreach ($menuUser as $data) {
            Menu::create($data);
        }
    }
}
