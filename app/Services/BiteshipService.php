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

    public function getRates($origin_postal_code, $destination_postal_code)
    {
        $item = [
            [
                "name" => "Shoes",
                "description" => "Black colored size 45",
                "value" => 199000,
                "length" => 30,
                "width" => 15,
                "height" => 20,
                "weight" => 200,
                "quantity" => 2
            ]
        ];
        $couriers = "ninja,sap,gojek,grab,deliveree,jne,tiki,ninja,lion,rara,sicepat,jnt,idexpress,rpx,jdl,wahana,pos,anteraja,sap,paxel,borzo,lalamove";
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Content-Type' => 'application/json',
        ])->post("{$this->endpoint}/rates/couriers", [
            'origin_postal_code' => $origin_postal_code,
            'destination_postal_code' => $destination_postal_code,
            'couriers' => $couriers,
            'items' => $item,
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
