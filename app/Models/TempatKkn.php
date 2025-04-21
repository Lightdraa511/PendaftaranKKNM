<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TempatKkn extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_tempat',
        'kecamatan',
        'kabupaten',
        'kuota',
        'deskripsi',
    ];
}
