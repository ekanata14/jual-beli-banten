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

            $validatedData['id_user'] = auth()->user()->id;
            // Menggunakan model Keranjang
            $cartItem = Keranjang::where([
                ['id_produk', '=', $validatedData['product_id']],
                ['id_user', '=', $validatedData['id_user']],
            ])->first();

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

            $transaksi = new Transaksi();
            $transaksi->id_user = auth()->user()->id;
            $transaksi->total_harga = $totalHarga;
            $transaksi->status = 'pending';
            $transaksi->metode_pembayaran = 'transfer';
            $transaksi->tanggal_transaksi = now();
            $transaksi->save();

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

    public function checkoutPengirimanData(Request $request)
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validate([
                'id_transaksi' => 'required|integer|exists:tabel_transaksi,id',
                'id_order' => 'nullable|integer|exists:tabel_order,id',
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

    public function checkoutThird()
    {
        $informasiPenerima = [
            'penerima_nama' => request()->input('penerima_nama'),
            'penerima_no_telp' => request()->input('penerima_no_telp'),
            'penerima_alamat' => request()->input('penerima_alamat'),
            'penerima_kota' => request()->input('penerima_kota'),
            'penerima_kode_pos' => request()->input('penerima_kode_pos'),
            'penerima_kabupaten' => request()->input('penerima_kabupaten')
        ];
        $viewData = [
            'title' => 'Checkout Product | Bhakti E Commerce',
            'snapToken' => null,
            'product' => Produk::find(1) ?: null,
            'informasiAnda' => $informasiAnda,
            'informasiPenerima' => $informasiPenerima
        ];
        return view('landing-page.checkout.checkout-third', $viewData);
    }

    public function checkoutFourth()
    {
        $viewData = [
            'title' => 'Checkout Product | Bhakti E Commerce',
            'snapToken' => null,
            'product' => Produk::find(1) ?: null
        ];
        return view('landing-page.checkout.checkout-fourth', $viewData);
    }

    public function checkoutStore(Request $request)
    {
        $product = Produk::find(request()->query('id')) ?: null;
        try {
            DB::beginTransaction();

            // Validasi data request sesuai data dari UI
            $validated = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'no_telp' => 'required|string',
                'penerima_nama' => 'required|string',
                'penerima_no_telp' => 'required|string',
                'penerima_alamat' => 'required|string',
                'penerima_kota' => 'required|string',
                'penerima_kabupaten' => 'required|string',
                'products' => 'required|array',
                'products.*.id' => 'required|integer',
                'products.*.qty' => 'required|integer',
                'total' => 'required|numeric',
            ]);
            // 1. Simpan transaksi (anggap pelanggan guest, atau buat user jika perlu)
            $transaksi = new Transaksi;
            $transaksi->id_user = auth()->user()->id;
            $transaksi->total_harga = $validated['total'];
            $transaksi->status = 'pending';
            $transaksi->metode_pembayaran = "transfer";
            $transaksi->tanggal_transaksi = now();
            $transaksi->save();

            $orders = [];
            foreach ($validated['products'] as $product) {
                $produk = Produk::find($product['id']);
                $order = new Order;
                $order->id_transaksi = $transaksi->id;
                $order->id_produk = $product['id'];
                $order->jumlah = $product['qty'];
                $order->subtotal = $produk ? $produk->harga * $product['qty'] : 0;
                $order->save();
                $orders[] = $order;
            }
            // 3. Simpan pengiriman (gunakan order pertama)
            $pengiriman = new Pengiriman();
            $pengiriman->id_transaksi = $transaksi->id;
            $pengiriman->id_order = $orders[0]->id ?? null;
            $pengiriman->id_kurir = null;
            $pengiriman->no_resi = "0198230123";
            $pengiriman->nama_penerima = $validated['penerima_nama'];
            $pengiriman->alamat_penerima = $validated['penerima_alamat'];
            $pengiriman->telp_penerima = $validated['penerima_no_telp'];
            $pengiriman->status_pengiriman = 'pending';
            $pengiriman->waktu_pengiriman = null;
            $pengiriman->biaya_pengiriman = null;
            $pengiriman->save();

            DB::commit();

            // Konfigurasi Midtrans
            Config::$serverKey = config('services.midtrans.serverKey');
            Config::$isProduction = config('services.midtrans.isProduction');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $biayaPengiriman = $pengiriman->biaya_pengiriman ?? 0;

            $params = [
                'transaction_details' => [
                    'order_id' => 'TRX-' . $transaksi->id,
                    'gross_amount' => $transaksi->total_harga + $biayaPengiriman,
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                    'phone' => auth()->user()->pelanggan->no_telp ?? $validated['no_telp'],
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            return view('landing-page.checkout', [
                'title' => 'Pembayaran',
                'snapToken' => $snapToken,
                'product' => $product,
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

        $orderId = str_replace('TRX-', '', $request->order_id);
        $transaksi = Transaksi::find($orderId);

        if ($request->transaction_status === 'settlement') {
            $transaksi->status = 'paid';
        } elseif ($request->transaction_status === 'pending') {
            $transaksi->status = 'pending';
        } elseif ($request->transaction_status === 'expire') {
            $transaksi->status = 'expired';
        }

        $transaksi->save();

        return response()->json(['message' => 'Notification received']);
    }


    public function transaction_success()
    {
        $viewData = [
            'title' => 'Transaksi Berhasil | Bhakti E Commerce',
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
