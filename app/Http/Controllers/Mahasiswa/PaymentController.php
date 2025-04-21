<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createPayment(Request $request)
    {
        $pendaftaran = Pendaftaran::findOrFail($request->pendaftaran_id);

        $params = [
            'transaction_details' => [
                'order_id' => 'KKN-' . $pendaftaran->id . '-' . time(),
                'gross_amount' => 500000, // Biaya pendaftaran KKN
            ],
            'customer_details' => [
                'first_name' => $pendaftaran->mahasiswa->nama,
                'email' => $pendaftaran->mahasiswa->email,
                'phone' => $pendaftaran->mahasiswa->no_hp,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function handleNotification(Request $request)
    {
        $payload = $request->all();

        $orderId = $payload['order_id'];
        $statusCode = $payload['status_code'];
        $grossAmount = $payload['gross_amount'];

        $pendaftaranId = explode('-', $orderId)[1];
        $pendaftaran = Pendaftaran::findOrFail($pendaftaranId);

        if ($statusCode == 200) {
            $pendaftaran->update([
                'status_pembayaran' => 'lunas',
                'tanggal_pembayaran' => now()
            ]);
        }

        return response()->json(['status' => 'success']);
    }
}