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
            'images'   => 'required|image',
            'lienket'   => 'required',
            'mota'      => 'required',
            'trangthai' => 'required|in:Hiển thị,Tạm ẩn',
        ]);

        try {
            // 1. Xử lý logic Độc quyền vị trí (Exclusive)
            // Nếu vị trí KHÔNG PHẢI là slider (cho phép nhiều ảnh) 
            // VÀ trạng thái mới là "Hiển thị"
            if ($request->vitri !== 'home_banner_slider' && $request->trangthai === 'Hiển thị') {
                // Tìm tất cả banner cũ ở vị trí này đang hiển thị -> Chuyển về Tạm ẩn
                QuangcaoModel::where('vitri', $request->vitri)
                    ->where('trangthai', 'Hiển thị')
                    ->update(['trangthai' => 'Tạm ẩn']);
            }

            // 2. Xử lý upload ảnh
            $imageName = null;
            if ($request->hasFile('images')) {
                $file = $request->file('images');
                $imageName = time() . '_' . $file->getClientOriginalName();
                // Lưu vào thư mục public/assets/client/images/banner
                $file->move('assets/client/images/bg', $imageName);
            }

            // 3. Tạo mới (Cái mới này sẽ là cái duy nhất Hiển thị ở vị trí đó)
            QuangcaoModel::create([
                'vitri'     => $request->vitri,
                'hinhanh'   => $imageName,
                'lienket'   => $request->lienket,
                'mota'      => $request->mota,
                'trangthai' => $request->trangthai,
            ]);

            return redirect()->route('quan-tri-vien.danh-sach-banner-quang-cao')->with('success', 'Thêm banner thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    // 4. FORM SỬA (EDIT)
    // 1. HÀM EDIT (Hiện form sửa)
    public function edit($id)
    {
        $banner = QuangcaoModel::findOrFail($id);
        return view('admin.quangcao.edit', compact('banner'));
    }

    // 2. HÀM UPDATE (Xử lý cập nhật)
    public function update(Request $request, $id)
    {
        $banner = QuangcaoModel::findOrFail($id);

        $request->validate([
            'vitri'     => 'required',
            'images'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Ảnh là nullable khi sửa
            'lienket'   => 'required',
            'mota'      => 'required',
            'trangthai' => 'required|in:Hiển thị,Tạm ẩn',
        ]);

        try {
            // 1. Xử lý logic Độc quyền vị trí (Exclusive)
            if ($request->vitri !== 'home_banner_slider' && $request->trangthai === 'Hiển thị') {
                // Tắt hiển thị các banner khác cùng vị trí (trừ chính nó)
                QuangcaoModel::where('vitri', $request->vitri)
                    ->where('id', '!=', $id) // Quan trọng: Không tắt chính nó
                    ->where('trangthai', 'Hiển thị')
                    ->update(['trangthai' => 'Tạm ẩn']);
            }

            // 2. Xử lý ảnh
            $imageName = $banner->hinhanh; // Mặc định giữ ảnh cũ

            if ($request->hasFile('images')) {
                // a. Xóa ảnh cũ nếu tồn tại
                $oldPath = 'assets/client/images/bg/' . $banner->hinhanh;
                if ($banner->hinhanh && File::exists($oldPath)) {
                    File::delete($oldPath);
                }

                // b. Upload ảnh mới
                $file = $request->file('images');
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move('assets/client/images/bg', $imageName);
            }

            // 3. Cập nhật dữ liệu
            $banner->update([
                'vitri'     => $request->vitri,
                'hinhanh'   => $imageName,
                'lienket'   => $request->lienket,
                'mota'      => $request->mota,
                'trangthai' => $request->trangthai,
            ]);

            return redirect()->route('quan-tri-vien.danh-sach-banner-quang-cao')->with('success', 'Cập nhật banner thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    // 6. XÓA (DELETE)
    public function destroy($id)
    {
        try {
            // 1. Tìm banner cần xóa
            $banner = QuangcaoModel::findOrFail($id);

            // --- LOGIC MỚI: KIỂM TRA SỐ LƯỢNG CÒN LẠI ---
            // Đếm xem tại vị trí này (vitri) đang có bao nhiêu banner
            $countPosition = QuangcaoModel::where('vitri', $banner->vitri)->count();

            // Nếu chỉ còn 1 (hoặc ít hơn) thì chặn xóa
            if ($countPosition <= 1) {
                return redirect()->back()->with('error', 'Không thể xóa! Hệ thống yêu cầu giữ lại ít nhất 1 banner cho vị trí này để hiển thị mặc định.');
            }
            // ---------------------------------------------

            // 2. Xóa ảnh trong thư mục
            // Lưu ý: Kiểm tra lại thư mục là 'banner' hay 'bg' để khớp với hàm store/update của bạn nhé
            $imagePath = public_path('assets/client/images/banner/' . $banner->hinhanh);

            // Nếu file tồn tại thì xóa
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            // 3. Xóa dữ liệu trong DB
            $banner->delete();

            return redirect()->back()->with('success', 'Đã xóa banner thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi xóa: ' . $e->getMessage());
        }
    }
}
