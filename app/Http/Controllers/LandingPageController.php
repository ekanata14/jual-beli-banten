<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index(){
        $viewData = [
            'title' => 'Beranda | Bhakti E Commerce',
            'activePage' => 'beranda'
        ];
        return view('landing-page.home',$viewData);
    }
}
