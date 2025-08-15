<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';

    protected $fillable = [
        'jasa_id',
        'tanggal_mulai',
        'tanggal_akhir',
        'alasan',
    ];

    public function jasa()
    {
        return $this->belongsTo(Jasa::class);
    }
}
