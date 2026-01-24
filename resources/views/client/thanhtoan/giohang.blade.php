@extends('client.layouts.app')

@section('title')
    Siêu Thị Vina -  Nền Tảng Bán Hàng Trực Tuyến Siêu Thị Vina
@endsection

@section('content')
    <div class="page">
         <section class="cart py-20">
            <livewire:GiohangComponent />
        </section>
    </div>
@endsection