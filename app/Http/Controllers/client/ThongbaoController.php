<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\ThongbaoModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ThongbaoController extends Controller
{
    // show danh sách thông báo
    public function index()
    {
        return view('client.nguoidung.thongbao');
    }
    
}
