<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $table = 'paket';

    protected $fillable = [
        'jasa_id',
        'nama_paket',
        'deskripsi_paket',
        'harga_paket',
        'kategori',
        'info_durasi',
        'info_output',
        'urutan_tampil',
        'aktif',
    ];

    protected $casts = [
        'fur_paket' => 'array', // Cast fur_paket to array for easier JSON handling
        'aktif' => 'boolean',
    ];

    public function jasa()
    {
        return $this->belongsTo(Jasa::class);
    }

    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class);
    }
}
