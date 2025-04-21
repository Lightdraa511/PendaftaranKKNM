<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PendaftaranKkn;
use App\Models\TempatKkn;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class PendaftaranController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function showForm()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $pendaftaran = PendaftaranKkn::where('mahasiswa_id', $mahasiswa->id)->first();
        $tempat_kkn = TempatKkn::all();

        if ($pendaftaran) {
            return redirect()->route('mahasiswa.dashboard');
        }

        return view('mahasiswa.pendaftaran.form', compact('tempat_kkn'));
    }

    public function createPayment(Request $request)
    {
        $request->validate([
            'tempat_kkn_id' => 'required|exists:tempat_kkns,id',
        ]);

        $mahasiswa = Auth::guard('mahasiswa')->user();
        $tempat_kkn = TempatKkn::findOrFail($request->tempat_kkn_id);

        $pendaftaran = PendaftaranKkn::create([
            'mahasiswa_id' => $mahasiswa->id,
            'tempat_kkn' => $tempat_kkn->nama_tempat,
            'status_pembayaran' => 'pending',
            'status_pendaftaran' => 'pending',
        ]);

        $transaction_details = [
            'order_id' => 'KKN-' . $pendaftaran->id,
            'gross_amount' => 150000, // Biaya pendaftaran KKN
        ];

        $customer_details = [
            'first_name' => $mahasiswa->nama,
            'email' => $mahasiswa->email,
            'phone' => $mahasiswa->no_hp,
        ];

        $transaction = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
        ];

        try {
            $snapToken = Snap::getSnapToken($transaction);
            $pendaftaran->update(['order_id' => $transaction_details['order_id']]);

            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function handleCallback(Request $request)
    {
        $orderId = $request->order_id;
        $pendaftaran = PendaftaranKkn::where('order_id', $orderId)->firstOrFail();

        if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
            $pendaftaran->update(['status_pembayaran' => 'success']);
        } elseif ($request->transaction_status == 'pending') {
            $pendaftaran->update(['status_pembayaran' => 'pending']);
        } else {
            $pendaftaran->update(['status_pembayaran' => 'failed']);
        }

        return response()->json(['status' => 'success']);
    }

    public function showFormData()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $pendaftaran = PendaftaranKkn::where('mahasiswa_id', $mahasiswa->id)->firstOrFail();

        if ($pendaftaran->status_pembayaran != 'success') {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Anda harus menyelesaikan pembayaran terlebih dahulu.');
        }

        return view('mahasiswa.pendaftaran.form-data', compact('pendaftaran'));
    }

    public function submitFormData(Request $request)
    {
        $request->validate([
            'alasan_pemilihan' => 'required|string|min:100',
        ]);

        $mahasiswa = Auth::guard('mahasiswa')->user();
        $pendaftaran = PendaftaranKkn::where('mahasiswa_id', $mahasiswa->id)->firstOrFail();

        $pendaftaran->update([
            'alasan_pemilihan' => $request->alasan_pemilihan,
            'status_pendaftaran' => 'submitted',
        ]);

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Data pendaftaran KKN berhasil disimpan.');
    }
}
