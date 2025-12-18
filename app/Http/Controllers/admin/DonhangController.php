<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\DonhangModel as Donhang;
use App\Models\ChitietdonhangModel as ChitietDonhang;
use App\Models\NguoidungModel as Nguoidung;
use App\Models\SanphamModel as Sanpham;
use Illuminate\Http\Request;
use App\Models\BientheModel as Bienthe;

class DonhangController extends Controller
{
    // Danh sách đơn hàng
    public function index()
    {
        $donhangs = Donhang::orderByDesc('created_at')->get();

        return view('admin.donhang.index', compact('donhangs'));
    }

    // Hiển thị form tạo đơn hàng
    public function create()
    {
        $customers = Nguoidung::all();
        $products  = Sanpham::with('bienthe')->get();
        return view('donhang.create', compact('customers', 'products'));
    }

    // Lưu đơn hàng mới
    public function store(Request $request)
    {
        $ma_donhang = $this->generateUniqueOrderCode();

        $validated = $request->validate([
            'ghichu'       => 'nullable|string',
            'trangthai'    => 'required|integer|in:0,1,2,3',
            'id_nguoidung' => 'nullable|integer',
            'id_magiamgia' => 'nullable|integer',
        ]);

        $validated['ma_donhang'] = $ma_donhang;

        Donhang::create($validated);

        return redirect()->route('danh-sach-don-hang')
            ->with('success', 'Tạo đơn hàng thành công!');
    }

    // Hàm tạo mã đơn hàng ngẫu nhiên và duy nhất
    private function generateUniqueOrderCode()
    {
        do {
            $code = Str::upper(Str::random(5));
        } while (Donhang::where('ma_donhang', $code)->exists());

        return $code;
    }

    // Chi tiết đơn hàng
    public function show($id)
    {
        $donhang = Donhang::with(['khachhang', 'chitiet.sanpham'])
            ->findOrFail($id);

        return view('donhang.show', compact('donhang'));
    }

    // API chi tiết đơn hàng
    public function showApi($id)
    {
        $order = Donhang::with('chitiet')
            ->where('is_deleted', 0)
            ->findOrFail($id);

        return response()->json([
            'status'       => 'success',
            'order'        => $order,
            'total_price'  => $order->chitiets->sum('tongtien'),
            'total_amount' => $order->chitiets->sum('soluong'),
        ]);
    }

    // Form sửa đơn hàng
    public function edit($id)
    {
        $donhang = Donhang::with('khachhang')->findOrFail($id);
        $products = Sanpham::all();

        return view('donhang.edit', compact('donhang', 'products'));
    }

    // Cập nhật đơn hàng
    public function update(Request $request, $id)
    {
        $donhang = Donhang::findOrFail($id);

        $validated = $request->validate([
            'ghichu'       => 'nullable|string',
            'trangthai'    => 'required|integer|in:0,1,2,3',
            'id_nguoidung' => 'nullable|integer',
            'id_magiamgia' => 'nullable|integer',
        ]);

        $donhang->update($validated);

        return redirect()->route('danh-sach-don-hang')
            ->with('success', 'Cập nhật đơn hàng thành công!');
    }

    // Xóa đơn hàng (ẩn dữ liệu)
    public function destroy($id)
    {
        $donhang = Donhang::findOrFail($id);
        $donhang->forceDelete();

        return redirect()->route('danh-sach-don-hang')
            ->with('success', 'Đơn hàng đã được xóa!');
    }

    // API cập nhật số lượng sản phẩm trong đơn hàng
    public function updateItemQuantity(Request $request, $orderId, $itemId)
    {
        $validated = $request->validate([
            'soluong' => 'required|integer|min:1',
        ]);

        $order = Donhang::with('chitiets')->where('is_deleted', 0)->findOrFail($orderId);
        $item = $order->chitiets()->where('id', $itemId)->first();

        if (!$item) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Sản phẩm không tồn tại trong đơn hàng',
            ], 404);
        }

        $item->soluong  = $validated['soluong'];
        $item->tongtien = $item->gia * $item->soluong;
        $item->save();

        return response()->json([
            'status'       => 'success',
            'message'      => 'Cập nhật số lượng thành công',
            'total_price'  => $order->chitiets->sum('tongtien'),
            'total_amount' => $order->chitiets->sum('soluong'),
        ]);
    }
}
