<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PendaftaranKkn;
use App\Models\TempatKkn;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $pendaftaran = PendaftaranKkn::where('mahasiswa_id', $mahasiswa->id)->first();
        $tempat_kkn = TempatKkn::all();

        return view('mahasiswa.dashboard', compact('mahasiswa', 'pendaftaran', 'tempat_kkn'));
    }
}
