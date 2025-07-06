<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Midtrans
use Midtrans\Snap;
use Midtrans\Config;

// Biteship
use App\Services\BiteshipService;

// Models
use App\Models\Transaksi;
use App\Models\Pengiriman;
use App\Models\Order;
use App\Models\Produk;
use App\Models\Keranjang;

class LandingPageController extends Controller
{
    public function index()
    {
        $viewData = [
            'title' => 'Beranda | Bhakti E Commerce',
            'activePage' => '/',
            'products' => Produk::orderBy('created_at', 'desc')
                ->get()
        ];
        return view('landing-page.home', $viewData);
    }
    public function about()
    {
        $viewData = [
            'title' => 'Tentang Kami | Bhakti E Commerce',
            'activePage' => 'about'
        ];
        return view('landing-page.about', $viewData);
    }
    public function product()
    {
        $viewData = [
            'title' => 'Tentang Kami | Bhakti E Commerce',
            'activePage' => 'product',
            'products' => Produk::orderBy('created_at', 'desc')
                ->paginate(10)
        ];
        return view('landing-page.product', $viewData);
    }
    public function productDetail()
    {
        $viewData = [
            'title' => 'Produk Detail | Bhakti E Commerce',
            'activePage' => 'product/product_detail',
            'product' => Produk::find(request()->query('id')) ?: null
        ];
        return view('landing-page.productDetail', $viewData);
    }

    public function history()
    {
        $viewData = [
            'title' => 'Riwayat Transaksi | Bhakti E Commerce',
            'activePage' => 'history',
            'datas' => Transaksi::where('id_user', auth()->user()->id)
                ->with('pengiriman')
                ->orderBy('created_at', 'desc')
                ->paginate(10)
        ];

        return view('landing-page.history', $viewData);
    }

    public function historyDetail(string $id)
    {
        $viewData = [
            'title' => 'Riwayat Transaksi | Bhakti E Commerce',
            'activePage' => 'history',
            'data' => Transaksi::where('id', $id)
                ->with('pengiriman')
                ->orderBy('created_at', 'desc')
                ->first()
        ];

        return view('landing-page.detail-transaction', $viewData);
    }
    public function cart()
    {
        $viewData = [
            'title' => 'Keranjang Belanja | Bhakti E Commerce',
            'activePage' => 'cart',
            'datas' => Keranjang::where('id_user', auth()->user()->id)
                ->with('produk')
                ->get()
        ];
        return view('landing-page.cart', $viewData);
    }

    public function addToCart(Request $request)
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validate([
                'product_id' => 'required|integer',
                'quantity' => 'required|integer|min:1',
            ]);

            $produk = Produk::find($validatedData['product_id']);
            if (!$produk) {
                return back()->with('error', 'Produk tidak ditemukan');
            }


            $validatedData['id_user'] = auth()->user()->id;
            // Menggunakan model Keranjang
            $cartItem = Keranjang::where([
                ['id_produk', '=', $validatedData['product_id']],
                ['id_user', '=', $validatedData['id_user']],
            ])->first();

            $produk->stok -= $validatedData['quantity'];
            if ($produk->stok < 0) {
                return back()->with('error', 'Stok produk tidak mencukupi');
            }
            $produk->save();

            if ($cartItem) {
                $cartItem->jumlah += $validatedData['quantity'];
                $cartItem->updated_at = now();
                $cartItem->save();
            } else {
                Keranjang::create([
                    'id_produk' => $validatedData['product_id'],
                    'jumlah' => $validatedData['quantity'],
                    'id_user' => $validatedData['id_user'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();
            return back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with(['error' => 'Gagal menambahkan ke keranjang: ' . $e->getMessage()]);
        }
    }

    public function updateCart(Request $request)
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validate([
                'id' => 'required|integer',
                'quantity' => 'required|integer|min:1',
            ]);

            $cartItem = Keranjang::where('id', $validatedData['id'])
                ->where('id_user', auth()->user()->id)
                ->with('produk')
                ->first();

            if ($cartItem) {
                $cartItem->jumlah = $validatedData['quantity'];
                $cartItem->updated_at = now();
                $cartItem->save();

                // Hitung ulang subtotal keranjang
                $cartItems = Keranjang::where('id_user', auth()->user()->id)->with('produk')->get();
                $totalPrice = 0;
                $totalJumlah = 0;
                foreach ($cartItems as $item) {
                    $totalPrice += ($item->produk ? $item->produk->harga : 0) * $item->jumlah;
                    $totalJumlah += $item->jumlah;
                }

                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Jumlah produk di keranjang berhasil diperbarui',
                    'harga' => $cartItem->produk ? $cartItem->produk->harga : 0,
                    'totalPrice' => $totalPrice,
                    'totalJumlah' => $totalJumlah,
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Keranjang tidak ditemukan atau tidak sesuai user.'
                ], 404);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function removeFromCart(Request $request)
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validate([
                'id' => 'required|integer',
                'product_id' => 'required|integer',
            ]);

            $cartItem = Keranjang::where('id', $validatedData['id'])->first();

            if ($cartItem) {
                $cartItem->delete();
                DB::commit();
                return back()->with('success', 'Produk berhasil dihapus dari keranjang');
            } else {
                return back()->with('error', 'Produk tidak ditemukan di keranjang');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with(['error' => 'Gagal menghapus dari keranjang: ' . $e->getMessage()]);
        }
    }

    public function detail_transaction()
    {
        $viewData = [
            'title' => 'Detail Transaksi | Bhakti E Commerce',
        ];
        return view('landing-page.detail-transaction', $viewData);
    }

    public function checkoutItem()
    {
        // Ambil semua item keranjang milik user
        $cartItems = Keranjang::where('id_user', auth()->user()->id)
            ->with('produk')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang belanja Anda kosong.');
        }

        // Buat transaksi baru
        DB::beginTransaction();
        try {
            $totalHarga = 0;
            foreach ($cartItems as $item) {
                $totalHarga += ($item->produk ? $item->produk->harga : 0) * $item->jumlah;
            }

            $invoiceNumber = 'INV-' . time() . '-' . auth()->user()->id . '-' . rand(1000, 9999);

            $transaksi = Transaksi::create([
                'id_user' => auth()->user()->id,
                'invoice_number' => $invoiceNumber,
                'total_harga' => $totalHarga,
                'status' => 'pending',
                'metode_pembayaran' => 'transfer',
                'tanggal_transaksi' => now(),
            ]);

            // Simpan setiap item keranjang ke tabel order
            foreach ($cartItems as $item) {
                Order::create([
                    'id_transaksi' => $transaksi->id,
                    'id_produk' => $item->id_produk,
                    'jumlah' => $item->jumlah,
                    'subtotal' => ($item->produk ? $item->produk->harga : 0) * $item->jumlah,
                ]);
            }

            // Kosongkan keranjang user
            Keranjang::where('id_user', auth()->user()->id)->delete();

            DB::commit();

            return redirect()->route('checkout', $transaksi->id)->with('success', 'Checkout berhasil, silakan isi data pengiriman.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal melakukan checkout: ' . $e->getMessage());
        }
    }

    public function checkoutDirect(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $produk = Produk::find($validated['product_id']);
        if (!$produk) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        if ($produk->stok < $validated['quantity']) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi.');
        }

        DB::beginTransaction();
        try {
            $totalHarga = $produk->harga * $validated['quantity'];
            $invoiceNumber = 'INV-' . time() . '-' . auth()->user()->id . '-' . rand(1000, 9999);

            $transaksi = Transaksi::create([
                'id_user' => auth()->user()->id,
                'invoice_number' => $invoiceNumber,
                'total_harga' => $totalHarga,
                'status' => 'pending',
                'metode_pembayaran' => 'transfer',
                'tanggal_transaksi' => now(),
            ]);

            Order::create([
                'id_transaksi' => $transaksi->id,
                'id_produk' => $produk->id,
                'jumlah' => $validated['quantity'],
                'subtotal' => $totalHarga,
            ]);

            // Kurangi stok produk
            $produk->stok -= $validated['quantity'];
            $produk->save();

            DB::commit();

            return redirect()->route('checkout', $transaksi->id)->with('success', 'Checkout berhasil, silakan isi data pengiriman.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal melakukan checkout: ' . $e->getMessage());
        }
    }

    public function checkoutPengirimanData(Request $request)
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validate([
                'id_transaksi' => 'required|integer',
                'id_order' => 'nullable|integer',
                'nama_penerima' => 'required|string|max:250',
                'alamat_penerima' => 'required|string|max:250',
                'telp_penerima' => 'required|string|max:255',
            ]);

            $pengiriman = Pengiriman::create([
                'id_transaksi' => $validatedData['id_transaksi'],
                'id_order' => $validatedData['id_order'] ?? null,
                'nama_penerima' => $validatedData['nama_penerima'],
                'alamat_penerima' => $validatedData['alamat_penerima'],
                'telp_penerima' => $validatedData['telp_penerima'],
                'status_pengiriman' => "pending"
            ]);

            DB::commit();

            return redirect()->route('checkout.third', ['id' => $validatedData['id_transaksi']])
                ->with('success', 'Data pengiriman berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors([
                'error' => 'Gagal menyimpan data pengiriman: ' . $e->getMessage()
            ]);
        }
    }

    public function checkoutBiayaPengiriman(Request $request)
    {
        $validatedData = $request->validate([
            'id_transaksi' => 'required|integer',
            'selected_rate' => 'required|string',
            'id_pengiriman' => 'required|integer',
            'biaya_pengiriman' => 'required|integer',
        ]);
        try {
            DB::beginTransaction();

            $pengiriman = Pengiriman::findOrFail($validatedData['id_pengiriman']);
            $pengiriman->biaya_pengiriman = $validatedData['biaya_pengiriman'];
            $pengiriman->status_pengiriman = 'pending';
            $pengiriman->save();

            DB::commit();

            return redirect()->route('checkout.fourth', ['id' => $validatedData['id_transaksi']])
                ->with('success', 'Data pengiriman berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors([
                'error' => 'Gagal menyimpan data pengiriman: ' . $e->getMessage()
            ]);
        }
    }

    public function checkout(string $id)
    {
        $viewData = [
            'title' => 'Checkout Product | Bhakti E Commerce',
            'snapToken' => null,
            'transaksi' => Transaksi::where('id', $id)
                ->orderBy('created_at', 'desc')
                ->first(),
        ];
        return view('landing-page.checkout.checkout-first', $viewData);
    }

    public function checkoutSecond(string $id)
    {
        $viewData = [
            'title' => 'Checkout Product | Bhakti E Commerce',
            'snapToken' => null,
            'transaksi' => Transaksi::where('id', $id)
                ->orderBy('created_at', 'desc')
                ->first(),
        ];
        return view('landing-page.checkout.checkout-second', $viewData);
    }

    public function checkoutThird(string $id)
    {
        $pengiriman = Pengiriman::where('id_transaksi', $id)
            ->orderBy('created_at', 'desc')
            ->first();
        $viewData = [
            'title' => 'Checkout Product | Bhakti E Commerce',
            'snapToken' => null,
            'transaksi' => Transaksi::where('id', $id)
                ->orderBy('created_at', 'desc')
                ->first(),
            'pengiriman' => $pengiriman,
            'informasiPenerima' => $pengiriman
        ];
        return view('landing-page.checkout.checkout-third', $viewData);
    }

    public function checkoutFourth(string $id)
    {
        $pengiriman = Pengiriman::where('id_transaksi', $id)
            ->orderBy('created_at', 'desc')
            ->first();
        $viewData = [
            'title' => 'Checkout Product | Bhakti E Commerce',
            'snapToken' => null,
            'transaksi' => Transaksi::where('id', $id)
                ->orderBy('created_at', 'desc')
                ->first(),
            'pengiriman' => $pengiriman,
            'informasiPenerima' => $pengiriman
        ];
        return view('landing-page.checkout.checkout-fourth', $viewData);
    }

    public function checkoutStore(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validasi data dari form
            $validated = $request->validate([
                'id_transaksi' => 'required|integer',
                'id_order' => 'required|integer',
                'id_pengiriman' => 'required|integer',
                'total_harga' => 'required|integer',
            ]);

            $pengiriman = Pengiriman::where('id_transaksi', $validated['id_transaksi'])
                ->orderBy('created_at', 'desc')
                ->first();

            // Ambil data transaksi, order, dan pengiriman berdasarkan id
            $transaksi = Transaksi::findOrFail($validated['id_transaksi']);
            $order = Order::findOrFail($validated['id_order']);
            $pengiriman = Pengiriman::findOrFail($validated['id_pengiriman']);

            // Update total_harga transaksi
            $transaksi->total_harga = $validated['total_harga'];
            $transaksi->save();

            DB::commit();

            // Konfigurasi Midtrans
            Config::$serverKey = config('services.midtrans.serverKey');
            Config::$isProduction = config('services.midtrans.isProduction');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $transaksi->invoice_number,
                    'gross_amount' => $transaksi->total_harga,
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                    'phone' => auth()->user()->pelanggan->no_telp ?? '',
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            return view('landing-page.payment-redirect', [
                'title' => 'Pembayaran',
                'snapToken' => $snapToken,
                'transaksi' => $transaksi,
                'pengiriman' => $pengiriman,
                'informasiPenerima' => $pengiriman
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat memproses transaksi: ' . $e->getMessage()]);
        }
    }

    public function midtransCallback(Request $request)
    {
        $serverKey = config('services.midtrans.serverKey');
        $signatureKey = hash(
            'sha512',
            $request->order_id .
                $request->status_code .
                $request->gross_amount .
                $serverKey
        );

        if ($signatureKey !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $transaksi = Transaksi::find($request->order_id);

        if ($request->transaction_status === 'settlement') {
            $transaksi->status = 'paid';
        } elseif ($request->transaction_status === 'pending') {
            $transaksi->status = 'pending';
        } elseif ($request->transaction_status === 'expire') {
            $transaksi->status = 'expired';
        }

        $transaksi->save();

        return redirect()->route('transaction.success', $transaksi->id)
            ->with('success', 'Transaksi berhasil diproses');
    }


    public function transaction_success(string $id)
    {
        $viewData = [
            'title' => 'Transaksi Berhasil | Bhakti E Commerce',
            'transaksi' => Transaksi::find($id) ?: null
        ];
        return view('landing-page.transaction-success', $viewData);
    }
    public function transaction_failed()
    {
        $viewData = [
            'title' => 'Transaksi Gagal | Bhakti E Commerce',
        ];
        return view('landing-page.transaction-failed', $viewData);
    }

    public function getRates(Request $request, BiteshipService $biteship)
    {
        $origin_postal_code = $request->input('origin_postal_code');
        $destination_postal_code = $request->input('destination_postal_code');
        // $couriers = $request->input('couriers', []);
        // $itemId = $request->input('item_id');


        $rates = $biteship->getRates($origin_postal_code, $destination_postal_code);

        return response()->json($rates);
    }
}
