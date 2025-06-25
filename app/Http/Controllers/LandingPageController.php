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
            'activePage' => 'product'
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
            'activePage' => 'cart'
        ];
        return view('landing-page.cart', $viewData);
    }
    public function detail_transaction()
    {
        $viewData = [
            'title' => 'Detail Transaksi | Bhakti E Commerce',
        ];
        return view('landing-page.detail-transaction', $viewData);
    }
    public function checkout()
    {
        $viewData = [
            'title' => 'Checkout Product | Bhakti E Commerce',
            'product' => Produk::find(request()->query('id')) ?: null
        ];
        return view('landing-page.checkout', $viewData);
    }

    public function checkoutStore(Request $request)
    {
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

            return view('landing-page.payment-redirect', [
                'title' => 'Pembayaran',
                'snapToken' => $snapToken,
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


    public function getShippingOptions(Request $request, BiteshipService $biteship)
    {
        $postalCode = $request->input('kode_pos');
        $costs = $biteship->getCouriers($postalCode);

        return response()->json($costs);
    }
}
