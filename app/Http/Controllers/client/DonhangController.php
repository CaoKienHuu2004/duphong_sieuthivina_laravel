<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DonhangController extends Controller
{
    public function donhangcuatoi()
    {
        return view('client.nguoidung.donhang');
    }
}
