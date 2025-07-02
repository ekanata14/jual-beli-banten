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
            "title" => "Dashboard Admin",
            "totalPelanggan" => Pelanggan::count(),
            "totalPenjual" => Penjual::count(),
            "totalTransaksi" => Transaksi::count(),
        ];

        return view("admin.dashboard", $viewData);
    }
}
