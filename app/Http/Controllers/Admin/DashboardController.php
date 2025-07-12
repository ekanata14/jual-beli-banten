<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Penjual;
use App\Models\Produk;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $title = null;
        if (auth()->user()->role === 'owner') {
            $title = "Dashboard Owner";
        } elseif (auth()->user()->role === 'admin') {
            $title = "Dashboard Admin";
        } else {
            abort(403, 'Unauthorized action.');
        }

        $viewData = [
            "title" => $title,
            "penjuals" => User::where('role', 'penjual')->get(),
            "produks" => Produk::all(),
            "totalPelanggan" => Pelanggan::count(),
            "totalPenjual" => Penjual::count(),
            "totalTransaksi" => Transaksi::count(),
            'totalPemasukan' => Transaksi::where('status', 'paid')->sum('total_harga'),
            "transaksis" => Transaksi::latest()->paginate(10),
            'produkTerlaris' => Produk::with('orders')
                ->take(10)
                ->get()
        ];

        return view("admin.dashboard", $viewData);
    }
    public function filter(Request $request)
    {
        $query = Transaksi::query()->latest();

        // Filter berdasarkan penjual (lewat produk di orders)
        if ($request->filled('penjual_id')) {
            $query->whereHas('orders.produk', function ($q) use ($request) {
                $q->where('id_user', $request->penjual_id);
            });
        }

        // Filter berdasarkan produk (lewat orders)
        if ($request->filled('produk_id')) {
            $query->whereHas('orders', function ($q) use ($request) {
                $q->where('id_produk', $request->produk_id);
            });
        }

        // Filter berdasarkan rentang tanggal transaksi
        if ($request->filled('tanggal_dari') && $request->filled('tanggal_sampai')) {
            $tanggalDari = date('Y-m-d', strtotime($request->tanggal_dari));
            // Tambahkan satu hari ke tanggalSampai agar tanggal akhir termasuk
            $tanggalSampai = date('Y-m-d', strtotime($request->tanggal_sampai . ' +1 day'));
            $query->whereBetween('tanggal_transaksi', [
                $tanggalDari,
                $tanggalSampai
            ]);
        }

        $title = null;
        if (auth()->user()->role === 'owner') {
            $title = "Dashboard Owner";
        } elseif (auth()->user()->role === 'admin') {
            $title = "Dashboard Admin";
        } else {
            abort(403, 'Unauthorized action.');
        }

        $viewData = [
            "title" => $title,
            "penjuals" => User::where('role', 'penjual')->get(),
            "produks" => Produk::all(),
            "transaksis" => $query->paginate(10),
            "totalPelanggan" => Pelanggan::count(),
            "totalPenjual" => Penjual::count(),
            "totalTransaksi" => Transaksi::count(),
            'totalPemasukan' => Transaksi::where('status', 'paid')->sum('total_harga'),
            'produkTerlaris' => Produk::with('orders')
                ->take(10)
                ->get()
        ];

        return view("admin.dashboard", $viewData);
    }
}
