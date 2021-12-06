<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Services\Tripay;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function show(Tripay $tripay, $id)
    {
        $donation = Donation::find($id);
        $transaction = $tripay->getDetailTransaction($donation->transaksi_ref);

        return view('donation.show', compact('donation', 'transaction'));
    }
}
