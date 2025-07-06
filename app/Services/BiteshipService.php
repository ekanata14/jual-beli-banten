<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Produk;
use App\Models\Transaksi;

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

    public function orderCourier($transactionId)
    {
        // Fetch transaction with orders, each order with produk and pengiriman
        $transaction = Transaksi::with(['orders.produk', 'orders.pengiriman'])->findOrFail($transactionId);

        // Group orders by id_pengiriman to avoid duplicate courier orders
        $groupedOrders = [];
        foreach ($transaction->orders as $order) {
            $pengirimanId = $order->id_pengiriman;
            if (!isset($groupedOrders[$pengirimanId])) {
                $groupedOrders[$pengirimanId] = [
                    'pengiriman' => $order->pengiriman,
                    'orders' => [],
                ];
            }
            $groupedOrders[$pengirimanId]['orders'][] = $order;
        }

        $results = [];
        foreach ($groupedOrders as $pengirimanId => $data) {
            $pengiriman = $data['pengiriman'];
            $orders = $data['orders'];

            // Prepare shipper/origin data (from pengiriman/alamat_penjual)
            $shipper = [
                "origin_contact_name" => $pengiriman->id_penjual ? ($pengiriman->penjual->name ?? 'Penjual') : 'Penjual',
                "origin_contact_phone" => $pengiriman->telp_penjual ?? '08123456789',
                "origin_address" => $pengiriman->alamat_penjual ?? 'Origin Address',
                "origin_note" => '',
                "origin_coordinate" => [
                    "latitude" => $pengiriman->latitude_penjual ?? -6.2253114,
                    "longitude" => $pengiriman->longitude_penjual ?? 106.7993735,
                ],
            ];

            // Prepare destination data (from pengiriman)
            $destination = [
                "destination_contact_name" => $pengiriman->nama_penerima ?? 'Recipient Name',
                "destination_contact_phone" => $pengiriman->telp_penerima ?? '08123456789',
                "destination_contact_email" => $pengiriman->email_penerima ?? 'recipient@example.com',
                "destination_address" => $pengiriman->alamat_penerima ?? 'Destination Address',
                "destination_note" => '',
                "destination_coordinate" => [
                    "latitude" => $pengiriman->latitude_penerima ?? -6.28927,
                    "longitude" => $pengiriman->longitude_penerima ?? 106.77492,
                ],
            ];

            // Prepare items for this shipment
            $items = [];
            foreach ($orders as $order) {
                $produk = $order->produk;
                $items[] = [
                    "name" => $produk->nama_produk,
                    "description" => $produk->deskripsi_produk ?? '',
                    "category" => $produk->kategori ?? 'general',
                    "value" => (int) $order->subtotal,
                    "quantity" => (int) $order->jumlah,
                    "weight" => (int) $produk->berat ?? 200,
                ];
            }

            // Prepare request body
            $body = array_merge($shipper, $destination, [
                "courier_company" => $pengiriman->kurir->kode_kurir ?? 'grab',
                "courier_type" => $pengiriman->kurir->kode_servis ?? 'instant',
                "courier_insurance" => 0,
                "delivery_type" => 'now',
                "order_note" => '',
                "metadata" => [],
                "items" => $items,
            ]);

            // Call Biteship API
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->endpoint . '/orders', $body);

            $results[$pengirimanId] = $response->json();
        }

        return $results;
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
