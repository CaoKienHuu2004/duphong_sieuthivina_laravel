<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuangcaoModel;
use Illuminate\Support\Facades\File;

class QuangcaoController extends Controller
{
    // 1. DANH SÁCH (READ)
    public function index()
    {
        $banners = QuangcaoModel::orderBy('id', 'desc')->get();
        return view('admin.quangcao.index', compact('banners'));
    }

    // 2. FORM TẠO MỚI (CREATE)
    public function create()
    {
        return view('admin.quangcao.create');
    }

    // 3. LƯU MỚI (STORE)
    public function store(Request $request)
    {
        $request->validate([
            'vitri'     => 'required',
            'hinhanh'   => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'lienket'   => 'required',
            'mota'      => 'required',
            'trangthai' => 'required|in:Hiển thị,Tạm ẩn',
        ]);

        try {
            // Xử lý upload ảnh
            $imageName = null;
            if ($request->hasFile('hinhanh')) {
                $file = $request->file('hinhanh');
                $imageName = time() . '_' . $file->getClientOriginalName();
                // Lưu vào thư mục public/assets/client/images/banner
                $file->move(public_path('assets/client/images/banner'), $imageName);
            }

            QuangcaoModel::create([
                'vitri'     => $request->vitri,
                'hinhanh'   => $imageName,
                'lienket'   => $request->lienket,
                'mota'      => $request->mota,
                'trangthai' => $request->trangthai,
            ]);

            return redirect()->route('quan-tri-vien.danh-sach-quang-cao')->with('success', 'Thêm banner thành công!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    // 4. FORM SỬA (EDIT)
    public function edit($id)
    {
        $banner = QuangcaoModel::findOrFail($id);
        return view('admin.quangcao.edit', compact('banner'));
    }

    // 5. CẬP NHẬT (UPDATE)
    public function update(Request $request, $id)
    {
        $banner = QuangcaoModel::findOrFail($id);

        $request->validate([
            'vitri'     => 'required',
            'hinhanh'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Ảnh không bắt buộc khi sửa
            'lienket'   => 'required',
            'mota'      => 'required',
            'trangthai' => 'required|in:Hiển thị,Tạm ẩn',
        ]);

        try {
            $imageName = $banner->hinhanh; // Giữ ảnh cũ mặc định

            // Nếu có upload ảnh mới
            if ($request->hasFile('hinhanh')) {
                // 1. Xóa ảnh cũ
                $oldPath = public_path('assets/client/images/banner/' . $banner->hinhanh);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }

                // 2. Upload ảnh mới
                $file = $request->file('hinhanh');
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/client/images/banner'), $imageName);
            }

            $banner->update([
                'vitri'     => $request->vitri,
                'hinhanh'   => $imageName,
                'lienket'   => $request->lienket,
                'mota'      => $request->mota,
                'trangthai' => $request->trangthai,
            ]);

            return redirect()->route('quan-tri-vien.danh-sach-quang-cao')->with('success', 'Cập nhật banner thành công!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    // 6. XÓA (DELETE)
    public function destroy($id)
    {
        try {
            $banner = QuangcaoModel::findOrFail($id);

            // Xóa ảnh trong thư mục
            $imagePath = public_path('assets/client/images/banner/' . $banner->hinhanh);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            // Xóa dữ liệu trong DB
            $banner->delete();

            return redirect()->back()->with('success', 'Đã xóa banner thành công!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi xóa: ' . $e->getMessage());
        }
    }
}