<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BiteshipService
{
    protected $apiKey;
    protected $endpoint;

    public function __construct()
    {
        $this->apiKey = "biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiYXBpX2tleV93ZWIiLCJ1c2VySWQiOiI2N2NkMzY5NjczMzA4ZjAwMTIyNWNiMjEiLCJpYXQiOjE3NTA4NDc4NTZ9.YjkkgBvbovhckif11WOyEBGv2vr81shgZDCz-UQM5KI";
        $this->endpoint = config('services.biteship.endpoint');
    }

    public function getCouriers($destination_postal_code)
    {
        $items = [
            'name' => 'Item Name', // Ganti dengan nama item kamu
            'value ' => 100000, // Ganti dengan nilai item kamu
            'quantity' => 1,
            'weight' => 1000,
        ];
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post("{$this->endpoint}/rates/couriers", [
            'origin_area_id' => 'IDNP1IDNC110IDND261IDZ80111', // Ganti dengan origin kamu
            'destination_area_id' => 'IDNP1IDNC437IDND5477IDZ82111',
            'couriers' => 'jne,jnt,sicepat,pos,tiki',
            'items' => [$items],
        ]);

        return $response->json();
    }

    public function searchAreas($input)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get("{$this->endpoint}/maps/areas", [
            'countries' => 'ID',
            'input' => $input,
            'type' => 'single',
        ]);

        return $response->json();
    }

    public function listCouriers()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get("{$this->endpoint}/couriers");

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
