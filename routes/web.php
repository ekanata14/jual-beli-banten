<?php
// Auth Controller
use App\Http\Controllers\AuthController;

// Admin Controller
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AdminController as AdminAdminController;

// Penjual Controller
use App\Http\Controllers\Penjual\DashboardController as PenjualDashboardController;
use App\Http\Controllers\Admin\PenjualController as AdminPenjualController;
use App\Http\Controllers\Admin\PelangganController as AdminPelangganController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\KurirController as AdminKurirController;
use App\Http\Controllers\Admin\MetodePembayaranController as AdminMetodePembayaranController;
use App\Http\Controllers\Admin\TransaksiController as AdminTransaksiController;

// Pelanggan Controller
use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboardController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::get('/about', [LandingPageController::class, 'about'])->name('about');
Route::get('/product', [LandingPageController::class, 'product'])->name('product');
Route::get('/product/search', [LandingPageController::class, 'productSearch'])->name('product.search');
Route::get('/product/search/category/{category}', [LandingPageController::class, 'productSearch'])->name('product.find.category');
Route::get('/product/sort/atoz', [LandingPageController::class, 'productAtoZ'])->name('product.sort.atoz');
Route::get('/product/sort/price-highest', [LandingPageController::class, 'productHighestPrice'])->name('product.sort.price_highest');
Route::get('/product/sort/price-lowest', [LandingPageController::class, 'productLowestPrice'])->name('product.sort.price_lowest');
Route::get('/product/detail', [LandingPageController::class, 'productDetail'])->name('product.detail');

Route::get('/forgot-password', [LandingPageController::class, 'forgotPassword'])->name('forgot.password');
Route::post('/forgot-password/find/email', [LandingPageController::class, 'forgotPasswordFindEmail'])->name('forgot.password.find.email');
Route::get('/forgot-password/change/password/{id}', [LandingPageController::class, 'forgotPasswordChangePassword'])->name('forgot.password.change.password');
Route::post('/forgot-password/store', [LandingPageController::class, 'forgotPasswordStore'])->name('forgot.password.store');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile/user', [LandingPageController::class, 'profileUser'])->name('profile.user');
    Route::post('/profile/user/update', [LandingPageController::class, 'profileUserUpdate'])->name('profile.user.update');

    Route::get('/cart', [LandingPageController::class, 'cart'])->name('cart');
    Route::post('/cart/add', [LandingPageController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update', [LandingPageController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove', [LandingPageController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/detail/detail-transaction', [LandingPageController::class, 'detail_transaction'])->name('detail_transaction');
    // Route::get('/checkout', [LandingPageController::class, 'checkout'])->name('checkout.third');

    Route::post('/checkout/store', [LandingPageController::class, 'checkoutStore'])->name('checkout.store');
    Route::get('/transaction/failed', [LandingPageController::class, 'transaction_failed'])->name('transaction_failed');

    // Checkout Step
    Route::get('/checkout/{id}', [LandingPageController::class, 'checkout'])->name('checkout');
    Route::get('/checkout/second/{id}', [LandingPageController::class, 'checkoutSecond'])->name('checkout.second');
    Route::get('/checkout/third/{id}', [LandingPageController::class, 'checkoutThird'])->name('checkout.third');
    Route::get('/checkout/fourth/{id}', [LandingPageController::class, 'checkoutFourth'])->name('checkout.fourth');
    Route::get('/transaction/success/{id}', [LandingPageController::class, 'transaction_success'])->name('transaction.success');

    // Cart Checkout
    Route::post('/cart/checkout', [LandingPageController::class, 'checkoutItem'])->name('cart.checkout');
    Route::post('/cart/checkout/direct', [LandingPageController::class, 'checkoutDirect'])->name('cart.checkout.direct');
    Route::post('/cart/checkout/data', [LandingPageController::class, 'checkoutPengirimanData'])->name('cart.checkout.pengiriman.data');
    Route::post('/cart/checkout/biaya-pengiriman', [LandingPageController::class, 'checkoutBiayaPengiriman'])->name('cart.checkout.biaya.pengiriman');

    Route::post('/checkout/snap', [LandingPageController::class, 'getSnapToken'])->name('checkout.snap');
    Route::post('/checkout/callback', [LandingPageController::class, 'midtransCallback'])->name('checkout.callback');

    Route::get('/ongkir', [LandingPageController::class, 'getShippingOptions'])->name('ongkir');

    // Route for searchAreas
    Route::get('/search-areas', [LandingPageController::class, 'searchAreas'])->name('search.areas');

    // Route for searchAreas
    Route::get('/couriers', [LandingPageController::class, 'listCouriers'])->name('couriers');
    Route::post('/rates', [LandingPageController::class, 'getRates'])->name('rates');

    // Route for History
    Route::get('/history', [LandingPageController::class, 'history'])->name('history');
    Route::get('/history/detail/{id}', [LandingPageController::class, 'historyDetail'])->name('history.detail');
    Route::get('/history/detail/biteship/order/shpping/{id}', [LandingPageController::class, 'getBiteshipOrderById'])->name('history.detail.order.shipping');

    // Confirm Shipment
    Route::post('/confirm-shipment', [LandingPageController::class, 'confirmShipment'])->name('confirm.shipment');

    // Rating
    Route::post('/rating/store', [LandingPageController::class, 'storeRating'])->name('rating.store');
});


// Authentication Routes
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/profile', [ProfileController::class, 'index'])->name('index');
// Route::middleware('auth')->group(function () {    
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::middleware('redirectIfAuthenticated')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});


Route::middleware('authCheck')->group(function () {
    // Profile Controller
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Dashboard Controller
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Admin Admin Controller
    Route::get('/dashboard/admin', [AdminAdminController::class, 'index'])->name('admin.admin.index');
    Route::get('/dashboard/admin/create', [AdminAdminController::class, 'create'])->name('admin.admin.create');
    Route::get('/dashboard/admin/edit/{id}', [AdminAdminController::class, 'edit'])->name('admin.admin.edit');
    Route::post('/dashboard/admin/store', [AdminAdminController::class, 'store'])->name('admin.admin.store');
    Route::put('/dashboard/admin/update', [AdminAdminController::class, 'update'])->name('admin.admin.update');
    Route::delete('/dashboard/admin/delete', [AdminAdminController::class, 'destroy'])->name('admin.admin.destroy');

    // Admin Penjual Controller
    Route::get('/dashboard/penjual', [AdminPenjualController::class, 'index'])->name('admin.penjual.index');
    Route::get('/dashboard/penjual/create', [AdminPenjualController::class, 'create'])->name('admin.penjual.create');
    Route::get('/dashboard/penjual/edit/{id}', [AdminPenjualController::class, 'edit'])->name('admin.penjual.edit');
    Route::post('/dashboard/penjual/store', [AdminPenjualController::class, 'store'])->name('admin.penjual.store');
    Route::put('/dashboard/penjual/update', [AdminPenjualController::class, 'update'])->name('admin.penjual.update');
    Route::delete('/dashboard/penjual/delete', [AdminPenjualController::class, 'destroy'])->name('admin.penjual.destroy');

    // Admin Pelanggan Controller
    Route::get('/dashboard/pelanggan', [AdminPelangganController::class, 'index'])->name('admin.pelanggan.index');
    Route::get('/dashboard/pelanggan/transaksi/detail/{id}', [AdminPelangganController::class, 'transaksiPelanggan'])->name('admin.pelanggan.transaksi.detail');
    Route::get('/dashboard/pelanggan/transaksi/detail/show/{id}', [AdminPelangganController::class, 'transaksiPelangganDetail'])->name('admin.pelanggan.transaksi.detail.show');
    Route::get('/dashboard/pelanggan/create', [AdminPelangganController::class, 'create'])->name('admin.pelanggan.create');
    Route::get('/dashboard/pelanggan/edit/{id}', [AdminPelangganController::class, 'edit'])->name('admin.pelanggan.edit');
    Route::post('/dashboard/pelanggan/store', [AdminPelangganController::class, 'store'])->name('admin.pelanggan.store');
    Route::put('/dashboard/pelanggan/update', [AdminPelangganController::class, 'update'])->name('admin.pelanggan.update');
    Route::delete('/dashboard/pelanggan/delete', [AdminPelangganController::class, 'destroy'])->name('admin.pelanggan.destroy');

    // Admin Produk Controller
    Route::get('/dashboard/produk', [AdminProductController::class, 'index'])->name('admin.produk.index');
    Route::get('/dashboard/produk/create', [AdminProductController::class, 'create'])->name('admin.produk.create');
    Route::get('/dashboard/produk/penjual/{id}', [AdminProductController::class, 'show'])->name('admin.produk.detail');
    Route::get('/dashboard/produk/edit/{id}', [AdminProductController::class, 'edit'])->name('admin.produk.edit');
    Route::post('/dashboard/produk/store', [AdminProductController::class, 'store'])->name('admin.produk.store');
    Route::put('/dashboard/produk/update', [AdminProductController::class, 'update'])->name('admin.produk.update');
    Route::delete('/dashboard/produk/delete', [AdminProductController::class, 'destroy'])->name('admin.produk.destroy');

    // Admin Kurir Controller
    Route::get('/dashboard/kurir', [AdminKurirController::class, 'index'])->name('admin.kurir.index');
    Route::get('/dashboard/kurir/create', [AdminKurirController::class, 'create'])->name('admin.kurir.create');
    Route::get('/dashboard/kurir/edit/{id}', [AdminKurirController::class, 'edit'])->name('admin.kurir.edit');
    Route::post('/dashboard/kurir/store', [AdminKurirController::class, 'store'])->name('admin.kurir.store');
    Route::put('/dashboard/kurir/update', [AdminKurirController::class, 'update'])->name('admin.kurir.update');
    Route::delete('/dashboard/kurir/delete', [AdminKurirController::class, 'destroy'])->name('admin.kurir.destroy');

    // Admin Metode Pembayaran Controller
    Route::get('/dashboard/metode-pembayaran', [AdminMetodePembayaranController::class, 'index'])->name('admin.metode-pembayaran.index');
    Route::get('/dashboard/metode-pembayaran/create', [AdminMetodePembayaranController::class, 'create'])->name('admin.metode-pembayaran.create');
    Route::get('/dashboard/metode-pembayaran/edit/{id}', [AdminMetodePembayaranController::class, 'edit'])->name('admin.metode-pembayaran.edit');
    Route::post('/dashboard/metode-pembayaran/store', [AdminMetodePembayaranController::class, 'store'])->name('admin.metode-pembayaran.store');
    Route::put('/dashboard/metode-pembayaran/update', [AdminMetodePembayaranController::class, 'update'])->name('admin.metode-pembayaran.update');
    Route::delete('/dashboard/metode-pembayaran/delete', [AdminMetodePembayaranController::class, 'destroy'])->name('admin.metode-pembayaran.destroy');

    // Admin Transaksi Controller
    Route::get('/dashboard/transaksi', [AdminTransaksiController::class, 'index'])->name('admin.transaksi.index');
    Route::get('/dashboard/transaksi/detail/{id}', [AdminTransaksiController::class, 'show'])->name('admin.transaksi.detail');
    // Penjual Dashboard Controller
    Route::get('/penjual-dashboard', [PenjualDashboardController::class, 'index'])->name('penjual.dashboard');

    // Pelanggan Dashboard Controller
    Route::get('/pelanggan-dashboard', [PelangganDashboardController::class, 'index'])->name('pelanggan.dashboard');
});

require __DIR__ . '/auth.php';
