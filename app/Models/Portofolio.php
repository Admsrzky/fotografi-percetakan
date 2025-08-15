<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    protected $table = 'portofolio'; // Pastikan nama tabel sesuai dengan yang ada di database
    protected $fillable = [
        'jasa_id',
        'judul',
        'deskripsi',
        'kategori',
        'gambar_utama',
        'gambar_galeri',
        'tahun',
        'unggulan',
    ];

    protected $casts = [
        'gambar_galeri' => 'array', // INI KUNCI PEMECAHAN MASALAHNYA!
        'email_verified_at' => 'datetime', // Jika ada
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'unggulan' => 'boolean', // Ini juga baik untuk konsistensi dengan Toggle
        // Jika kolom 'kategori' Anda ingin bisa menyimpan multiple value seperti tags,
        // Anda juga bisa cast 'kategori' => 'array', dan menggunakan TagsInput di Filament
    ];

    // Asumsi ada relasi ke model Jasa
    public function jasa()
    {
        return $this->belongsTo(Jasa::class);
    }
}
