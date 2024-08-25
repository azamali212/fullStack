<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SmsServices
{
    protected $apiKey;
    protected $apiSecret;
    protected $from;

    public function __construct()
    {
        $this->apiKey = config('services.nexmo.key');
        $this->apiSecret = config('services.nexmo.secret');
        $this->from = config('services.nexmo.from');
    }

    public function send($to, $message)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($this->apiKey . ':' . $this->apiSecret),
        ])->post('https://rest.nexmo.com/sms/json', [
            'api_key' => $this->apiKey,
            'api_secret' => $this->apiSecret,
            'to' => $to,
            'from' => $this->from,
            'text' => $message,
        ]);

        return $response->json();
    }
}