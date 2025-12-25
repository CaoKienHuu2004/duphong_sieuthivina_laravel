<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrangnoidungModel;

class TrangnoidungController extends Controller
{
    // 1. DANH SÁCH
    public function index()
    {
        $pages = TrangnoidungModel::orderByDesc('id')->get();
        return view('admin.noidung', compact('pages'));
    }

    // 2. FORM TẠO MỚI
    public function create()
    {
        return view('admin.trangdon.create');
    }

    // 3. LƯU MỚI
    public function store(Request $request)
    {
        $request->validate([
            'tieude' => 'required|unique:trangdon,tieude',
            'slug' => 'required|unique:trangdon,slug',
            'noidung' => 'required',
        ], [
            'tieude.required' => 'Vui lòng nhập tiêu đề trang.',
            'tieude.unique' => 'Tiêu đề trang đã tồn tại.',
            'slug.required' => 'Vui lòng nhập đường dẫn (slug).',
            'slug.unique' => 'Đường dẫn này đã tồn tại.',
            'noidung.required' => 'Nội dung không được để trống.',
        ]);

        try {
            TrangnoidungModel::create($request->all());
            return redirect()->route('quan-tri-vien.danh-sach-trang-don')->with('success', 'Thêm trang thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    // 4. FORM SỬA
    public function edit($id)
    {
        $page = TrangnoidungModel::findOrFail($id);
        return view('admin.trangdon.edit', compact('page'));
    }

    // 5. CẬP NHẬT
    public function update(Request $request, $id)
    {
        $page = TrangnoidungModel::findOrFail($id);

        $request->validate([
            'tieude' => 'required|unique:trangdon,tieude,'.$id,
            'slug' => 'required|unique:trangdon,slug,'.$id,
            'noidung' => 'required',
        ]);

        try {
            $page->update($request->all());
            return redirect()->route('quan-tri-vien.danh-sach-trang-don')->with('success', 'Cập nhật thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    // 6. XÓA
    public function destroy($id)
    {
        try {
            TrangnoidungModel::destroy($id);
            return redirect()->back()->with('success', 'Đã xóa trang thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi xóa: ' . $e->getMessage());
        }
    }
}