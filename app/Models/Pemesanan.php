<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';

    protected $fillable = [
        'pengguna_id',
        'jasa_id',
        'paket_id',
        'quantity',
        'subtotal',
        'total_harga',
        'dp_amount',
        'remaining_payment',
        'bukti_pelunasan_path',
        'is_pelunasan_confirmed',
        'tanggal_pelunasan',
        'payment_type',
        'nama_pelanggan',
        'email_pelanggan',
        'telepon_pelanggan',
        'tanggal_acara',
        'lokasi_acara',
        'catatan_tambahan',
        'status_pemesanan',
        'bukti_pembayaran',
        'catatan_admin',
    ];

    protected $casts = [
        'tanggal_acara' => 'date',
        'tanggal_pelunasan' => 'datetime', // PASTIKAN BARIS INI ADA
        'is_pelunasan_confirmed' => 'boolean',
        // ... (cast lainnya jika ada)
    ];

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    public function jasa()
    {
        return $this->belongsTo(Jasa::class);
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    // Accessor untuk bukti pembayaran DP/Awal
    public function getBuktiPembayaranUrlAttribute(): ?string
    {
        if ($this->bukti_pembayaran) { // Sesuaikan dengan nama kolom DB Anda
            return Storage::url($this->bukti_pembayaran);
        }
        return null; // Atau return URL placeholder jika tidak ada gambar
    }

    // Accessor untuk bukti pelunasan
    public function getBuktiPelunasanUrlAttribute(): ?string
    {
        if ($this->bukti_pelunasan_path) { // Sesuaikan dengan nama kolom DB Anda
            return Storage::url($this->bukti_pelunasan_path);
        }
        return null; // Atau return URL placeholder jika tidak ada gambar
    }
}
