<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaivietController extends Controller
{
    public function index()
    {
        return view('client.baiviet.index');
    }
    public function chitiet($slug)
    {
        return view('client.baiviet.chitiet');
    }
}
