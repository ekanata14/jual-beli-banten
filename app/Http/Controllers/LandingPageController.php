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
}
