<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Models\DanhmucModel;
use Illuminate\Http\Request;

class DanhmucController extends Controller
{
    public function index()
    {
        $danhmuc = DanhmucModel::withCount('sanpham')->get();
        return view('admin.danhmuc', compact('danhmuc'));
    }

    public function create()
    {
        return view('admin.taodanhmuc');
    }

    public function store(Request $request)
    {
        DanhmucModel::create($request->only(['ten', 'trangthai']));
        return redirect()->route('quan-tri-vien.danh-sach-danh-muc')->with('success', 'Tạo danh mục thành công!');
    }

    public function edit($slug)
    {
        $danhmuc = DanhmucModel::where('slug', $slug)->firstOrFail();
        return view('admin.suadanhmuc', compact('danhmuc'));
    }

    public function update(Request $request, $slug)
    {
        $danhmuc = DanhmucModel::where('slug', $slug)->firstOrFail();

        // 1. Validate dữ liệu
        $validated = $request->validate([
            'ten' => 'required|string|max:255',
            'slug' => [
                'required',
                // Kiểm tra unique trong bảng 'danhmuc' (thay bằng tên bảng thật của bạn)
                // ignore($danhmuc->id) nghĩa là: trùng ai thì trùng, đừng trùng chính tôi
                Rule::unique('danhmuc', 'slug')->ignore($danhmuc->id),
            ],
            'trangthai' => 'sometimes',
        ], [
            // Custom thông báo lỗi tiếng Việt
            'slug.unique' => 'Đường dẫn (slug) này đã tồn tại, vui lòng chọn tên khác.',
            'slug.required' => 'Vui lòng nhập slug.',
        ]);

        // 2. Cập nhật dữ liệu (chỉ lấy những field đã validate cho an toàn)
        $danhmuc->update($request->only(['ten', 'slug', 'trangthai']));

        return redirect()
            ->route('quan-tri-vien.danh-sach-danh-muc')
            ->with('success', 'Đã cập nhật thành công!');
    }

    public function destroy($slug)
    {
        $danhmuc = DanhmucModel::where('slug', $slug)->firstOrFail();

        // Check nếu có sản phẩm thì không cho xóa
        if ($danhmuc->sanpham()->count() > 0) {
            return redirect()->route('quan-tri-vien.danh-sach-danh-muc')
                ->with('error', 'Không thể xóa! Danh mục này vẫn còn sản phẩm.');
        }

        $danhmuc->delete();

        return redirect()->route('quan-tri-vien.danh-sach-danh-muc')
            ->with('success', 'Xóa danh mục thành công!');
    }
}
