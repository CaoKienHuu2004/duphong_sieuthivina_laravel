<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class NguoidungController extends Controller
{
    public function login(){
        return view('client.nguoidung.login');
    }
}
