@extends('admin.layouts.app')

@section('title', 'Danh sách người dùng | Quản trị hệ thống')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Danh sách người dùng</h4>
                    <h6>Xem thông tin & cập nhật tài khoản người dùng hệ thống</h6>
                </div>
                <div class="page-btn">
                    
                </div>
            </div>

             @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-path">
                            </div>
                            <div class="search-input">
                                <a class="btn btn-searchset"><img src="{{asset('assets/admin')}}/img/icons/search-white.svg"
                                        alt="img" /></a>
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
                                    <th class="text-center">Tổng đặt đơn</th>
                                    <th class="text-center">Vai trò</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th class="text-center">Action</th>
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
                                            <span class="badges  bg-lightred ">{{ $user->trangthai }}</span>
                                        @else
                                            <span class="badges  bg-lightred ">{{ $user->trangthai }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->vaitro == 'client')
                                            <a class="me-3" href="{{ route('quan-tri-vien.doi-vai-tro',$user->id) }}" onclick="return confirm('Bạn có chắc chắn nâng cấp tài khoản này thành quản trị viên ?');">
                                                <i class="text-primary" data-feather="users" data-bs-toggle="tooltip" data-bs-placement="top" title="nâng cấp quản trị viên"></i>
                                            </a>
                                        @else
                                            <a class="me-3" href="{{ route('quan-tri-vien.doi-vai-tro',$user->id) }}" onclick="return confirm('Bạn có chắc chắn nâng cấp tài khoản này thành quản trị viên ?');">
                                                <i class="text-warning" data-feather="user-minus" data-bs-toggle="tooltip" data-bs-placement="top" title="Trở về Khách hàng"></i>
                                            </a>
                                        @endif
                                        @if($user->trangthai == 'Hoạt động')
                                        <a class="" href="{{ route('quan-tri-vien.khoa-tai-khoan',$user->id) }}"
                                            onclick="return confirm('Bạn có chắc chắn muốn khóa tài khoản này ?');">
                                            <i class="text-danger" data-feather="lock" data-bs-toggle="tooltip" data-bs-placement="top" title="Khóa tài khoản"></i>
                                        </a>
                                        @else
                                        <a class="" href="{{ route('quan-tri-vien.khoa-tai-khoan',$user->id) }}"
                                            onclick="return confirm('Bạn có chắc chắn kích hoạt lại tài khoản này ?');">
                                            <i class="text-success" data-feather="unlock" data-bs-toggle="tooltip" data-bs-placement="top" title="Kích hoạt tài khoản"></i>
                                        </a>
                                        @endif
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