<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Midtrans
use Midtrans\Snap;
use Midtrans\Config;

// Biteship
use App\Services\BiteshipService;

// Models
use App\Models\User;
use App\Models\Transaksi;
use App\Models\Pengiriman;
use App\Models\Order;
use App\Models\Produk;
use App\Models\Keranjang;
use App\Models\Kurir;
use App\Models\Ulasan;

use Illuminate\Support\Facades\Log;

class LandingPageController extends Controller
{
    protected $categories;

    public function __construct()
    {
        // You can share categories to all views if needed
        $this->categories = Produk::select('kategori')->distinct()->pluck('kategori');
    }
    public function index()
    {
        $viewData = [
            'title' => 'Beranda | Bhakti E Commerce',
            'activePage' => '/',
            'products' => Produk::orderBy('created_at', 'desc')
                ->take(4)
                ->get(),
            'ulasans' => Ulasan::with('produk')->take(10)->get()
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
            'title' => 'Produk | Bhakti E Commerce',
            'activePage' => 'product',
            'products' => Produk::orderBy('created_at', 'desc')
                ->paginate(10),
            'categories' => $this->categories
        ];
        return view('landing-page.product', $viewData);
    }

    public function productSearch(Request $request)
    {
        $search = $request->query('search', '');
        $viewData = [
            'title' => 'Pencarian | Bhakti E Commerce',
            'activePage' => 'product',
            'products' => Produk::where('nama_produk', 'like', '%' . $search . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(10),
            'search' => $search,
            'categories' => $this->categories
        ];
        return view('landing-page.product', $viewData);
    }

    public function productFindByCategory(string $category)
    {
        $viewData = [
            'title' => 'Produk Kategori: ' . $category . ' | Bhakti E Commerce',
            'activePage' => 'product',
            'products' => Produk::where('kategori', $category)
                ->orderBy('created_at', 'desc')
                ->paginate(10),
            'categories' => $this->categories
        ];
        return view('landing-page.product', $viewData);
    }

    public function productAtoZ(Request $request)
    {
        $search = $request->query('search', '');
        $viewData = [
            'title' => 'Produk A-Z | Bhakti E Commerce',
            'activePage' => 'product',
            'products' => Produk::where('nama_produk', 'like', '%' . $search . '%')
                ->orderBy('nama_produk', 'asc')
                ->paginate(10),
            'search' => $search,
            'categories' => $this->categories
        ];
        return view('landing-page.product', $viewData);
    }

    // Produk dengan harga terendah
    public function productLowestPrice(Request $request)
    {
        $search = $request->query('search', '');
        $viewData = [
            'title' => 'Produk Harga Terendah | Bhakti E Commerce',
            'activePage' => 'product',
            'products' => Produk::where('nama_produk', 'like', '%' . $search . '%')
                ->orderBy('harga', 'asc')
                ->paginate(10),
            'search' => $search,
            'categories' => $this->categories
        ];
        return view('landing-page.product', $viewData);
    }

    // Produk dengan harga tertinggi
    public function productHighestPrice(Request $request)
    {
        $search = $request->query('search', '');
        $viewData = [
            'title' => 'Produk Harga Tertinggi | Bhakti E Commerce',
            'activePage' => 'product',
            'products' => Produk::where('nama_produk', 'like', '%' . $search . '%')
                ->orderBy('harga', 'desc')
                ->paginate(10),
            'search' => $search,
            'categories' => $this->categories
        ];
        return view('landing-page.product', $viewData);
    }

    public function productDetail()
    {
        $viewData = [
            'title' => 'Produk Detail | Bhakti E Commerce',
            'activePage' => 'product/product_detail',
            'product' => Produk::find(request()->query('id')) ?: null,
            'relatedProducts' => Produk::where('id', '!=', request()->query('id'))
                ->where('kategori', optional(Produk::find(request()->query('id')))->kategori)
                ->orderBy('created_at', 'desc')
                ->take(4)
                ->get()
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
        $transaksi = Transaksi::where('id', $id)
            ->orderBy('created_at', 'desc')
            ->first();
        $order = Order::where('id_transaksi', $transaksi->id)->first();
        $viewData = [
            'title' => 'Checkout Product | Bhakti E Commerce',
            'snapToken' => null,
            'transaksi' => $transaksi,
            'product' => $order->Produk
        ];
        return view('landing-page.checkout.checkout-second', $viewData);
    }

    public function checkoutThird(string $id)
    {
        $pengiriman = Pengiriman::where('id_transaksi', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        $viewData = [
            'title' => 'Checkout Product | Bhakti E Commerce',
            'snapToken' => null,
            'transaksi' => Transaksi::where('id', $id)
                ->orderBy('created_at', 'desc')
                ->first(),
            'pengiriman' => $pengiriman,
            'product' => Pengiriman::where('id_transaksi', $id)
                ->orderBy('created_at', 'desc')
                ->first()->order->Produk,
            'informasiPenerima' => $pengiriman
        ];
        return view('landing-page.checkout.checkout-third', $viewData);
    }

    public function checkoutFourth(string $id)
    {
        $transaksi = Transaksi::where('id', $id)
            ->orderBy('created_at', 'desc')
            ->first();

        $pengiriman = Pengiriman::where('id_transaksi', $transaksi->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $viewData = [
            'title' => 'Checkout Product | Bhakti E Commerce',
            'snapToken' => null,
            'transaksi' => $transaksi,
            'pengiriman' => $pengiriman,
            'informasiPenerima' => $pengiriman
        ];
        // return $viewData;
        return view('landing-page.checkout.checkout-fourth', $viewData);
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
                'latitude_penerima' => 'nullable|string|max:250',
                'longitude_penerima' => 'nullable|string|max:250',
                'kode_pos_penerima' => 'nullable|string|max:20',
                'telp_penerima' => 'required|string|max:255',
            ]);

            $order = Order::where('id_transaksi', $validatedData['id_transaksi'])
                ->orderBy('created_at', 'desc')
                ->get();

            foreach ($order as $item) {
                $pengiriman = Pengiriman::where('id_transaksi', $validatedData['id_transaksi'])
                    ->where('id_penjual', $item->Produk->user->id)
                    ->first();
                if (!$pengiriman) {
                    $penjual = $item->Produk->user;
                    $pengirimanCreate = Pengiriman::create([
                        'id_transaksi' => $validatedData['id_transaksi'],
                        'id_order' => $validatedData['id_order'] ?? null,
                        'nama_penerima' => $validatedData['nama_penerima'],
                        'alamat_penerima' => $validatedData['alamat_penerima'],
                        'latitude_penerima' => $validatedData['latitude_penerima'] ?? null,
                        'longitude_penerima' => $validatedData['longitude_penerima'] ?? null,
                        'kode_pos_penerima' => $validatedData['kode_pos_penerima'] ?? null,
                        'telp_penerima' => $validatedData['telp_penerima'],
                        'status_pengiriman' => "pending",
                        // Penjual fields
                        'id_penjual' => $penjual->id,
                        'alamat_penjual' => $penjual->Penjual->alamat_penjual ?? null,
                        'latitude_penjual' => $penjual->Penjual->latitude ?? null,
                        'longitude_penjual' => $penjual->Penjual->longitude ?? null,
                        'kode_pos_penjual' => $penjual->Penjual->kode_pos ?? null,
                        'telp_penjual' => $penjual->Penjual->no_telp ?? null,
                    ]);

                    $item->id_pengiriman = $pengirimanCreate->id;
                    $item->save();
                } else {
                    $item->id_pengiriman = $pengiriman->id;
                    $item->save();
                }
            }

            DB::commit();

            return redirect()->route('checkout.third', ['id' => $validatedData['id_transaksi']])
                ->with('success', 'Data pengiriman berhasil disimpan');
        } catch (\Exception $e) {
            return $e->getMessage();
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors([
                'error' => 'Gagal menyimpan data pengiriman: ' . $e->getMessage()
            ]);
        }
    }

    public function checkoutBiayaPengiriman(Request $request)
    {
        $request->merge([
            'id_pengiriman' => (array) $request->input('id_pengiriman'),
            'selected_rate' => (array) $request->input('selected_rate'),
        ]);
        $validatedData = $request->validate([
            'id_transaksi' => 'required|integer',
            'id_pengiriman' => 'required|array',
            'selected_rate' => 'required|array',
        ]);
        // Convert selected_rate JSON strings to array of objects
        $selectedRates = array_map(function ($item) {
            return is_array($item) ? $item : json_decode($item, true);
        }, $validatedData['selected_rate']);

        $validatedData['selected_rate'] = $selectedRates;

        $pengirimans = Pengiriman::whereIn('id', $validatedData['id_pengiriman'])
            ->where('id_transaksi', $validatedData['id_transaksi'])
            ->get();
        try {
            DB::beginTransaction();

            $totalBiayaPengiriman = 0;
            $pengirimanDataArray = [];

            foreach ($pengirimans as $index => $pengiriman) {
                if (!$pengiriman) {
                    DB::rollBack();
                    return redirect()->back()->withInput()->withErrors([
                        'error' => "Pengiriman tidak ditemukan."
                    ]);
                }

                $pengirimanId = $pengiriman->id;
                $selectedRate = $validatedData['selected_rate'][$index] ?? null;

                if (!$selectedRate) {
                    DB::rollBack();
                    return redirect()->back()->withInput()->withErrors([
                        'error' => "Data kurir tidak ditemukan untuk pengiriman ID: {$pengirimanId}"
                    ]);
                }

                $biayaPengiriman = $selectedRate['price'] ?? null;

                if (!$biayaPengiriman) {
                    DB::rollBack();
                    return redirect()->back()->withInput()->withErrors([
                        'error' => "Data pengiriman tidak lengkap untuk pengiriman ID: {$pengirimanId}"
                    ]);
                }

                // Insert Kurir data only if not exists
                $kurir = Kurir::firstOrCreate(
                    [
                        'kode_kurir' => $selectedRate['courier_code'] ?? '',
                        'kode_servis' => $selectedRate['courier_service_code'] ?? '',
                    ],
                    [
                        'nama_kurir' => $selectedRate['courier_name'] ?? '',
                        'nama_servis' => $selectedRate['courier_service_name'] ?? '',
                        'rentan_durasi' => $selectedRate['shipment_duration_range'] ?? '',
                        'unit_durasi' => $selectedRate['shipment_duration_unit'] ?? '',
                    ]
                );

                $pengiriman->update([
                    'biaya_pengiriman' => (int)$biayaPengiriman,
                    'status_pengiriman' => 'pending',
                    'id_kurir' => $kurir->id,
                    'waktu_pengiriman' => $selectedRate['duration'] ?? null,
                ]);

                $totalBiayaPengiriman += (int)$biayaPengiriman;

                $pengirimanDataArray[] = [
                    'pengiriman_id' => $pengirimanId,
                    'biaya_pengiriman' => $biayaPengiriman,
                    'selected_rate' => $selectedRate,
                    'kurir' => $kurir,
                ];
            }

            // Update transaksi.total_harga (add total biaya pengiriman)
            $transaksi = Transaksi::find($validatedData['id_transaksi']);
            if ($transaksi) {
                $transaksi->total_harga += $totalBiayaPengiriman;
                $transaksi->save();
            }

            DB::commit();
            return redirect()->route('checkout.fourth', ['id' => $validatedData['id_transaksi']])
                ->with('success', 'Data pengiriman berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan data pengiriman: ' . $e->getMessage());
        }
    }



    public function checkoutStore(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validasi data dari form
            $validated = $request->validate([
                'id_transaksi' => 'required|integer',
                'id_order' => 'required|integer',
                'id_pengiriman' => 'required|array',
                'total_harga' => 'required|integer',
            ]);

            // Ambil data transaksi dan order berdasarkan id
            $transaksi = Transaksi::findOrFail($validated['id_transaksi']);
            $order = Order::findOrFail($validated['id_order']);

            // Ambil semua pengiriman berdasarkan array id_pengiriman
            $pengiriman = Pengiriman::whereIn('id', $validated['id_pengiriman'])->get();

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

    public function midtransCallback(Request $request, BiteshipService $biteship)
    {
        Log::info('Midtrans Callback Request:', $request->all());
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

        $biteship->orderCourier($transaksi->id);

        return redirect()->route('transaction.success', $transaksi->id)
            ->with('success', 'Transaksi berhasil diproses');
    }

    public function midtransCallbackAPI(Request $request,  BiteshipService $biteship)
    {
        try {
            Log::info('Midtrans Callback Request:', $request->all());
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

            $transaksi = Transaksi::where('invoice_number', $request->order_id)->first();

            if (!$transaksi) {
                return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
            }

            if ($request->transaction_status === 'settlement') {
                $transaksi->status = 'paid';
            } elseif ($request->transaction_status === 'pending') {
                $transaksi->status = 'pending';
            } elseif ($request->transaction_status === 'expire') {
                $transaksi->status = 'expired';
            }

            $transaksi->save();

            $biteship->orderCourier($transaksi->id);

            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'Transaksi berhasil diproses',
                'transaksi' => $transaksi
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans Callback Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'code' => 500,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getBiteshipOrderById(string $id, BiteshipService $biteship)
    {
        $orderId = $id;
        if (!$orderId) {
            return response()->json(['error' => 'Order ID is required'], 400);
        }

        try {
            $order = $biteship->getOrderById($orderId);
            return response()->json($order);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve order: ' . $e->getMessage()], 500);
        }
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
        // Get origin latitude and longitude from request
        $origin_latitude = $request->input('origin_latitude');
        $origin_longitude = $request->input('origin_longitude');
        // Get destination latitude and longitude from request input
        $destination_latitude = $request->input('destination_latitude');
        $destination_longitude = $request->input('destination_longitude');

        if (is_null($origin_latitude) || is_null($origin_longitude) || is_null($destination_latitude) || is_null($destination_longitude)) {
            return response()->json(['error' => 'Latitude and longitude are required.'], 400);
        }

        $rates = $biteship->getRatesByCoordinates(
            $origin_latitude,
            $origin_longitude,
            $destination_latitude,
            $destination_longitude
        );

        return response()->json($rates);
    }

    public function confirmShipment(Request $request)
    {
        DB::beginTransaction();
        try {
            $pengiriman = Pengiriman::find($request->id);
            if (!$pengiriman) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Pengiriman tidak ditemukan.');
            }

            $pengiriman->status_pengiriman = 'received';
            $pengiriman->save();

            DB::commit();
            return back()->with('success', 'Pengiriman berhasil dikonfirmasi.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengkonfirmasi pengiriman: ' . $e->getMessage());
        }
    }

    public function storeRating(Request $request)
    {
        $validated = $request->validate([
            'id_transaksi' => 'required|integer',
            'id_produk' => 'required|integer',
            'id_order' => 'required|integer',
            'deskripsi_ulasan' => 'nullable|string|max:500',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        try {
            DB::beginTransaction();

            $transaksi = Transaksi::find($validated['id_transaksi']);
            if (!$transaksi) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
            }

            $produk = Produk::find($validated['id_produk']);
            if (!$produk) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Produk tidak ditemukan.');
            }

            $order = Order::find($validated['id_order']);
            if (!$order) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Order tidak ditemukan.');
            }

            // Cek apakah user sudah pernah memberi ulasan untuk produk ini di transaksi dan order ini
            $existingUlasan = Ulasan::where('id_transaksi', $validated['id_transaksi'])
                ->where('id_produk', $validated['id_produk'])
                ->where('id_order', $validated['id_order'])
                ->where('id_user', auth()->user()->id)
                ->first();

            if ($existingUlasan) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Anda sudah memberikan ulasan untuk produk ini.');
            }

            Ulasan::create([
                'id_transaksi' => $validated['id_transaksi'],
                'id_produk' => $validated['id_produk'],
                'id_order' => $validated['id_order'],
                'id_user' => auth()->user()->id,
                'deskripsi_ulasan' => $validated['deskripsi_ulasan'],
                'rating' => $validated['rating'],
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Ulasan berhasil dikirim.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mengirim ulasan: ' . $e->getMessage());
        }
    }

    public function forgotPassword()
    {
        $viewData = [
            'title' => 'Lupa Password | Bhakti E Commerce',
            'activePage' => 'forgot-password',
        ];
        return view('auth.forgot-password.index', $viewData);
    }

    public function forgotPasswordFindEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan.');
        }
        // Redirect to the change password page route
        return redirect()->route('forgot.password.change.password', $user->id);
    }

    public function forgotPasswordChangePassword(string $Id)
    {
        $user = User::find($Id);
        // Redirect to the change password page
        return view('auth.forgot-password.change', [
            'title' => 'Ubah Password | Bhakti E Commerce',
            'activePage' => 'forgot-password',
            'email' => $user->email,
        ]);
    }

    public function forgotPasswordStore(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan.');
        }

        // Update the user's password
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan masuk dengan password baru Anda.');
    }
}
