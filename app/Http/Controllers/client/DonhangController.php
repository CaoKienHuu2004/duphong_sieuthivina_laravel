<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DonhangController extends Controller
{
    public function thanhtoan()
    {
        return view('client.thanhtoan.thanhtoan');
    }
}
