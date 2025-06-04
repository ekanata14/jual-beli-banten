<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $viewData = [
            "title" => "Dashboard Pelanggan",
        ];

        return view("pelanggan.dashboard", $viewData);
    }
}
