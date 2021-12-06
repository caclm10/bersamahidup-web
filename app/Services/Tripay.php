<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Tripay
{
    private $apiKey;
    private $privateKey;
    private $merchantCode;
    private $merchantRef;
    private $endpoint;

    public function __construct()
    {
        $this->apiKey = config('tripay.api_key');
        $this->privateKey = config('tripay.private_key');
        $this->merchantCode = config('tripay.merchant_code');
        $this->merchantRef = 'B-' . uniqid();
        $this->endpoint = config('tripay.endpoint');
    }

    public function getPaymentChannels()
    {
        $response = Http::withToken($this->apiKey)->get("{$this->endpoint}/merchant/payment-channel");

        $response = $response->object();

        // dd($response);

        return $response->success ? $response->data : [];
    }

    public function requestTransaction($method, $amount, $user, $campaign, $id_donasi)
    {
        $response = Http::withToken($this->apiKey)->post("{$this->endpoint}/transaction/create", [
            'merchant_ref' => $this->merchantRef,
            'method' => $method,
            'amount' => $amount,
            'customer_name' => $user['nama'],
            'customer_email' => $user['email'],
            'customer_phone' => $user['nohp'],
            'order_items' => [
                [
                    'name' => "$campaign->judul",
                    'price' => $amount,
                    'quantity' => 1,
                ]
            ],
            'expired_time' => time() + (24 * 60 * 60),
            'return_url' => route('donation.show', ['id' => $id_donasi]),
            'signature' => hash_hmac('sha256', $this->merchantCode . $this->merchantRef . $amount, $this->privateKey),
        ]);

        $response = $response->object();

        // dd($response);

        return $response->success ? $response->data : [];
    }

    public function getDetailTransaction($reference)
    {
        $response = Http::withToken($this->apiKey)->get("{$this->endpoint}/transaction/detail", [
            'reference' => $reference
        ]);


        $response = $response->object();
        return $response->success ? $response->data : [];
    }
}
