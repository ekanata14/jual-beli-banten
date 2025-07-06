<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Produk;

class BiteshipService
{
    protected $apiKey;
    protected $endpoint;

    public function __construct()
    {
        $this->apiKey = "biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiYXBpX2tleV93ZWIiLCJ1c2VySWQiOiI2N2NkMzY5NjczMzA4ZjAwMTIyNWNiMjEiLCJpYXQiOjE3NTA4NDc4NTZ9.YjkkgBvbovhckif11WOyEBGv2vr81shgZDCz-UQM5KI";
        $this->endpoint = config('services.biteship.endpoint');
    }

    public function getRatesByCoordinates($origin_latitude, $origin_longitude, $destination_latitude, $destination_longitude)
    {
        $items = [
            [
                "name" => "Polaris Coffee Cream 330ml isi 3 pcs",
                "description" => "",
                "length" => 10,
                "width" => 10,
                "height" => 0,
                "weight" => 1000,
                "value" => 285600,
                "quantity" => 1
            ]
        ];
        $couriers = "grab,gojek";
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Content-Type' => 'application/json',
        ])->post("{$this->endpoint}/rates/couriers", [
            'origin_latitude' => $origin_latitude,
            'origin_longitude' => $origin_longitude,
            'destination_latitude' => $destination_latitude,
            'destination_longitude' => $destination_longitude,
            'couriers' => $couriers,
            'items' => $items,
        ]);

        return $response->json();
    }

    public function searchAreas($input)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . "biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiYXBpX2tleV93ZWIiLCJ1c2VySWQiOiI2N2NkMzY5NjczMzA4ZjAwMTIyNWNiMjEiLCJpYXQiOjE3NTA4NDc4NTZ9.YjkkgBvbovhckif11WOyEBGv2vr81shgZDCz-UQM5KI",
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
