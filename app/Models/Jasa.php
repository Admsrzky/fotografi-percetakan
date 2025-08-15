<?php

namespace App\Models;

use App\Models\Jadwal;
use App\Models\Paket;
use App\Models\Pemesanan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Jasa extends Model
{
    protected $table = 'jasa';

    protected $fillable = [
        'nama_jasa',
        'slug',
        'deskripsi_jasa',
        'tipe_jasa',
        'gambar_jasa',
        'aktif',
    ];

    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class);
    }

    public function pakets()
    {
        return $this->hasMany(Paket::class);
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }

    public function setNamaJasaAttribute($value)
    {
        $this->attributes['nama_jasa'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
