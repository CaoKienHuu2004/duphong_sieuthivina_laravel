<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DanhmucModel;
use App\Models\QuatangsukienModel;
use App\Models\SanphamModel;
use App\Models\ThuonghieuModel;
use Illuminate\Http\Request;

class QuatangsukienController extends Controller
{
    public function index(Request $request)
    {
        $query = QuatangsukienModel::with('sanphamduoctang', 'sanphamthamgia');

        
        // if ($request->filled('thuonghieu')) {
        //     $query->where('id_thuonghieu', $request->thuonghieu);
        // }

        
        // if ($request->filled('danhmuc')) {
        //     $query->whereHas('danhmuc', function ($q) use ($request) {
        //         $q->where('id_danhmuc', $request->danhmuc);
        //     });
        // }

        
        // if ($request->filled('gia_min') && $request->filled('gia_max')) {
        //     $query->whereHas('bienthe', function ($q) use ($request) {
        //         $q->whereBetween('gia', [$request->gia_min, $request->gia_max]);
        //     });
        // } elseif ($request->filled('gia_min')) {
        //     $query->whereHas('bienthe', function ($q) use ($request) {
        //         $q->where('gia', '>=', $request->gia_min);
        //     });
        // } elseif ($request->filled('gia_max')) {
        //     $query->whereHas('bienthe', function ($q) use ($request) {
        //         $q->where('gia', '<=', $request->gia_max);
        //     });
        // }

        
        $quatangs = $query->orderBy('id', 'desc')->get();

        $thuonghieus = ThuonghieuModel::all();
        $danhmucs = DanhmucModel::all();

        return view('admin.quatang.index', compact('quatangs', 'thuonghieus', 'danhmucs'));

        
    }
}
