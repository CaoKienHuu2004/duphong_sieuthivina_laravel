@extends('admin.layouts.app')

@section('title', 'Danh sách người dùng | Quản trị hệ thống')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Danh sách sản phẩm</h4>
                    <h6>Quản lý sản phẩm của bạn</h6>
                </div>
                <div class="page-btn">
                    <a href="http://127.0.0.1:8000/quan-tri-vien/san-pham/tao-san-pham" class="btn btn-added"><img
                            src="{{asset('assets/admin')}}/img/icons/plus.svg" alt="img" class="me-1" />Thêm sản phẩm</a>
                </div>
            </div>


            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-path">
                                <a class="btn btn-filter" id="filter_search">
                                    <img src="{{asset('assets/admin')}}/img/icons/filter.svg" alt="img" />
                                    <span><img src="{{asset('assets/admin')}}/img/icons/closes.svg" alt="img" /></span>
                                </a>
                            </div>
                            <div class="search-input">
                                <a class="btn btn-searchset"><img src="{{asset('assets/admin')}}/img/icons/search-white.svg"
                                        alt="img" /></a>
                            </div>
                        </div>

                    </div>

                    <div class="card mb-0" id="filter_inputs">
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                    <div class="row">
                                        <div class="col-lg-3 col-sm-6 col-12">
                                            <div class="form-group">
                                                <select class="select" name="trangthai">
                                                    <option disabled selected>-- Trạng thái sản phẩm
                                                        --</option>
                                                    <option value="Công khai">Đang bán</option>
                                                    <option value="Tạm khóa">Tạm ngừng bán</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6 col-12">
                                            <div class="form-group">
                                                <select class="select">
                                                    <option disabled selected>-- Trạng thái tồn kho
                                                        --</option>
                                                    <option>Còn hàng</option>
                                                    <option>Hết hàng</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-1 col-sm-6 col-12">
                                            <div class="form-group">
                                                <a class="btn btn-filters ms-auto"><img
                                                        src="{{asset('assets/admin')}}/img/icons/search-whites.svg"
                                                        alt="img" /></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table dataold">
                            <!-- có thể thêm datanew sau class table -->
                            <thead>
                                <tr>
                                    <th class="text-start">Người dùng</th>
                                    <th class="text-start">Số điện thoại</th>
                                    <th class="text-start">Email</th>
                                    <th class="text-center">Đặt đơn hàng</th>
                                    <th class="text-center">Vai trò</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                    <td class="productimgname align-items-center w-100">
                                        <a href="#"
                                            class="product-img">
                                            <img src="{{ asset('assets/client') }}/images/thumbs/{{ $user->avatar }}"
                                                alt="{{ $user->hoten }}"
                                                style="width: 60px; height: 60px; object-fit: cover;" />
                                        </a>
                                        <div>
                                            <span style="font-size: 12px;">{{ $user->username }}</span>
                                            <p
                                                style="width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                <a class="text-black"
                                                    href="#"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ $user->hoten }}">{{ $user->hoten }}</a>
                                            </p>
                                        </div>

                                    </td>
                                    <td class="text-start"
                                        style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        <span title="{{ $user->sodienthoai }}" data-bs-toggle="tooltip" data-bs-placement="top">{{ $user->sodienthoai }}</span></td>
                                    <td class="text-start">

                                        {{ $user->email }}

                                    </td>
                                    <td class="text-center">{{ $user->donhang->count() }}</td>
                                    <td class="text-center">
                                        @if ($user->vaitro == 'admin')
                                            <span class="badges  bg-lightpurple ">Quản trị viên</span>
                                        @else
                                            <span class="badges  bg-lightblue ">Khách hàng</span>
                                        @endif
                                        
                                    </td>
                                    <td class="text-center">
                                        @if ($user->trangthai == 'Hoạt động')
                                            <span class="badges  bg-lightgreen ">{{ $user->trangthai }}</span>
                                        @elseif($user->trangthai == 'Tạm khóa')
                                            <span class="badges  bg-lightyellow ">{{ $user->trangthai }}</span>
                                        @else
                                            <span class="badges  bg-lightred ">{{ $user->trangthai }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="me-3" href="#" onclick="return confirm('Bạn có chắc chắn nâng cấp tài khoản này thành quản trị viên ?');">
                                            <i data-feather="users" data-bs-toggle="tooltip" data-bs-placement="top" title="nâng cấp quản trị viên"></i>
                                        </a>
                                        <a class="" href="http://127.0.0.1:8000/quan-tri-vien/san-pham/40/xoa"
                                            onclick="return confirm('Bạn có chắc chắn muốn khóa tài khoản này ?');">
                                            <i data-feather="lock" data-bs-toggle="tooltip" data-bs-placement="top" title=""></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                    
                                @endforelse
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection