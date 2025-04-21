<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PendaftaranKkn extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'status_pembayaran',
        'order_id',
        'tempat_kkn',
        'status_pendaftaran',
        'alasan_pemilihan',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
