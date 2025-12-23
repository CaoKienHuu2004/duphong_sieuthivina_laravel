<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ThuonghieuModel as Thuonghieu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ThuonghieuController extends Controller
{
    public function index()
    {
        $thuonghieu = Thuonghieu::withCount('sanpham')->get();
        return view('admin.thuonghieu', compact('thuonghieu'));
    }

    public function create()
    {
        return view('admin.taothuonghieu');
    }

    public function store(Request $request)
    {
        // 1. Validate dữ liệu
        $request->validate([
            'ten'     => 'required|string|max:255|unique:thuonghieu,ten',
            'parent'    => 'nullable', // Có thể là chuỗi "Không có" hoặc ID
            'trangthai' => 'required',
            'images'    => 'nullable|image', // Validate ảnh
        ], [
            'ten.required' => 'Vui lòng nhập tên thương hiệu.',
            'ten.unique'   => 'Tên thương hiệu đã tồn tại.',
            'trangthai.required' => 'Vui lòng chọn trạng thái.',
            'trangthai.in' => 'Trạng thái không hợp lệ.',
            'images.image'   => 'File tải lên phải là hình ảnh.',
        ]);

        try {
            // 2. Xử lý logic dữ liệu
            
            // Xử lý Slug (Đường dẫn) từ Tên thương hiệu
            $slug = Str::slug($request->ten);

            // Xử lý upload hình ảnh (logo)
            $logoName = 'thuonghieu.jpg'; // Giá trị mặc định trong DB của bạn
            
            if ($request->hasFile('images')) {
                $file = $request->file('images');
                // Đặt tên file theo slug để chuẩn SEO và tránh trùng
                $filename = $slug . '-' . time() . '.' . $file->getClientOriginalExtension();
                
                // Lưu vào thư mục public/uploads/danhmuc (Bạn có thể đổi đường dẫn tùy ý)
                $file->move('assets/client/images/brands', $filename);
                
                $logoName = $filename;
            }

            // 3. Tạo mới record trong Database
            Thuonghieu::create([
                'ten'       => $request->ten,      // Map 'ten' (view) -> 'ten' (db)
                'slug'      => $slug,
                'logo'      => $logoName,
                'trangthai' => $request->trangthai,    // BỎ QUA vì bảng 'danhmuc' không có cột này
            ]);

            // 4. Trả về thông báo thành công
            return redirect()->route('quan-tri-vien.danh-sach-thuong-hieu')->with('success', 'Thêm thương hiệu thành công!');

        } catch (\Exception $e) {
            \Log::error("Lỗi Controller: " . $e->getMessage());
            // Log lỗi nếu cần thiết
            return redirect()->back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $thuonghieu = Thuonghieu::findOrFail($id);
        return view('admin.suathuonghieu', compact('thuonghieu'));
    }

    public function update(Request $request, $id)
    {
        // Tìm thương hiệu cần sửa, nếu không thấy báo lỗi 404
        $thuonghieu = Thuonghieu::findOrFail($id);

        // 1. Validate dữ liệu
        $request->validate([
            // Lưu ý: unique:danhmuc,ten,$id -> Bỏ qua check trùng tên với chính nó
            'ten'     => 'required|string|max:255|unique:thhuonghieu,ten,' . $id,
            'trangthai' => 'required',
            'images'    => 'nullable|image',
        ], [
            'ten.required'   => 'Vui lòng nhập tên thương hiệu.',
            'ten.unique'     => 'Tên thương hiệu đã tồn tại.',
            'trangthai.required' => 'Vui lòng chọn trạng thái.',
            'images.image'     => 'File tải lên phải là hình ảnh.',
        ]);

        try {
            // 2. Xử lý logic dữ liệu
            
            // Xử lý Slug mới
            $slug = Str::slug($request->ten);

            // Xử lý hình ảnh
            $logoName = $thuonghieu->logo; // Mặc định giữ lại tên ảnh cũ

            if ($request->hasFile('images')) {
                $file = $request->file('images');
                $filename = $slug . '-' . time() . '.' . $file->getClientOriginalExtension();
                $path = 'assets/client/images/brands';

                // XÓA ẢNH CŨ (Nếu không phải là ảnh mặc định và file tồn tại)
                $oldImagePath = $path . '/' . $thuonghieu->logo;
                if ($thuonghieu->logo != 'thuonghieu.jpg' && file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }

                // Lưu ảnh mới
                $file->move($path, $filename);
                $logoName = $filename;
            } 
            // Nếu đổi tên thương hiệu (slug đổi) nhưng KHÔNG đổi ảnh, 
            // bạn có thể cân nhắc đổi tên file ảnh cũ theo slug mới hoặc giữ nguyên.
            // Ở đây mình giữ nguyên logic đơn giản là giữ tên ảnh cũ.

            // 3. Cập nhật record trong Database
            $thuonghieu->update([
                'ten'       => $request->ten,
                'slug'      => $slug,
                'logo'      => $logoName,
                'trangthai' => $request->trangthai,
                // 'sapxep' => $request->sapxep, // Nếu form edit có field này thì bỏ comment
                // 'mota'   => $request->mota, // BỎ QUA theo ghi chú của bạn (DB không có cột này)
            ]);

            // 4. Trả về thông báo thành công
            return redirect()->route('quan-tri-vien.danh-sach-thuong-hieu')->with('success', 'Cập nhật thương hiệu thành công!');

        } catch (\Exception $e) {
            \Log::error("Lỗi Controller Update: " . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $thuonghieu = Thuonghieu::findOrFail($id);

        // Check nếu có sản phẩm thì không cho xóa
        if ($thuonghieu->sanpham()->count() > 0) {
            return redirect()->route('quan-tri-vien.danh-sach-thuong-hieu')
                ->with('error', 'Không thể xóa! thương hiệu này vẫn còn sản phẩm.');
        }

        $thuonghieu->delete();

        return redirect()->route('quan-tri-vien.danh-sach-thuong-hieu')
            ->with('success', 'Xóa thương hiệu thành công!');
    }
}
