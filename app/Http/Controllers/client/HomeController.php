<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TukhoaModel;
use App\Models\DanhmucModel;

class HomeController extends Controller
{
    public function index (Request $request){

        // =========================================HIỂN THỊ DANH SÁCH DANH MỤC TRONG HEADER TOP============================================================

        $danhmuc = DanhmucModel::select('ten','logo')->get();

        // =========================================HIỂN THỊ TỪ KHÓA TRONG HEADER============================================================

        // Từ khóa phổ biến như "laptop", "điện thoại", "áo thun"
        $tukhoaphobien = TukhoaModel::select('tukhoa')->orderBy('luottruycap', 'desc')->take(5)->get();

        // Từ khóa ngẫu nhiên để làm placeholder trong ô tìm kiếm
        $top20tukhoa = TukhoaModel::orderBy('luottruycap', 'desc')->take(20)->get();
        $tukhoangaunhien = TukhoaModel::inRandomOrder()->first();
        if ($top20tukhoa->isNotEmpty()) {
            $tukhoaphobienngaunhien = $top20tukhoa->random(); 
            $tukhoaplaceholder = $tukhoaphobienngaunhien->tukhoa;
        }

        return view('client.index', compact('tukhoaphobien','tukhoaplaceholder','danhmuc'));
    }
}
