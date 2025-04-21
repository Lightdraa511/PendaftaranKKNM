<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'tempat_kkn_id',
        'status_pembayaran',
        'tanggal_pembayaran',
        'status_pendaftaran',
        'alasan_penolakan'
    ];

    protected $casts = [
        'tanggal_pembayaran' => 'datetime',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function tempatKkn()
    {
        return $this->belongsTo(TempatKkn::class);
    }
}
