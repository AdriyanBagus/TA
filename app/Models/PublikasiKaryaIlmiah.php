<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// Gemi's Edit: Menambahkan ini jika belum ada, untuk HasFactory
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PublikasiKaryaIlmiah extends Model
{
    // Gemi's Edit: Menambahkan ini jika belum ada
    use HasFactory;

    protected $table = 'publikasi_karya_ilmiah';

    /**
     * Gemi's Edit: Daftar kolom yang boleh diisi.
     * 1. Hapus 'nama_jurnal' karena sudah masuk ke dalam 'detail_publikasi'.
     * 2. Tambahkan 'detail_publikasi' untuk memberikan izin.
     */
    protected $fillable = [
        'user_id',
        'tahun_akademik_id',
        'judul_penelitian',
        'judul_publikasi',
        'nama_author',
        'jenis',
        'tingkat',
        'url',
        'detail_publikasi', // <-- DITAMBAHKAN
        'parent_id'
    ];

    /**
     * Gemi's Edit: Menambahkan "Mantra Sihir" $casts.
     * Ini memberitahu Laravel untuk secara otomatis mengubah
     * data dari kolom 'detail_publikasi' menjadi array saat dibaca,
     * dan menjadi JSON saat disimpan.
     */
    protected $casts = [
        'detail_publikasi' => 'json',
    ];
}