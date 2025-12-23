<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Models\DanhmucModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DanhmucController extends Controller
{
    public function index()
    {
        $danhmuc = DanhmucModel::withCount('sanpham')->orderBy('sapxep', 'asc')->get();
        return view('admin.danhmuc', compact('danhmuc'));
    }

    public function create()
    {   
        $danhmuc = DanhmucModel::withCount('sanpham')->orderBy('sapxep', 'asc')->get();
        return view('admin.taodanhmuc', compact('danhmuc'));
    }

    // Xử lý lưu danh mục
    public function store(Request $request)
    {
        // 1. Validate dữ liệu
        $request->validate([
            'tendm'     => 'required|string|max:255|unique:danhmuc,ten',
            'mota'     => 'required|string',
            'parent'    => 'nullable', // Có thể là chuỗi "Không có" hoặc ID
            'trangthai' => 'required',
            'images'    => 'nullable|image', // Validate ảnh
        ], [
            'tendm.required' => 'Vui lòng nhập tên danh mục.',
            'tendm.unique'   => 'Tên danh mục đã tồn tại.',
            'mota.required' => 'Vui lòng nhập mô tả.',
            'trangthai.required' => 'Vui lòng chọn trạng thái.',
            'trangthai.in' => 'Trạng thái không hợp lệ.',
            'images.image'   => 'File tải lên phải là hình ảnh.',
        ]);

        try {
            // 2. Xử lý logic dữ liệu
            
            // Xử lý Slug (Đường dẫn) từ Tên danh mục
            $slug = Str::slug($request->tendm);

            // Xử lý Parent ID
            // Trong view value="Không có" hoặc ID. Cần chuyển "Không có" thành NULL
            $parentId = ($request->parent == 'Không có') ? null : $request->parent;

            // Xử lý upload hình ảnh (logo)
            $logoName = 'danhmuc.jpg'; // Giá trị mặc định trong DB của bạn
            
            if ($request->hasFile('images')) {
                $file = $request->file('images');
                // Đặt tên file theo slug để chuẩn SEO và tránh trùng
                $filename = $slug . '-' . time() . '.' . $file->getClientOriginalExtension();
                
                // Lưu vào thư mục public/uploads/danhmuc (Bạn có thể đổi đường dẫn tùy ý)
                $file->move(public_path('assets/client/images/categories'), $filename);
                
                $logoName = $filename;
            }

            // 3. Tạo mới record trong Database
            DanhmucModel::create([
                'ten'       => $request->tendm,      // Map 'tendm' (view) -> 'ten' (db)
                'slug'      => $slug,
                'logo'      => $logoName,            // Map 'images' (view) -> 'logo' (db)
                'parent'    => $parentId,
                'trangthai' => $request->trangthai,
                'sapxep'    => 0,                    // Giá trị mặc định hoặc thêm input ở view
                'mota'   => $request->mota,       // BỎ QUA vì bảng 'danhmuc' không có cột này
            ]);

            // 4. Trả về thông báo thành công
            return redirect()->route('quan-tri-vien.danh-sach-danh-muc')->with('success', 'Thêm danh mục thành công!');

        } catch (\Exception $e) {
            \Log::error("Lỗi Controller: " . $e->getMessage());
            // Log lỗi nếu cần thiết
            return redirect()->back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
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

    public function destroy($id)
    {
        $danhmuc = DanhmucModel::where('id', $id)->firstOrFail();

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
