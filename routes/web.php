<?php


use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::get('/about', [LandingPageController::class, 'about'])->name('about');
Route::get('/product', [LandingPageController::class, 'product'])->name('product');
Route::get('/product/product_detail', [LandingPageController::class, 'productDetail'])->name('productDetail');
Route::get('/cart', [LandingPageController::class, 'cart'])->name('cart');
Route::get('/detail/detail_transaction', [LandingPageController::class, 'detail_transaction'])->name('detail_transaction');
Route::get('/checkout', [LandingPageController::class, 'checkout'])->name('checkout');
Route::get('/transaction_success', [LandingPageController::class, 'transaction_success'])->name('transaction_success');
Route::get('/transaction_failed', [LandingPageController::class, 'transaction_failed'])->name('transaction_failed');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
