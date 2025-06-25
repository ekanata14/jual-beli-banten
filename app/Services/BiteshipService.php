<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BiteshipService
{
    protected $apiKey;
    protected $endpoint;

    public function __construct()
    {
        $this->apiKey = config('services.biteship.api_key');
        $this->endpoint = config('services.biteship.endpoint');
    }

    public function getCouriers($destination_postal_code)
    {
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
        ])->get("{$this->endpoint}/couriers/cost", [
            'origin_area_id' => 'ID-DPS-201', // Ganti dengan origin kamu
            'destination_postal_code' => $destination_postal_code,
            'couriers' => 'jne,jnt,sicepat,pos,tiki',
            'weight' => 1000 // berat dalam gram
        ]);

        return $response->json();
    }

    public function createShipment($params)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->endpoint . '/orders', $params);

        return $response->json();
    }
}
