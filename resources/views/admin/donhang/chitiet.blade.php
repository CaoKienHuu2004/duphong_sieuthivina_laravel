@extends('admin.layouts.app')

@section('title')
    Hệ thống quản trị Siêu Thị Vina
@endsection

@section('content')
    <div class="page-wrapper">
            <div class="content">
                <div class="card">
                    <div class="card-body">
                        <h5 class="fw-bold mb-0">Chi tiết đơn hàng <a href="#">
                                        <i data-feather="printer" class="text-black ms-2" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="In đơn hàng này"></i>
                                    </a></h5>
                        <div class="card-sales-split pb-2">
                            <h2>#{{ $donhang->madon }}
                                @if ($donhang->trangthai == 'Đã giao hàng')
                                    <span class="badges bg-lightgreen p-0 px-2 py-1">Đã giao hàng</span>
                                @elseif ($donhang->trangthai == 'Đang giao hàng')
                                    <span class="badges bg-lightblue p-0 px-2 py-1">Đang giao hàng</span>
                                @elseif ($donhang->trangthai == 'Đang đóng gói')
                                    <span class="badges bg-lightblue p-0 px-2 py-1">Đang đóng gói</span>
                                @elseif ($donhang->trangthai == 'Chờ xác nhận')
                                    <span class="badges bg-lightyellow p-0 px-2 py-1">Chờ xác nhận</span>
                                @elseif ($donhang->trangthai == 'Đã hủy')
                                    <span class="badges bg-lightred p-0 px-2 py-1">Đã hủy</span>
                                @endif
                                
                            </h2>

                            <ul>
                                <li class="mx-1">
                                    @if ($donhang->trangthai == 'Đã giao hàng')
                                        
                                    @elseif ($donhang->trangthai == 'Đang giao hàng')
                                    <form action="{{ route('quan-tri-vien.cap-nhat-trang-thai', $donhang->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="trang_thai_moi" value="Đã giao hàng">
                                        <button class="badge bg-success border-0 rounded-circle p-2" href="#" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Giao hàng thành công">
                                            <i data-feather="user-check" class="text-white"></i>
                                        </button>
                                        </form>
                                    @elseif ($donhang->trangthai == 'Đang đóng gói')
                                        <form action="{{ route('quan-tri-vien.cap-nhat-trang-thai', $donhang->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="trang_thai_moi" value="Đang giao hàng">
                                        <button class="badge bg-success border-0 rounded-circle p-2" href="#" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Tiến hành giao hàng">
                                            <i data-feather="truck" class="text-white"></i>
                                        </button>
                                        </form>
                                    @elseif ($donhang->trangthai == 'Chờ xác nhận')
                                        <form action="{{ route('quan-tri-vien.cap-nhat-trang-thai', $donhang->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="trang_thai_moi" value="Đang đóng gói">
                                        <button class="badge bg-success border-0 rounded-circle p-2" href="#" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Xác nhận đơn hàng">
                                            <i data-feather="check-circle" class="text-white"></i>
                                        </button>
                                        </form>
                                    @elseif ($donhang->trangthai == 'Đã hủy')
                                        
                                    @endif
                                    
                                </li>
                                @if ($donhang->trangthaithanhtoan != 'Đã thanh toán' && $donhang->trangthai != 'Đã giao hàng' && $donhang->trangthai != 'Đã hủy đơn')
                                    <li class="mx-1">
                                        <form action="{{ route('quan-tri-vien.da-thanh-toan', $donhang->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="border-0 p-1 rounded-circle bg-white" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Xác nhận thanh toán">
                                                {{-- <input type="hidden" name="trang_thai_moi" value="Hủy đơn hàng"> --}}
                                                <i data-feather="dollar-sign" class="text-warning"></i>
                                            </button>
                                            </form>
                                    </li>
                                @endif
                                @if ($donhang->trangthai != 'Đã hủy đơn' && $donhang->trangthai != 'Đã giao hàng')
                                    <li class="mx-1">
                                        <form action="{{ route('quan-tri-vien.cap-nhat-trang-thai', $donhang->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="trang_thai_moi" value="Hủy đơn hàng">
                                        <button class="badge bg-danger border-0 rounded-circle p-2" href="#" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Từ chối và hủy đơn"  onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');">
                                            <i data-feather="x-circle" class="text-white"></i>
                                        </button>
                                        </form>
                                    </li>
                                @endif
                                
                            </ul>
                        </div>
                        <div class=" mt-2">
                                            <table style="width: 100%;line-height: inherit;text-align: left;">
                                                <tbody>
                                                    <tr>
                                                        <td style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
                                                            <h6 class="fw-bold mb-2" style="color: #187575;">Thông tin người nhận</h6>
                                                            <p class="mb-0 text-black fw-bold">{{ $donhang->nguoinhan }}</p>
                                                            <p class="mb-0 text-black" style="font-size: 14px; width: 340px; white-space: break-spaces; overflow: hidden; text-overflow: ellipsis;"><span class="fw-bold">Địa chỉ:</span>{{ $donhang->diachinhan }}, {{ $donhang->khuvucgiao }}</p>
                                                            <p class="mb-0 text-black"><span class="fw-bold">Điện thoại:</span> {{ $donhang->sodienthoai }}</p>
                                                        </td>
                                                        <td style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
                                                            <h6 class="fw-bold mb-2" style="color: #187575;">Thông tin giao hàng</h6>
                                                            <p class="mb-0 text-black fw-bold">Giao hàng {{ $donhang->hinhthucvanchuyen }}</p>
                                                            <p class="mb-0 text-black" style="font-size: 14px; width: 340px; white-space: break-spaces; overflow: hidden; text-overflow: ellipsis;"><span class="fw-bold">Phí vận chuyển:</span> {{ number_format($donhang->phigiaohang,0,',','.') }} đ</p>
                                                            <p class="mb-0 text-black fst-"><span class="fw-bold">Khu vực giao:</span> {{ $donhang->khuvucgiao }}</p>
                                                        </td>
                                                        <td style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
                                                            <h6 class="fw-bold mb-2" style="color: #187575;">Thông tin thanh toán</h6>
                                                            <p class="mb-0 text-black fw-bold">{{ $donhang->hinhthucthanhtoan }}</p>
                                                            <p class="mb-0 text-black"><span class="fw-bold">Trạng thái:</span>
                                                                @if($donhang->trangthaithanhtoan == 'Đã thanh toán')
                                                                <span class="badges bg-lightgreen p-0 px-2 py-1">{{ $donhang->trangthaithanhtoan }}</span>
                                                                @elseif($donhang->trangthaithanhtoan == 'Chờ thanh toán')
                                                                <span class="badges bg-lightpurple p-0 px-2 py-1">{{ $donhang->trangthaithanhtoan }}</span>
                                                                @elseif($donhang->trangthaithanhtoan == 'Thanh toán khi nhận hàng')
                                                                <span class="badges bg-lightyellow p-0 px-2 py-1">{{ $donhang->trangthaithanhtoan }}</span>
                                                                @else
                                                                <span class="badges bg-lightred p-0 px-2 py-1">{{ $donhang->trangthaithanhtoan }}</span>
                                                                @endif
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>          
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <!-- có thể thêm datanew sau class table -->
                                <thead>
                                <tr>
                                    <th class="text-start">Tên sản phẩm</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($donhang->chitietdonhang as $chitiet)
                                    <tr>
                                        <td>
                                            @if($chitiet->dongia == 0)
                                                <span class="fw-bold d-flex align-items-center gap-2 mb-2" style="color: #ff6a00;"><i data-feather="gift"></i> Quà tặng ưu đãi áp dụng</span>
                                            @endif
                                            <div class="productimgname align-items-center">
                                                <a href="#" class="product-img">
                                                    <img src="{{ asset('assets/client') }}/images/thumbs/{{ $chitiet->bienthe->sanpham->hinhanhsanpham->first()->hinhanh }}" alt="{{ $chitiet->bienthe->sanpham->ten }}" style="object-fit: cover; width:60px; height: 100%;" />
                                                </a>
                                                <div>
                                                    <p class="mb-0" style="width: 400px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                        <a class="text-black" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $chitiet->bienthe->sanpham->ten }}">{{ $chitiet->bienthe->sanpham->ten }}</a>
                                                    </p>
                                                    <span class="mb-0" style="font-size: 14px;">{{ $chitiet->bienthe->loaibienthe->ten }}</span>
                                                    <span class="ms-2 fw-bold text-black" data-bs-toggle="tooltip" data-bs-placement="top" title="Số lượng: 1">x {{ $chitiet->soluong }}</span>
                                                    @if($chitiet->dongia != 0)
                                                        <span class="ms-4 fw-bold text-black" style="font-size: 15px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Thành tiền">{{ number_format($chitiet->dongia,0,',','.') }} đ</span>
                                                    @else
                                                        <span class="ms-4 fw-bold text-black" style="font-size: 15px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Quà tặng không tính phí">Miễn phí</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                        <div class="row mt-3">
                            <div class="row">
                                <div class="col-lg-6 text-center">
                                    @if ($donhang->trangthaithanhtoan != 'Đã thanh toán' && $donhang->trangthai != 'Đã giao hàng' && $donhang->trangthai != 'Đã hủy đơn' && $donhang->trangthaithanhtoan != 'Thanh toán khi nhận hàng (COD)')
                                        <img src="{{ $qrCodeUrl }}" alt="" style="width: 200px;">
                                    @endif
                                </div>
                                <div class="col-lg-6 ">
                                    <div class="total-order w-100 max-widthauto m-auto mb-4">
                                        <ul>
                                            <li>
                                                <h4>Tạm tính</h4>
                                                <h5>{{ number_format($donhang->tamtinh,0,',','.') }} đ</h5>
                                            </li>
                                            <li>
                                                <h4>Phí vận chuyển</h4>
                                                <h5 style="color: #187575;">{{ number_format($donhang->phigiaohang,0,',','.') }} đ</h5>
                                            </li>
                                            @if ($donhang->giagiam > 0)
                                                <li>
                                                    <h4>Giảm giá Voucher</h4>
                                                    <h5 class="text-success">- {{ number_format($donhang->giagiam,0,',','.') }} đ</h5>
                                                </li>
                                            @endif
                                            
                                            <li class="total">
                                                <h4 style="font-size: 16px; color: #ff6a00;">Tổng giá trị đơn hàng</h4>
                                                <h5 style="font-size: 16px; color: #ff6a00;">{{ number_format($donhang->thanhtien,0,',','.') }} đ</h5>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
@endsection

@section('scripts')
<style>
    .dt-buttons {
        display: none !important;
    }
</style>
@endsection