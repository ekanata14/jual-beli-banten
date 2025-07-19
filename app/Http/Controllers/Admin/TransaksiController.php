<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Produk;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $viewData = [
            "title" => "Transaksi",
            "penjuals" => User::where('role', 'penjual')->get(),
            "produks" => Produk::all(),
            "user" => null,
            "datas" => Transaksi::latest()->get(),
            'totalPemasukan' => Transaksi::where('status', 'paid')->sum('total_harga'),
        ];

        return view("admin.transaksi.index", $viewData);
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

        // Clone query for total calculations
        $baseQuery = clone $query;
        $totalPaid = (clone $baseQuery)->where('status', 'paid')->sum('total_harga');
        $totalPending = (clone $baseQuery)->where('status', 'pending')->sum('total_harga');
        $totalPemasukan = $totalPaid + $totalPending;

        $viewData = [
            "title" => "Transaksi",
            "penjuals" => User::where('role', 'penjual')->get(),
            "produks" => Produk::all(),
            "user" => null,
            "datas" => $query->paginate(10),
            'totalPaid' => $totalPaid,
            'totalPending' => $totalPending,
            'totalPemasukan' => $totalPemasukan,
        ];

        return view("admin.transaksi.index", $viewData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaksi = Transaksi::with(['orders', 'user'])->findOrFail($id);

        $viewData = [
            'title' => 'Detail Transaksi',
            'data' => $transaksi,
            'orders' => $transaksi->orders,
            'user' => $transaksi->user,
        ];

        return view('admin.transaksi.detail', $viewData);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
