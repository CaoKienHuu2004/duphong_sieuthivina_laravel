@extends('client.layouts.app')

@section('title')
    Thay đổi địa chỉ giao hàng | Siêu Thị Vina -  Nền Tảng Bán Hàng Trực Tuyến Siêu Thị Vina
@endsection

@section('content')
    <div class="page">
        <section class="mt-20">
            <div class="container container-lg">
                <span class="py-10 fw-semibold text-lg text-gray-900">Thay đổi địa chỉ giao hàng</span>
                <div class="row gy-4">
                    @foreach ($diachis as $diachi)
                    <div class="col-lg-6 col-xl-6">
                        <form action="{{ route('cap-nhat-mac-dinh') }}" method="POST" class="border-dashed border-2 border-gray-500 text-main-900 rounded-8 px-10 py-8 mb-10">
                            @csrf
                            <div class="d-flex flex-align flex-between gap-24">
                                <div class="flex-align gap-12">
                                    <span class="fw-semibold text-gray-900 text-md border-end border-gray-600 pe-10">{{ $diachi->hoten }}</span>
                                    <span class="fw-semibold text-gray-900 text-md">{{ $diachi->sodienthoai }}</span>
                                </div>
                                <div class="flex-align gap-12">
                                    @if ($diachi->trangthai == 'Mặc định')
                                        <span class="fw-medium text-xs text-success-700 bg-success-100 px-6 py-2 rounded-4 flex-align gap-8">{{ $diachi->trangthai }}</span>
                                    @else
                                        <span class="fw-medium text-xs text-gray-700 bg-gray-100 px-6 py-2 rounded-4 flex-align gap-8">{{ $diachi->trangthai }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex flex-align gap-24 pt-10">
                                <div class="flex-align gap-12">
                                    <span class="fw-medium text-gray-900 text-sm">Địa chỉ: {{ $diachi->diachi }}, {{ $diachi->tinhthanh }}</span>
                                </div>
                            </div>
                            <div class="d-flex flex-align gap-24 pt-10">
                                <div class="flex-align gap-12">
                                    @if ($diachi->trangthai == 'Mặc định')
                                        <span class="text-sm bg-main-300 text-white rounded-8 px-8 py-6 w-100 transition-1 gap-8">Đặt làm mặc định</span>
                                    @else
                                        <input type="hidden" name="id_diachi" value="{{ $diachi->id }}">
                                        <button type="submit" class="text-sm bg-main-600 text-white hover-bg-white hover-text-main-900 border hover-border-main-600 rounded-8 px-8 py-6 w-100 transition-1 gap-8">Đặt làm mặc định</button>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        
    </div>
@endsection