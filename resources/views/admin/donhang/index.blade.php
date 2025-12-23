@extends('admin.layouts.app')

@section('title')
    Hệ thống quản trị Siêu Thị Vina
@endsection

@section('content')
    <div class="page-wrapper">
      <div class="content">
        <div class="page-header">
          <div class="page-title">
            <h4>Danh sách đơn hàng của bạn 
              @if($donhangs->where('trangthai','Chờ xác nhận')->count() > 0)
                  <span class="bg-danger text-white px-2 py-1 rounded-circle blinking-flash">!</span>
                  @endif
            <h6>Những đơn hàng có ở trên hệ thống của bạn</h6>
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
        <div class="card comp-section">
          <div class="card-body">
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <a class="nav-link active" href="#solid-tab1" data-bs-toggle="tab">Chờ xác nhận
                  @if($donhangs->where('trangthai','Chờ xác nhận')->count() > 0)
                  <span class="bg-danger text-white px-2 py-1 rounded-circle blinking-flash">{{ $donhangs->where('trangthai','Chờ xác nhận')->count() }}</span>
                  @else
                  (0)
                  @endif
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#solid-tab2" data-bs-toggle="tab">Đang đóng gói ({{ $donhangs->where('trangthai','Đang đóng gói')->count() }})</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#solid-tab3" data-bs-toggle="tab">Đang giao hàng ({{ $donhangs->where('trangthai','Đang giao hàng')->count() }})</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#solid-tab4" data-bs-toggle="tab">Đã giao hàng ({{ $donhangs->where('trangthai','Đã giao hàng')->count() }})</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#solid-tab5" data-bs-toggle="tab">Đã hoàn thành ({{ $donhangs->where('trangthai','Đã giao hàng')->where('trangthaithanhtoan','Đã thanh toán')->count() }})</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#solid-tab6" data-bs-toggle="tab">Đơn đã bị hủy ({{ $donhangs->where('trangthai','Đã hủy đơn')->count() }})</a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="solid-tab1 tab-pane show active" id="solid-tab1">
                <div class="row d-flex justify-content-between mb-3 align-items-center">
                  <div class="col-lg-2 form-group m-0">
                    <input type="text" class="form-control search-pane" placeholder="tìm kiếm....">
                  </div>
                  <form action="#" method="get" class="col-lg-3 m-0 form-group d-flex align-items-center justify-content-end">
                    <select class="select" name="trangthaithanhtoan" id="" onchange="this.form.submit()">
                      <option value="" selected disabled>--Trạng thái thanh toán--</option>
                      <option value="Chưa thanh toán">Chưa thanh toán</option>
                      <option value="Đã thanh toán">Đã thanh toán</option>
                    </select>
                  </form>
                </div>
                <div class="table-responsive">
                  <table class="table datanew">
                    <!-- có thể thêm datanew sau class table -->
                    <thead>
                      <tr>
                        <th class="text-start">Mã đơn</th>
                        <th class="text-start" style="width: 20px !important;">Địa chỉ giao
                          hàng</th>
                        <th class="text-start">Tổng cộng</th>
                        <th class="text-start">Ngày đặt hàng</th>
                        <th class="text-center">Trạng thái đơn hàng</th>
                        <th class="text-center">Trạng thái thanh toán</th>
                        <th class="text-center" colspan="3">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($donhangs->where('trangthai','Chờ xác nhận') as $donhang)
                        <tr>
                          <td class="text-start">
                            <a class="fw-bold" href="{{ route('quan-tri-vien.chi-tiet-don-hang',$donhang->madon) }}">#{{ $donhang->madon }}</a>
                          </td>
                          <td class="text-start">
                            <p class="fw-bold text-black m-0" style="font-size: 14px;">{{ $donhang->nguoinhan }}</p>
                            <div class="text-black" style="font-size: 14px; width: 340px; white-space: break-spaces; overflow: hidden; text-overflow: ellipsis;">{{ $donhang->diachinhan }}, {{ $donhang->khuvucgiao }}</div>
                          </td>
                          <td class="text-start text-black fw-bold"><span class="text-danger">{{ number_format($donhang->thanhtien,0,',','.') }} đ</span></td>
                          <td class="text-start text-black" style="width: 50px;">
                            {{ $donhang->created_at->format('d/m/Y - H:i') }}
                          </td>
                          <td class="text-center">
                            <span class="badges bg-lightyellow">{{ $donhang->trangthai }}</span>
                            </td>
                          <td class="text-center">
                            @if($donhang->trangthaithanhtoan == 'Đã thanh toán')
                            <span class="badges bg-lightgreen">{{ $donhang->trangthaithanhtoan }}</span>
                            @elseif($donhang->trangthaithanhtoan == 'Chờ thanh toán')
                             <a href="{{ route('quan-tri-vien.chi-tiet-don-hang',$donhang->madon) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Mã QR Thanh toán"><span class="badges bg-lightpurple">{{ $donhang->trangthaithanhtoan }}</span></a>
                            @elseif($donhang->trangthaithanhtoan == 'Thanh toán khi nhận hàng')
                              <a href="{{ route('quan-tri-vien.chi-tiet-don-hang',$donhang->madon) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Mã QR Thanh toán"><span class="badges bg-lightyellow">{{ $donhang->trangthaithanhtoan }}</span></a>
                            @else
                              <span class="badges bg-lightred">{{ $donhang->trangthaithanhtoan }}</span>
                            @endif
                          </td>
                          <td class="text-center px-1">
                            <form action="{{ route('quan-tri-vien.cap-nhat-trang-thai', $donhang->id) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <button type="submit" class="border-0 p-1 rounded-circle bg-success" data-bs-toggle="tooltip"
                                  data-bs-placement="top" title="Xác nhận đơn hàng">
                                <input type="hidden" name="trang_thai_moi" value="Đang đóng gói">
                                <i data-feather="check-circle" class="text-white"></i>
                              </button>
                            </form>
                          </td>
                          @if ($donhang->trangthaithanhtoan == 'Thanh toán khi nhận hàng' || $donhang->trangthaithanhtoan == 'Chờ thanh toán')
                          <td class="text-center px-1">
                            <form action="{{ route('quan-tri-vien.da-thanh-toan', $donhang->id) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <button type="submit" class="border-0 p-1 rounded-circle bg-warning" data-bs-toggle="tooltip"
                                  data-bs-placement="top" title="Xác nhận thanh toán">
                                {{-- <input type="hidden" name="trang_thai_moi" value="Hủy đơn hàng"> --}}
                                <i data-feather="dollar-sign" class="text-white"></i>
                              </button>
                            </form>
                          </td>
                          @else
                          <td></td>
                          @endif
                          <td class="text-center px-1">
                            <form action="{{ route('quan-tri-vien.cap-nhat-trang-thai', $donhang->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="border-0 p-1 rounded-circle bg-danger" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Từ chối và hủy đơn" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');">
                                  <input type="hidden" name="trang_thai_moi" value="Đã hủy đơn">
                                  <i data-feather="x-circle" class="text-white"></i>
                                </button>
                              </form>
                          </td>
                          
                        </tr>
                      @endforeach
                      
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="solid-tab2 tab-pane" id="solid-tab2">
                <div class="row d-flex justify-content-between mb-3 align-items-center">
                  <div class="col-lg-2 form-group m-0">
                    <input type="text" class="form-control search-pane" placeholder="tìm kiếm....">
                  </div>
                  <form action="#" method="get" class="col-lg-3 m-0 form-group d-flex align-items-center justify-content-end">
                    <select class="select" name="trangthaithanhtoan" id="" onchange="this.form.submit()">
                      <option value="" selected disabled>--Trạng thái thanh toán--</option>
                      <option value="Chưa thanh toán">Chưa thanh toán</option>
                      <option value="Đã thanh toán">Đã thanh toán</option>
                    </select>
                  </form>
                </div>
                <div class="table-responsive">
                  <table class="table datanew">
                    <!-- có thể thêm datanew sau class table -->
                    <thead>
                      <tr>
                        <th class="text-start">Mã đơn</th>
                        <th class="text-start" style="width: 20px !important;">Địa chỉ giao
                          hàng</th>
                        <th class="text-start">Tổng cộng</th>
                        <th class="text-start">Ngày đặt hàng</th>
                        <th class="text-center">Trạng thái đơn hàng</th>
                        <th class="text-center">Trạng thái thanh toán</th>
                        <th class="text-center" colspan="3">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($donhangs->where('trangthai','Đang đóng gói') as $donhang)
                        <tr>
                          <td class="text-start">
                            <a class="fw-bold" href="{{ route('quan-tri-vien.chi-tiet-don-hang',$donhang->madon) }}">#{{ $donhang->madon }}</a>
                          </td>
                          <td class="text-start">
                            <p class="fw-bold text-black m-0" style="font-size: 14px;">{{ $donhang->nguoinhan }}</p>
                            <div class="text-black" style="font-size: 14px; width: 340px; white-space: break-spaces; overflow: hidden; text-overflow: ellipsis;">{{ $donhang->diachinhan }}, {{ $donhang->khuvucgiao }}</div>
                          </td>
                          <td class="text-start text-black fw-bold"><span class="text-danger">{{ number_format($donhang->thanhtien,0,',','.') }} đ</span></td>
                          <td class="text-start text-black" style="width: 50px;">
                            {{ $donhang->created_at->format('d/m/Y - H:i') }}
                          </td>
                          <td class="text-center">
                            <span class="badges bg-lightblue">{{ $donhang->trangthai }}</span>
                            </td>
                          <td class="text-center">
                            @if($donhang->trangthaithanhtoan == 'Đã thanh toán')
                            <span class="badges bg-lightgreen">{{ $donhang->trangthaithanhtoan }}</span>
                            @elseif($donhang->trangthaithanhtoan == 'Chờ thanh toán')
                             <a href="{{ route('quan-tri-vien.chi-tiet-don-hang',$donhang->madon) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Mã QR Thanh toán"><span class="badges bg-lightpurple">{{ $donhang->trangthaithanhtoan }}</span></a>
                            @elseif($donhang->trangthaithanhtoan == 'Thanh toán khi nhận hàng')
                              <a href="{{ route('quan-tri-vien.chi-tiet-don-hang',$donhang->madon) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Mã QR Thanh toán"><span class="badges bg-lightyellow">{{ $donhang->trangthaithanhtoan }}</span></a>
                            @else
                              <span class="badges bg-lightred">{{ $donhang->trangthaithanhtoan }}</span>
                            @endif
                          </td>
                          
                          <td class="text-center px-1">
                            <form action="{{ route('quan-tri-vien.cap-nhat-trang-thai', $donhang->id) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <button type="submit" class="border-0 p-1 rounded-circle bg-success" data-bs-toggle="tooltip"
                                  data-bs-placement="top" title="Tiến hành giao hàng">
                                <input type="hidden" name="trang_thai_moi" value="Đang giao hàng">
                                <i data-feather="truck" class="text-white"></i>
                              </button>
                            </form>
                          </td>
                          @if ($donhang->trangthaithanhtoan == 'Thanh toán khi nhận hàng' || $donhang->trangthaithanhtoan == 'Chờ thanh toán')
                          <td class="text-center px-1">
                            <form action="{{ route('quan-tri-vien.da-thanh-toan', $donhang->id) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <button type="submit" class="border-0 p-1 rounded-circle bg-warning" data-bs-toggle="tooltip"
                                  data-bs-placement="top" title="Xác nhận thanh toán" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');">
                                {{-- <input type="hidden" name="trang_thai_moi" value="Hủy đơn hàng"> --}}
                                <i data-feather="dollar-sign" class="text-white"></i>
                              </button>
                            </form>
                          </td>
                          @else
                          <td></td>
                          @endif
                          <td class="text-center px-1">
                            <form action="{{ route('quan-tri-vien.cap-nhat-trang-thai', $donhang->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="border-0 p-1 rounded-circle bg-danger" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Từ chối và hủy đơn" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');">
                                  <input type="hidden" name="trang_thai_moi" value="Đã hủy đơn">
                                  <i data-feather="x-circle" class="text-white"></i>
                                </button>
                              </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="solid-tab3 tab-pane" id="solid-tab3">
                <div class="row d-flex justify-content-between mb-3 align-items-center">
                  <div class="col-lg-2 form-group m-0">
                    <input type="text" class="form-control search-pane" placeholder="tìm kiếm....">
                  </div>
                  <form action="#" method="get" class="col-lg-3 m-0 form-group d-flex align-items-center justify-content-end">
                    <select class="select" name="trangthaithanhtoan" id="" onchange="this.form.submit()">
                      <option value="" selected disabled>--Trạng thái thanh toán--</option>
                      <option value="Chưa thanh toán">Chưa thanh toán</option>
                      <option value="Đã thanh toán">Đã thanh toán</option>
                    </select>
                  </form>
                </div>
                <div class="table-responsive">
                  <table class="table datanew">
                    <!-- có thể thêm datanew sau class table -->
                    <thead>
                      <tr>
                        <th class="text-start">Mã đơn</th>
                        <th class="text-start" style="width: 20px !important;">Địa chỉ giao
                          hàng</th>
                        <th class="text-start">Tổng cộng</th>
                        <th class="text-start">Ngày đặt hàng</th>
                        <th class="text-center">Trạng thái đơn hàng</th>
                        <th class="text-center">Trạng thái thanh toán</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($donhangs->where('trangthai','Đang giao hàng') as $donhang)
                        <tr>
                          <td class="text-start">
                            <a class="fw-bold" href="{{ route('quan-tri-vien.chi-tiet-don-hang',$donhang->madon) }}">#{{ $donhang->madon }}</a>
                          </td>
                          <td class="text-start">
                            <p class="fw-bold text-black m-0" style="font-size: 14px;">{{ $donhang->nguoinhan }}</p>
                            <div class="text-black" style="font-size: 14px; width: 340px; white-space: break-spaces; overflow: hidden; text-overflow: ellipsis;">{{ $donhang->diachinhan }}, {{ $donhang->khuvucgiao }}</div>
                          </td>
                          <td class="text-start text-black fw-bold"><span class="text-danger">{{ number_format($donhang->thanhtien,0,',','.') }} đ</span></td>
                          <td class="text-start text-black" style="width: 50px;">
                            {{ $donhang->created_at->format('d/m/Y - H:i') }}
                          </td>
                          <td class="text-center">
                            <span class="badges bg-lightblue">{{ $donhang->trangthai }}</span>
                            </td>
                          <td class="text-center">
                            @if($donhang->trangthaithanhtoan == 'Đã thanh toán')
                            <span class="badges bg-lightgreen">{{ $donhang->trangthaithanhtoan }}</span>
                            @elseif($donhang->trangthaithanhtoan == 'Chờ thanh toán')
                             <a href="{{ route('quan-tri-vien.chi-tiet-don-hang',$donhang->madon) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Mã QR Thanh toán"><span class="badges bg-lightpurple">{{ $donhang->trangthaithanhtoan }}</span></a>
                            @elseif($donhang->trangthaithanhtoan == 'Thanh toán khi nhận hàng')
                              <a href="{{ route('quan-tri-vien.chi-tiet-don-hang',$donhang->madon) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Mã QR Thanh toán"><span class="badges bg-lightyellow">{{ $donhang->trangthaithanhtoan }}</span></a>
                            @else
                              <span class="badges bg-lightred">{{ $donhang->trangthaithanhtoan }}</span>
                            @endif
                          </td>
                          <td class="text-center px-1">
                            <form action="{{ route('quan-tri-vien.cap-nhat-trang-thai', $donhang->id) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <button type="submit" class="border-0 p-1 rounded-circle bg-success" data-bs-toggle="tooltip"
                                  data-bs-placement="top" title="Xác nhận đơn hàng">
                                <input type="hidden" name="trang_thai_moi" value="Đang giao hàng">
                                <i data-feather="check-circle" class="text-white"></i>
                              </button>
                            </form>
                          </td>
                          @if ($donhang->trangthaithanhtoan == 'Thanh toán khi nhận hàng' || $donhang->trangthaithanhtoan == 'Chờ thanh toán')
                          <td class="text-center px-1">
                            <form action="{{ route('quan-tri-vien.da-thanh-toan', $donhang->id) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <button type="submit" class="border-0 p-1 rounded-circle bg-warning" data-bs-toggle="tooltip"
                                  data-bs-placement="top" title="Xác nhận thanh toán" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');">
                                {{-- <input type="hidden" name="trang_thai_moi" value="Hủy đơn hàng"> --}}
                                <i data-feather="dollar-sign" class="text-white"></i>
                              </button>
                            </form>
                          </td>
                          @else
                          <td></td>
                          @endif
                          <td class="text-center px-1">
                            <form action="{{ route('quan-tri-vien.cap-nhat-trang-thai', $donhang->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="border-0 p-1 rounded-circle bg-danger" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Từ chối và hủy đơn" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');">
                                  <input type="hidden" name="trang_thai_moi" value="Đã hủy đơn">
                                  <i data-feather="x-circle" class="text-white"></i>
                                </button>
                              </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="solid-tab4 tab-pane" id="solid-tab4">
                <div class="row d-flex justify-content-between mb-3 align-items-center">
                  <div class="col-lg-2 form-group m-0">
                    <input type="text" class="form-control search-pane" placeholder="tìm kiếm....">
                  </div>
                  <form action="#" method="get" class="col-lg-3 m-0 form-group d-flex align-items-center justify-content-end">
                    <select class="select" name="trangthaithanhtoan" id="" onchange="this.form.submit()">
                      <option value="" selected disabled>--Trạng thái thanh toán--</option>
                      <option value="Chưa thanh toán">Chưa thanh toán</option>
                      <option value="Đã thanh toán">Đã thanh toán</option>
                    </select>
                  </form>
                </div>
                <div class="table-responsive">
                  <table class="table datanew">
                    <!-- có thể thêm datanew sau class table -->
                    <thead>
                      <tr>
                        <th class="text-start">Mã đơn</th>
                        <th class="text-start" style="width: 20px !important;">Địa chỉ giao
                          hàng</th>
                        <th class="text-start">Tổng cộng</th>
                        <th class="text-start">Ngày đặt hàng</th>
                        <th class="text-center">Trạng thái đơn hàng</th>
                        <th class="text-center">Trạng thái thanh toán</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($donhangs->where('trangthai','Đã giao hàng') as $donhang)
                        <tr>
                          <td class="text-start">
                            <a class="fw-bold" href="{{ route('quan-tri-vien.chi-tiet-don-hang',$donhang->madon) }}">#{{ $donhang->madon }}</a>
                          </td>
                          <td class="text-start">
                            <p class="fw-bold text-black m-0" style="font-size: 14px;">{{ $donhang->nguoinhan }}</p>
                            <div class="text-black" style="font-size: 14px; width: 340px; white-space: break-spaces; overflow: hidden; text-overflow: ellipsis;">{{ $donhang->diachinhan }}, {{ $donhang->khuvucgiao }}</div>
                          </td>
                          <td class="text-start text-black fw-bold"><span class="text-danger">{{ number_format($donhang->thanhtien,0,',','.') }} đ</span></td>
                          <td class="text-start text-black" style="width: 50px;">
                            {{ $donhang->created_at->format('d/m/Y - H:i') }}
                          </td>
                          <td class="text-center">
                            <span class="badges bg-lightgreen">{{ $donhang->trangthai }}</span>
                            </td>
                          <td class="text-center">
                            @if($donhang->trangthaithanhtoan == 'Đã thanh toán')
                            <span class="badges bg-lightgreen">{{ $donhang->trangthaithanhtoan }}</span>
                            @elseif($donhang->trangthaithanhtoan == 'Chờ thanh toán')
                             <a href="{{ route('quan-tri-vien.chi-tiet-don-hang',$donhang->madon) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Mã QR Thanh toán"><span class="badges bg-lightpurple">{{ $donhang->trangthaithanhtoan }}</span></a>
                            @elseif($donhang->trangthaithanhtoan == 'Thanh toán khi nhận hàng')
                              <a href="{{ route('quan-tri-vien.chi-tiet-don-hang',$donhang->madon) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Mã QR Thanh toán"><span class="badges bg-lightyellow">{{ $donhang->trangthaithanhtoan }}</span></a>
                            @else
                              <span class="badges bg-lightred">{{ $donhang->trangthaithanhtoan }}</span>
                            @endif
                          </td>
                          <td class="text-center">
                            @if ($donhang->trangthaithanhtoan == 'Thanh toán khi nhận hàng' || $donhang->trangthaithanhtoan == 'Chờ thanh toán')
                              <a class="me-3" href="editproduct.html">
                                <i data-feather="dollar-sign" class="text-warning" data-bs-toggle="tooltip"
                                  data-bs-placement="top" title="Tiến hành thanh toán"></i>
                              </a>
                            @endif
                            <a class="me-3" href="editproduct.html">
                            <i data-feather="eye" class="text-black" data-bs-toggle="tooltip" data-bs-placement="top"
                              title="Xem chi tiết đơn hàng"></i>
                          </a>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="solid-tab5 tab-pane" id="solid-tab5">
                <div class="row d-flex justify-content-between mb-3 align-items-center">
                  <div class="col-lg-2 form-group m-0">
                    <input type="text" class="form-control search-pane" placeholder="tìm kiếm....">
                  </div>
                  <form action="#" method="get" class="col-lg-3 m-0 form-group d-flex align-items-center justify-content-end">
                    <select class="select" name="trangthaithanhtoan" id="" onchange="this.form.submit()">
                      <option value="" selected disabled>--Trạng thái thanh toán--</option>
                      <option value="Chưa thanh toán">Chưa thanh toán</option>
                      <option value="Đã thanh toán">Đã thanh toán</option>
                    </select>
                  </form>
                </div>
                <div class="table-responsive">
                  <table class="table datanew">
                    <!-- có thể thêm datanew sau class table -->
                    <thead>
                      <tr>
                        <th class="text-start">Mã đơn</th>
                        <th class="text-start" style="width: 20px !important;">Địa chỉ giao
                          hàng</th>
                        <th class="text-start">Tổng cộng</th>
                        <th class="text-start">Ngày đặt hàng</th>
                        <th class="text-center">Trạng thái đơn hàng</th>
                        <th class="text-center">Trạng thái thanh toán</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($donhangs->where('trangthai','Đã giao hàng')->where('trangthaithanhtoan','Đã thanh toán') as $donhang)
                        <tr>
                          <td class="text-start">
                            <a class="fw-bold" href="{{ route('quan-tri-vien.chi-tiet-don-hang',$donhang->madon) }}">#{{ $donhang->madon }}</a>
                          </td>
                          <td class="text-start">
                            <p class="fw-bold text-black m-0" style="font-size: 14px;">{{ $donhang->nguoinhan }}</p>
                            <div class="text-black" style="font-size: 14px; width: 340px; white-space: break-spaces; overflow: hidden; text-overflow: ellipsis;">{{ $donhang->diachinhan }}, {{ $donhang->khuvucgiao }}</div>
                          </td>
                          <td class="text-start text-black fw-bold"><span class="text-danger">{{ number_format($donhang->thanhtien,0,',','.') }} đ</span></td>
                          <td class="text-start text-black" style="width: 50px;">
                            {{ $donhang->created_at->format('d/m/Y - H:i') }}
                          </td>
                          <td class="text-center">
                            <span class="badges bg-lightgreen">{{ $donhang->trangthai }}</span>
                            </td>
                          <td class="text-center">
                            @if($donhang->trangthaithanhtoan == 'Đã thanh toán')
                            <span class="badges bg-lightgreen">{{ $donhang->trangthaithanhtoan }}</span>
                            @elseif($donhang->trangthaithanhtoan == 'Chờ thanh toán')
                             <a href="{{ route('quan-tri-vien.chi-tiet-don-hang',$donhang->madon) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Mã QR Thanh toán"><span class="badges bg-lightpurple">{{ $donhang->trangthaithanhtoan }}</span></a>
                            @elseif($donhang->trangthaithanhtoan == 'Thanh toán khi nhận hàng')
                              <a href="{{ route('quan-tri-vien.chi-tiet-don-hang',$donhang->madon) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Mã QR Thanh toán"><span class="badges bg-lightyellow">{{ $donhang->trangthaithanhtoan }}</span></a>
                            @else
                              <span class="badges bg-lightred">{{ $donhang->trangthaithanhtoan }}</span>
                            @endif
                          </td>
                          <td class="text-center">
                            <a class="me-3" href="editproduct.html">
                            <i data-feather="eye" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="top"
                              title="Xem chi tiết đơn hàng"></i>
                          </a>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="solid-tab6 tab-pane" id="solid-tab6">
                <div class="row d-flex justify-content-between mb-3 align-items-center">
                  <div class="col-lg-2 form-group m-0">
                    <input type="text" class="form-control search-pane" placeholder="tìm kiếm....">
                  </div>
                  <form action="#" method="get" class="col-lg-3 m-0 form-group d-flex align-items-center justify-content-end">
                    <select class="select" name="trangthaithanhtoan" id="" onchange="this.form.submit()">
                      <option value="" selected disabled>--Trạng thái thanh toán--</option>
                      <option value="Chưa thanh toán">Chưa thanh toán</option>
                      <option value="Đã thanh toán">Đã thanh toán</option>
                    </select>
                  </form>
                </div>
                <div class="table-responsive">
                  <table class="table datanew">
                    <!-- có thể thêm datanew sau class table -->
                    <thead>
                      <tr>
                        <th class="text-start">Mã đơn</th>
                        <th class="text-start" style="width: 20px !important;">Địa chỉ giao
                          hàng</th>
                        <th class="text-start">Tổng cộng</th>
                        <th class="text-start">Ngày đặt hàng</th>
                        <th class="text-center">Trạng thái đơn hàng</th>
                        <th class="text-center">Trạng thái thanh toán</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($donhangs->where('trangthai','Đã hủy đơn') as $donhang)
                        <tr>
                          <td class="text-start">
                            <a class="fw-bold" href="{{ route('quan-tri-vien.chi-tiet-don-hang',$donhang->madon) }}">#{{ $donhang->madon }}</a>
                          </td>
                          <td class="text-start">
                            <p class="fw-bold text-black m-0" style="font-size: 14px;">{{ $donhang->nguoinhan }}</p>
                            <div class="text-black" style="font-size: 14px; width: 340px; white-space: break-spaces; overflow: hidden; text-overflow: ellipsis;">{{ $donhang->diachinhan }}, {{ $donhang->khuvucgiao }}</div>
                          </td>
                          <td class="text-start text-black fw-bold"><span class="text-danger">{{ number_format($donhang->thanhtien,0,',','.') }} đ</span></td>
                          <td class="text-start text-black" style="width: 50px;">
                            {{ $donhang->created_at->format('d/m/Y - H:i') }}
                          </td>
                          <td class="text-center">
                            <span class="badges bg-lightred">{{ $donhang->trangthai }}</span>
                            </td>
                          <td class="text-center">
                            @if($donhang->trangthaithanhtoan == 'Đã thanh toán')
                            <span class="badges bg-lightgreen">{{ $donhang->trangthaithanhtoan }}</span>
                            @elseif($donhang->trangthaithanhtoan == 'Chờ thanh toán')
                             <a href="{{ route('quan-tri-vien.chi-tiet-don-hang',$donhang->madon) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Mã QR Thanh toán"><span class="badges bg-lightpurple">{{ $donhang->trangthaithanhtoan }}</span></a>
                            @elseif($donhang->trangthaithanhtoan == 'Thanh toán khi nhận hàng')
                              <a href="{{ route('quan-tri-vien.chi-tiet-don-hang',$donhang->madon) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Mã QR Thanh toán"><span class="badges bg-lightyellow">{{ $donhang->trangthaithanhtoan }}</span></a>
                            @else
                              <span class="badges bg-lightred">{{ $donhang->trangthaithanhtoan }}</span>
                            @endif
                          </td>
                          <td class="text-center">
                            <a class="me-3" href="editproduct.html">
                            <i data-feather="eye" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                              title="Xem chi tiết đơn hàng"></i>
                          </a>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
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