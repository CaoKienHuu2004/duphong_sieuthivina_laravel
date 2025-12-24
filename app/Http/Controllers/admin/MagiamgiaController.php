<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MagiamgiaModel;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class MagiamgiaController extends Controller
{
    // 1. DANH SÁCH
    public function index()
    {
        $coupons = MagiamgiaModel::orderBy('id', 'desc')->get();
        return view('admin.magiamgia.index', compact('coupons'));
    }

    // 2. FORM TẠO MỚI
    public function create()
    {
        return view('admin.magiamgia.create');
    }

    // 3. LƯU (STORE)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'magiamgia'   => 'required|string|max:255|unique:magiamgia,magiamgia',
            'giatri'      => 'required|integer|min:1',
            'dieukien'    => 'required|integer|min:0', // Đơn tối thiểu
            'ngaybatdau'  => 'required|date',
            'ngayketthuc' => 'required|date|after_or_equal:ngaybatdau',
            'trangthai'   => 'required|in:Hoạt động,Tạm khóa',
            'mota'        => 'nullable|string',
        ], [
            'magiamgia.required' => 'Vui lòng nhập mã giảm giá.',
            'magiamgia.unique'   => 'Mã này đã tồn tại.',
            'giatri.required'    => 'Vui lòng nhập số tiền giảm.',
            'ngayketthuc.after_or_equal' => 'Ngày kết thúc phải sau ngày bắt đầu.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            MagiamgiaModel::create([
                'magiamgia'   => strtoupper($request->magiamgia), // Viết hoa code
                'dieukien'    => $request->dieukien, // Đơn tối thiểu
                'giatri'      => $request->giatri,   // Số tiền giảm
                'mota'        => $request->mota,
                'ngaybatdau'  => $request->ngaybatdau,
                'ngayketthuc' => $request->ngayketthuc,
                'trangthai'   => $request->trangthai,
            ]);

            return redirect()->route('quan-tri-vien.danh-sach-ma-giam-gia')->with('success', 'Thêm mã giảm giá thành công!');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    // 4. FORM SỬA
    public function edit($id)
    {
        $coupon = MagiamgiaModel::findOrFail($id);
        return view('admin.magiamgia.edit', compact('coupon'));
    }

    // 5. CẬP NHẬT (UPDATE)
    public function update(Request $request, $id)
    {
        $coupon = MagiamgiaModel::findOrFail($id);

        $validator = Validator::make($request->all(), [
            // Check trùng trừ chính nó ra
            'magiamgia'   => 'required|string|max:255',
            'giatri'      => 'required|integer|min:1',
            'dieukien'    => 'required|integer|min:0',
            'ngaybatdau'  => 'required|date',
            'ngayketthuc' => 'required|date|after_or_equal:ngaybatdau',
            'trangthai'   => 'required',
        ],
        [
            'magiamgia.required' => 'Vui lòng nhập mã giảm giá.',
            'giatri.required'    => 'Vui lòng nhập số tiền giảm.',
            'ngayketthuc.after_or_equal' => 'Ngày kết thúc phải sau ngày bắt đầu.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $coupon->update([
                'magiamgia'   => strtoupper($request->magiamgia),
                'dieukien'    => $request->dieukien,
                'giatri'      => $request->giatri,
                'mota'        => $request->mota,
                'ngaybatdau'  => $request->ngaybatdau,
                'ngayketthuc' => $request->ngayketthuc,
                'trangthai'   => $request->trangthai,
            ]);

            return redirect()->route('quan-tri-vien.danh-sach-ma-giam-gia')->with('success', 'Cập nhật thành công!');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    // 6. XÓA (DELETE)
    public function destroy($id)
    {
        try {
            $coupon = MagiamgiaModel::findOrFail($id);
            $coupon->delete(); // Xóa mềm (Soft Delete) vì model có khai báo
            return redirect()->route('quan-tri-vien.danh-sach-ma-giam-gia')->with('success', 'Xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi xóa: ' . $e->getMessage());
        }
    }
}