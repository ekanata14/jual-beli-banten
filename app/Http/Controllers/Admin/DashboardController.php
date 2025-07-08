<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Penjual;

class DashboardController extends Controller
{
    public function index()
    {
        $viewData = [
            "title" => "Dashboard Owner",
            "totalPelanggan" => Pelanggan::count(),
            "totalPenjual" => Penjual::count(),
            "totalTransaksi" => Transaksi::count(),
            'totalPemasukan' => Transaksi::where('status', 'paid')->sum('total_harga'),
            "transaksis" => Transaksi::latest()->paginate(10),
        ];

        return view("admin.dashboard", $viewData);
    }
}
