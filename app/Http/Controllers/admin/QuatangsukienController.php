<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DanhmucModel;
use App\Models\QuatangsukienModel;
use App\Models\SanphamModel;
use App\Models\ThuonghieuModel;
use App\Models\BientheModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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

    public function create()
    {
        // Lấy danh sách biến thể còn hàng
        $bienthes = BientheModel::with('sanpham')
            ->where('luottang', '>', 0)
            ->get();

        // Lấy danh sách thương hiệu
        $thuonghieus = ThuonghieuModel::all();

        return view('admin.quatang.create', compact('bienthes', 'thuonghieus'));
    }

    /**
     * 3. LƯU (STORE)
     */
    public function store(Request $request)
    {
        $this->validateRequest($request);

        DB::beginTransaction();
        try {
            // A. Xử lý upload ảnh
            $imageName = null;
            if ($request->hasFile('hinhanh')) {
                $file = $request->file('hinhanh');
                $imageName = time() . '_' . $file->getClientOriginalName();
                // Lưu vào public/assets/client/images/quatang
                $file->move('assets/client/images/thumbs', $imageName);
            }

            $slug = Str::slug($request->ten);

            // B. Tạo sự kiện chính
            $quatang = QuatangSukienModel::create([
                'tieude'           => $request->ten,
                'slug' => $slug,
                'dieukiensoluong'           => $request->dieukiensoluong,
                'dieukiengiatri' => $request->dieukiengiatri,
                'thongtin'          => $request->mota,
                'ngaybatdau'    => $request->ngaybatdau,
                'ngayketthuc'   => $request->ngayketthuc,
                'trangthai'     => $request->trangthai,
                'id_thuonghieu' => $request->id_thuonghieu,
                'hinhanh'       => $imageName,
            ]);

            // C. Xử lý Pivot Table (Sản phẩm tham gia)
            // Chuyển đổi từ mảng index sang mảng key-value cho attach()
            // --- ĐOẠN ĐÃ SỬA (Copy đè vào Controller) ---
            $idsThamGia = [];
            if ($request->has('sp_thamgia')) {
                foreach ($request->sp_thamgia as $item) {
                    // Chỉ lấy id_bienthe, KHÔNG gọi $item['soluong'] nữa
                    $idsThamGia[] = $item['id_bienthe'];
                }
            }
            // Dùng attach với mảng ID đơn giản
            $quatang->sanphamthamgia()->attach($idsThamGia);

            // D. Xử lý Pivot Table (Sản phẩm được tặng)
            $dataDuocTang = [];
            if ($request->has('sp_duoctang')) {
                foreach ($request->sp_duoctang as $item) {
                    $dataDuocTang[$item['id_bienthe']] = ['soluongtang' => $item['soluong']];
                }
            }
            $quatang->sanphamduoctang()->attach($dataDuocTang);

            DB::commit();
            return redirect()->route('quan-tri-vien.danh-sach-qua-tang')->with('success', 'Thêm chương trình thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * 4. FORM SỬA
     */
    public function edit($id)
    {
        $program = QuatangSukienModel::with(['sanphamthamgia', 'sanphamduoctang'])->findOrFail($id);
        $bienthes = BientheModel::with('sanpham')->get();
        $thuonghieus = ThuonghieuModel::all();

        return view('admin.quatang.edit', compact('program', 'bienthes', 'thuonghieus'));
    }

    /**
     * 5. CẬP NHẬT (UPDATE)
     */
    public function update(Request $request, $id)
    {
        $quatang = QuatangSukienModel::findOrFail($id);

        // Validate dữ liệu (Dùng lại hàm validateRequest nếu có, hoặc viết trực tiếp)
        // Lưu ý: Phần sp_thamgia KHÔNG validate soluong nữa
        $this->validateRequest($request);

        DB::beginTransaction();
        try {
            // A. Xử lý ảnh (Nếu có upload mới -> Xóa cũ, Lưu mới)
            $imageName = $quatang->hinhanh; // Giữ nguyên tên ảnh cũ làm mặc định

            if ($request->hasFile('hinhanh')) {
                // 1. Đường dẫn thư mục ảnh (Phải khớp với hàm store)
                $path = 'assets/client/images/thumbs';

                // 2. Xóa ảnh cũ nếu tồn tại trong thư mục
                if ($quatang->hinhanh && File::exists($path . '/' . $quatang->hinhanh)) {
                    File::delete($path . '/' . $quatang->hinhanh);
                }

                // 3. Upload ảnh mới
                $file = $request->file('hinhanh');
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move($path, $imageName);
            }

            // B. Cập nhật thông tin chính
            $quatang->update([
                'tieude'          => $request->ten,
                'slug'            => Str::slug($request->ten), // Cập nhật slug theo tên mới
                'thongtin'        => $request->mota,
                'dieukiensoluong' => $request->dieukiensoluong,
                'dieukiengiatri'  => $request->dieukiengiatri,
                'ngaybatdau'      => $request->ngaybatdau,
                'ngayketthuc'     => $request->ngayketthuc,
                'trangthai'       => $request->trangthai,
                'id_thuonghieu'   => $request->id_thuonghieu,
                'hinhanh'         => $imageName,
            ]);

            // C. Đồng bộ (Sync) Sản phẩm tham gia
            // Logic: Chỉ lấy danh sách ID biến thể, KHÔNG lấy số lượng (giống hàm store)
            $idsThamGia = [];
            if ($request->has('sp_thamgia')) {
                foreach ($request->sp_thamgia as $item) {
                    // Chỉ lấy id_bienthe
                    $idsThamGia[] = $item['id_bienthe'];
                }
            }
            // Dùng sync() để tự động thêm mới / xóa cũ
            $quatang->sanphamthamgia()->sync($idsThamGia);

            // D. Đồng bộ (Sync) Sản phẩm được tặng
            // Logic: Lấy cả ID và Số lượng tặng (soluongtang)
            $syncDuocTang = [];
            if ($request->has('sp_duoctang')) {
                foreach ($request->sp_duoctang as $item) {
                    // Key là id_bienthe, Value là mảng các cột phụ trong bảng pivot
                    $syncDuocTang[$item['id_bienthe']] = ['soluongtang' => $item['soluong']];
                }
            }
            $quatang->sanphamduoctang()->sync($syncDuocTang);

            DB::commit();
            return redirect()->route('quan-tri-vien.danh-sach-qua-tang')->with('success', 'Cập nhật chương trình thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Lỗi cập nhật quà tặng: " . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * 6. XÓA
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $quatang = QuatangSukienModel::findOrFail($id);

            // 1. Detach bảng phụ (Xóa liên kết n-n)
            $quatang->sanphamthamgia()->detach();
            $quatang->sanphamduoctang()->detach();

            // 2. Xóa ảnh nếu có
            if ($quatang->hinhanh && File::exists('assets/client/images/quatang/' . $quatang->hinhanh)) {
                File::delete('assets/client/images/quatang/' . $quatang->hinhanh);
            }

            // 3. Xóa record chính
            $quatang->delete();

            DB::commit();
            return redirect()->route('quan-tri-vien.danh-sach-qua-tang')->with('success', 'Xóa chương trình thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Lỗi xóa: ' . $e->getMessage());
        }
    }

    /**
     * Helper: Validate dữ liệu
     */
    private function validateRequest($request)
    {
        $request->validate([
            'ten'           => 'required|string|max:255',
            'dieukiensoluong' => 'required',
            'dieukiengiatri' => 'required',
            'ngaybatdau'    => 'required|date',
            'ngayketthuc'   => 'required|date|after_or_equal:ngaybatdau',
            'trangthai'     => 'required|in:Hiển thị,Tạm ẩn',
            'id_thuonghieu' => 'nullable|exists:thuonghieu,id',
            'hinhanh'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Validate mảng sản phẩm
            'sp_thamgia'    => 'required|array|min:1',
            'sp_thamgia.*.id_bienthe' => 'required|exists:bienthe,id',

            'sp_duoctang'   => 'required|array|min:1',
            'sp_duoctang.*.id_bienthe' => 'required|exists:bienthe,id',
            'sp_duoctang.*.soluong'    => 'required|integer|min:1',
        ], [
            'sp_thamgia.required' => 'Vui lòng chọn ít nhất 1 sản phẩm điều kiện (Mua).',
            'sp_duoctang.required' => 'Vui lòng chọn ít nhất 1 sản phẩm quà tặng.',
            'ngayketthuc.after_or_equal' => 'Ngày kết thúc phải sau ngày bắt đầu.',
            'hinhanh.image' => 'File tải lên phải là hình ảnh.',
        ]);
    }
}
