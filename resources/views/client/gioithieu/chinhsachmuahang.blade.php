@extends('client.layouts.app')

@section('title')
    Siêu Thị Vina - Nền Tảng Bán Hàng Trực Tuyến Siêu Thị Vina
@endsection

@section('content')
    <div class="page">
        <div class="text-sm text-gray-700" style="max-width: 900px; margin: auto; padding: 20px;">
            <h5 class="mb-0">CHÍNH SÁCH MUA HÀNG, GIAO NHẬN VÀ ĐỔI TRẢ</h5>
            <p class="mb-20 fw-medium"><em>Cập nhật lần cuối: Ngày 22 tháng 11 năm 2025</em></p>
            <h6>PHẦN 1: QUY TRÌNH MUA HÀNG VÀ THANH TOÁN</h6>

            <h6 class="text-xl mt-10 mb-2">1. Cách thức đặt hàng</h6>
            <p>Quý khách có thể đặt hàng trực tiếp thông qua hệ thống website Siêu Thị Vina 24/7. Đơn hàng của quý khách sẽ
                được hệ thống ghi nhận và nhân viên CSKH sẽ xác nhận lại trong vòng 24h (trừ ngày lễ, tết).</p>

            <h6 class="text-xl mt-10 mb-2">2. Phương thức thanh toán</h6>
            <p>Nhằm mang lại sự thuận tiện nhất, chúng tôi cung cấp các hình thức thanh toán sau:</p>
            <ul>
                <li><strong>Thanh toán khi nhận hàng (COD):</strong> Quý khách xem hàng tại nhà, thanh toán tiền mặt cho
                    nhân viên giao nhận.</li>
                <li><strong>Chuyển khoản ngân hàng:</strong> Áp dụng cho tất cả các đơn hàng. Nội dung chuyển khoản: Thanh toan don hang [Mã đơn
                    hàng].</li>
            </ul>

            <hr>

            <h6>PHẦN 2: CHÍNH SÁCH VẬN CHUYỂN (SHIPPING)</h6>
            <h6 class="text-xl mt-10 mb-2">1. Phí vận chuyển</h6>
            <ul>
                <li><strong>Nội tỉnh TP.HCM:</strong> Miễn phí vận chuyển.</li>
                <li><strong>Ngoại tỉnh (các tỉnh thành vùng lân cận):</strong> Phí ship tính theo 15.000đ cho mỗi đơn hàng</li>
            </ul>

            <h6 class="text-xl mt-10 mb-2">2. Thời gian giao hàng</h6>
            <p>Thời gian giao hàng dự kiến:</p>
            <ul>
                <li>Khu vực nội thành: 1 - 2 ngày làm việc.</li>
                <li>Khu vực ngoại thành và các tỉnh: 3 - 5 ngày làm việc.</li>
            </ul>
            <p><em>Lưu ý: Trong trường hợp bất khả kháng (thiên tai, dịch bệnh), thời gian giao hàng có thể kéo dài hơn dự
                    kiến.</em></p>

            <h6 class="text-xl mt-10 mb-2">3. Chính sách kiểm hàng (Đồng kiểm)</h6>
            <p>Siêu Thị Vina khuyến khích quý khách kiểm tra tình trạng bên ngoài của thùng hàng và sản phẩm trước khi thanh
                toán để đảm bảo rằng hàng hóa được giao đúng chủng loại, số lượng, màu sắc theo đơn đặt hàng và tình trạng
                bên ngoài không bị tác động (bể vỡ/trầy xước). Nếu gặp trường hợp này, Quý khách vui lòng từ chối nhận hàng
                và/hoặc báo ngay cho bộ phận hỗ trợ khách hàng.</p>

            <hr>

            <h6>PHẦN 3: CHÍNH SÁCH ĐỔI TRẢ VÀ HOÀN TIỀN</h6>
            <h6 class="text-xl mt-10 mb-2">1. Điều kiện đổi trả</h6>
            <p>Quý khách có quyền đổi trả sản phẩm trong vòng <strong>07 ngày</strong> kể từ ngày nhận hàng nếu:</p>
            <ul>
                <li>Sản phẩm bị lỗi do nhà sản xuất (hỏng hóc, thiếu linh kiện...).</li>
                <li>Sản phẩm bị hư hỏng trong quá trình vận chuyển.</li>
                <li>Giao sai sản phẩm, sai màu sắc, kích thước so với đơn đặt hàng.</li>
                <li>Hàng hóa vẫn còn nguyên tem mác, chưa qua sử dụng và còn đầy đủ phụ kiện/quà tặng đi kèm.</li>
            </ul>

            <h6 class="text-xl mt-10 mb-2">2. Phương thức hoàn tiền</h6>
            <p>Sau khi nhận được hàng trả về và kiểm tra đạt yêu cầu, Siêu Thị Vina sẽ hoàn tiền cho quý khách qua:</p>
            <ul>
                <li>Chuyển khoản ngân hàng (trong vòng 3-5 ngày làm việc).</li>
                <li>Hoàn tiền vào ví người dùng trên hệ thống để mua sắm lần sau.</li>
            </ul>

            <br>
            <hr>
            <footer>
                <h6 class="text-lg mb-0 text-main-600">CÔNG TY TNHH SIÊU THỊ VINA</h6>
                <p>Địa chỉ: Tầng 5, Tòa nhà Vina Building, Quận 1, TP.HCM</p>
                <p>Hotline: 1900 xxxx - Email: hotro@sieuthivina.com</p>
            </footer>
        </div>
    </div>
@endsection