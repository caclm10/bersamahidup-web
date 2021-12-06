<?php

namespace App\Http\Controllers;

use App\Mail\DonationSucceed;
use App\Models\CollectedDonation;
use Illuminate\Http\Request;
use App\Models\Donation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TripayCallbackController extends Controller
{
    protected $privateKey;

    public function __construct()
    {
        $this->privateKey = config('tripay.private_key');
    }

    public function handle(Request $request)
    {
        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE');
        $json = $request->getContent();
        $signature = hash_hmac('sha256', $json, $this->privateKey);

        if ($signature !== (string) $callbackSignature) {
            return 'Invalid signature';
        }

        if ('payment_status' !== (string) $request->server('HTTP_X_CALLBACK_EVENT')) {
            return 'Invalid callback event, no action was taken';
        }

        $data = json_decode($json);

        $donation = Donation::where('transaksi_ref', $data->reference)
            ->where('status', 'menunggu')
            ->first();

        if (!$donation) {
            return 'Transaksi tidak ditemukan / kadaluarsa / sudah dibayar';
        }

        if ((int) $data->total_amount !== (int) $donation->nominal) {
            return 'Nominal tidak sesuai';
        }

        switch ($data->status) {
            case 'PAID':
                try {
                    DB::transaction(function () use ($donation) {
                        $donation->update(['status' => 'selesai', 'tgl_donasi' => now()]);
                        $collectedDonation = CollectedDonation::where('id_galangan', $donation->id_galangan)->first();
                        $collectedDonation->jumlah += $donation->nominal;
                        $collectedDonation->save();
                    });

                    Mail::to($donation->donatur->email)->send(new DonationSucceed($donation));
                    return response()->json(['success' => true]);
                } catch (\Throwable $e) {
                    return "Terjadi kesalahan dalam menyimpan data";
                }

            case 'EXPIRED':
                $donation->update(['status' => 'gagal']);
                return response()->json(['success' => true]);

            case 'FAILED':
                $donation->update(['status' => 'gagal']);
                return response()->json(['success' => true]);

            default:
                return 'Status pembayaran tidak diketahui';
        }
    }
}
