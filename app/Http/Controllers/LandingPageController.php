<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index(){
        $viewData = [
            'title' => 'Beranda | Bhakti E Commerce',
            'activePage' => '/'
        ];
        return view('landing-page.home',$viewData);
    }
    public function about(){
        $viewData = [
            'title' => 'Tentang Kami | Bhakti E Commerce',
            'activePage' => 'about'
        ];
        return view('landing-page.about',$viewData);
    }
    public function product(){
        $viewData = [
            'title' => 'Tentang Kami | Bhakti E Commerce',
            'activePage' => 'product'
        ];
        return view('landing-page.product',$viewData);
    }
    public function productDetail(){
        $viewData = [
            'title' => 'Produk Detail | Bhakti E Commerce',
            'activePage' => 'product/product_detail'
        ];
        return view('landing-page.productDetail',$viewData);
    }
    public function cart(){
        $viewData = [
            'title' => 'Keranjang Belanja | Bhakti E Commerce',
            'activePage' => 'cart'
        ];
        return view('landing-page.cart',$viewData);
    }
    public function detail_transaction(){
        $viewData = [
            'title' => 'Detail Transaksi | Bhakti E Commerce',
            'activePage' => 'detail'
        ];
        return view('landing-page.detail-transaction',$viewData);
    }
    public function checkout(){
        $viewData = [
            'title' => 'Checkout Product | Bhakti E Commerce',
            'activePage' => 'checkout'
        ];
        return view('landing-page.checkout',$viewData);
    }
    public function transaction_success(){
        $viewData = [
            'title' => 'Transaksi Berhasil | Bhakti E Commerce',
            'activePage' => 'checkout'
        ];
        return view('landing-page.transaction-success',$viewData);
    }
    public function transaction_failed(){
        $viewData = [
            'title' => 'Transaksi Gagal | Bhakti E Commerce',
            'activePage' => 'checkout'
        ];
        return view('landing-page.transaction-failed',$viewData);
    }
}
