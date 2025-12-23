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

    public function update(Request $request, $id)
    {
        // Tìm danh mục cần sửa, nếu không thấy báo lỗi 404
        $danhmuc = DanhmucModel::findOrFail($id);

        // 1. Validate dữ liệu
        $request->validate([
            // Lưu ý: unique:danhmuc,ten,$id -> Bỏ qua check trùng tên với chính nó
            'tendm'     => 'required|string|max:255|unique:danhmuc,ten,' . $id,
            'mota'      => 'required|string',
            'parent'    => 'nullable',
            'trangthai' => 'required',
            'images'    => 'nullable|image',
        ], [
            'tendm.required'   => 'Vui lòng nhập tên danh mục.',
            'tendm.unique'     => 'Tên danh mục đã tồn tại.',
            'mota.required'    => 'Vui lòng nhập mô tả.',
            'trangthai.required' => 'Vui lòng chọn trạng thái.',
            'images.image'     => 'File tải lên phải là hình ảnh.',
        ]);

        try {
            // 2. Xử lý logic dữ liệu
            
            // Xử lý Slug mới
            $slug = Str::slug($request->tendm);

            // Xử lý Parent ID
            $parentId = ($request->parent == 'Không có') ? null : $request->parent;

            // [QUAN TRỌNG] Kiểm tra: Danh mục cha không thể là chính nó
            if ($parentId == $id) {
                return redirect()->back()->withInput()->with('error', 'Danh mục cha không thể là chính danh mục này.');
            }

            // Xử lý hình ảnh
            $logoName = $danhmuc->logo; // Mặc định giữ lại tên ảnh cũ

            if ($request->hasFile('images')) {
                $file = $request->file('images');
                $filename = $slug . '-' . time() . '.' . $file->getClientOriginalExtension();
                $path = public_path('assets/client/images/categories');

                // XÓA ẢNH CŨ (Nếu không phải là ảnh mặc định và file tồn tại)
                $oldImagePath = $path . '/' . $danhmuc->logo;
                if ($danhmuc->logo != 'danhmuc.jpg' && file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }

                // Lưu ảnh mới
                $file->move($path, $filename);
                $logoName = $filename;
            } 
            // Nếu đổi tên danh mục (slug đổi) nhưng KHÔNG đổi ảnh, 
            // bạn có thể cân nhắc đổi tên file ảnh cũ theo slug mới hoặc giữ nguyên.
            // Ở đây mình giữ nguyên logic đơn giản là giữ tên ảnh cũ.

            // 3. Cập nhật record trong Database
            $danhmuc->update([
                'ten'       => $request->tendm,
                'slug'      => $slug,
                'logo'      => $logoName,
                'parent'    => $parentId,
                'trangthai' => $request->trangthai,
                // 'sapxep' => $request->sapxep, // Nếu form edit có field này thì bỏ comment
                // 'mota'   => $request->mota, // BỎ QUA theo ghi chú của bạn (DB không có cột này)
            ]);

            // 4. Trả về thông báo thành công
            return redirect()->route('quan-tri-vien.danh-sach-danh-muc')->with('success', 'Cập nhật danh mục thành công!');

        } catch (\Exception $e) {
            \Log::error("Lỗi Controller Update: " . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
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
