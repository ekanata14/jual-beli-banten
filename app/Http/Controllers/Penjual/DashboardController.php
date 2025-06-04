<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $viewData = [
            "title" => "Dashboard Penjual",
        ];

        return view("penjual.dashboard", $viewData);
    }
}
