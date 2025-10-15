-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th10 15, 2025 lúc 08:01 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `laravel_ecomvina_v3`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `baiviet`
--

CREATE TABLE `baiviet` (
  `id` int(11) NOT NULL,
  `id_nguoidung` int(11) NOT NULL,
  `tieude` text NOT NULL,
  `slug` text NOT NULL,
  `noidung` longtext NOT NULL,
  `luotxem` int(11) NOT NULL DEFAULT 0,
  `hinhanh` varchar(255) NOT NULL,
  `trangthai` enum('Hiển thị','Tạm ẩn') NOT NULL DEFAULT 'Hiển thị',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `baiviet`
--

INSERT INTO `baiviet` (`id`, `id_nguoidung`, `tieude`, `slug`, `noidung`, `luotxem`, `hinhanh`, `trangthai`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 'Kinh Đô là một thương hiệu gắn liền với trung thu tại việt nam.', 'kinh-do-la-mot-thuong-hieu-gan-lien-voi-trung-thu-tai-viet-nam', 'Kinh Đô là một thương hiệu gắn liền với ngành bánh kẹo và thực phẩm của Việt Nam, nổi tiếng với các sản phẩm được người tiêu dùng cả nước ưa chuộng, đặc biệt là trong các dịp lễ, Tết.', 2, 'kinh-do-trung-thu.png', 'Hiển thị', '2025-10-15 09:50:51', '2025-10-15 07:11:03', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bienthe`
--

CREATE TABLE `bienthe` (
  `id` int(11) NOT NULL,
  `id_loaibienthe` int(11) NOT NULL,
  `id_sanpham` int(11) NOT NULL,
  `giagoc` int(11) NOT NULL,
  `soluong` int(11) NOT NULL DEFAULT 0,
  `trangthai` enum('Còn hàng','Hết hàng','Sắp hết hàng') DEFAULT 'Còn hàng',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `bienthe`
--

INSERT INTO `bienthe` (`id`, `id_loaibienthe`, `id_sanpham`, `giagoc`, `soluong`, `trangthai`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 270000, 10, 'Còn hàng', '2025-10-10 06:56:49', '2025-10-10 06:56:49', NULL),
(2, 2, 2, 385000, 10, 'Còn hàng', '2025-10-10 07:05:14', '2025-10-10 07:05:14', NULL),
(3, 1, 3, 466560, 10, 'Còn hàng', '2025-10-10 07:06:58', '2025-10-10 07:06:58', NULL),
(4, 1, 4, 260000, 10, 'Còn hàng', '2025-10-10 07:06:58', '2025-10-10 07:06:58', NULL),
(5, 2, 5, 512000, 10, 'Còn hàng', '2025-10-10 07:19:41', '2025-10-10 07:19:41', NULL),
(6, 1, 6, 270000, 2, 'Còn hàng', '2025-10-11 14:57:46', '2025-10-11 14:57:46', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitiet_donhang`
--

CREATE TABLE `chitiet_donhang` (
  `id` int(11) NOT NULL,
  `id_bienthe` int(11) NOT NULL,
  `id_donhang` int(11) NOT NULL,
  `soluong` int(11) NOT NULL,
  `dongia` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chitiet_donhang`
--

INSERT INTO `chitiet_donhang` (`id`, `id_bienthe`, `id_donhang`, `soluong`, `dongia`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 50000, '2025-10-15 05:21:29', '2025-10-15 05:21:29'),
(2, 5, 1, 1, 50000, '2025-10-15 05:21:29', '2025-10-15 05:21:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhgia`
--

CREATE TABLE `danhgia` (
  `id` int(11) NOT NULL,
  `id_sanpham` int(11) NOT NULL,
  `id_nguoidung` int(11) NOT NULL,
  `diem` int(11) NOT NULL,
  `noidung` text DEFAULT NULL,
  `trangthai` enum('Hiển thị','Tạm ẩn') NOT NULL DEFAULT 'Hiển thị',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `danhgia`
--

INSERT INTO `danhgia` (`id`, `id_sanpham`, `id_nguoidung`, `diem`, `noidung`, `trangthai`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 2, 1, 'sản phẩm chất lượng', 'Hiển thị', '2025-10-15 09:48:20', '2025-10-15 09:48:20', NULL),
(2, 1, 3, 5, 'sản phẩm chất lượng', 'Hiển thị', '2025-10-15 14:34:08', '2025-10-15 14:34:08', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmuc`
--

CREATE TABLE `danhmuc` (
  `id` int(11) NOT NULL,
  `ten` varchar(255) NOT NULL,
  `slug` text NOT NULL,
  `logo` varchar(255) NOT NULL DEFAULT 'danhmuc.jpg',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `danhmuc`
--

INSERT INTO `danhmuc` (`id`, `ten`, `slug`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'Sức khỏe', 'suc-khoe', 'suc-khoe.svg', '2025-10-10 07:22:53', '2025-10-10 07:22:53'),
(2, 'Thực phẩm chức năng', 'thuc-pham-chuc-nang', 'thuc-pham-chuc-nang.svg', '2025-10-10 07:24:35', '2025-10-10 07:24:35'),
(3, 'Chăm sóc cá nhân', 'cham-soc-ca-nhan', 'cham-soc-ca-nhan.svg', '2025-10-10 07:45:15', '2025-10-10 07:45:15'),
(4, 'Làm đẹp', 'lam-dep', 'lam-dep.svg', '2025-10-10 07:48:26', '2025-10-10 07:48:26'),
(5, 'Điện máy', 'dien-may', 'dien-may.svg', '2025-10-10 07:48:26', '2025-10-10 07:48:26'),
(6, 'Thiết bị y tế', 'thiet-bi-y-te', 'thiet-bi-y-te.svg', '2025-10-10 07:48:26', '2025-10-10 07:48:26'),
(7, 'Bách hóa', 'bach-hoa', 'bach-hoa.svg', '2025-10-10 07:48:26', '2025-10-10 07:48:26'),
(8, 'Nội thất - Trang trí', 'noi-that-trang-tri', 'noi-that-trang-tri.svg', '2025-10-10 07:48:26', '2025-10-10 07:48:26'),
(9, 'Mẹ & bé', 'me-va-be', 'me-va-be.svg', '2025-10-10 07:48:26', '2025-10-10 07:48:26'),
(10, 'Thời trang', 'thoi-trang', 'thoi-trang.svg', '2025-10-10 07:48:26', '2025-10-10 07:48:26'),
(11, 'Thực phẩm - đồ ăn', 'thuc-pham-do-an', 'thuc-pham-do-an.svg', '2025-10-10 07:48:26', '2025-10-10 07:48:26');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmuc_sanpham`
--

CREATE TABLE `danhmuc_sanpham` (
  `id` int(11) NOT NULL,
  `id_danhmuc` int(11) NOT NULL,
  `id_sanpham` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `danhmuc_sanpham`
--

INSERT INTO `danhmuc_sanpham` (`id`, `id_danhmuc`, `id_sanpham`, `created_at`, `updated_at`) VALUES
(1, 1, 5, '2025-10-10 07:27:45', '2025-10-10 07:27:45'),
(2, 1, 4, '2025-10-10 07:27:45', '2025-10-10 07:27:45'),
(3, 2, 1, '2025-10-10 07:27:45', '2025-10-10 07:27:45'),
(4, 2, 3, '2025-10-10 07:27:45', '2025-10-10 07:27:45'),
(5, 1, 2, '2025-10-10 07:27:45', '2025-10-10 07:27:45');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `diachi_nguoidung`
--

CREATE TABLE `diachi_nguoidung` (
  `id` int(11) NOT NULL,
  `id_nguoidung` int(11) NOT NULL,
  `hoten` varchar(255) NOT NULL,
  `sodienthoai` varchar(10) NOT NULL,
  `diachi` text NOT NULL,
  `trangthai` enum('Mặc định','Khác','Tạm ẩn') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `diachi_nguoidung`
--

INSERT INTO `diachi_nguoidung` (`id`, `id_nguoidung`, `hoten`, `sodienthoai`, `diachi`, `trangthai`, `created_at`, `updated_at`, `deleted_at`) VALUES
(0, 2, 'Nguyễn Văn Admin', '9876543211', '101 Nguyễn Tất Thành, p1, q.12, tp.HCM', 'Mặc định', '2025-10-15 12:53:24', '2025-10-15 12:53:24', NULL),
(1, 3, 'Nguyễn Văn Demo', '9876543212', '110 nguyễn tất thành, p.3, q.12, tp.HCM', 'Mặc định', '2025-10-15 09:56:57', '2025-10-15 09:56:57', NULL),
(2, 2, 'Nguyễn Văn Admin', '9876543211', '90 Nguyễn Tất Thành, p.2, q.12, tp.HCM', 'Khác', '2025-10-15 12:55:40', '2025-10-15 12:55:40', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

CREATE TABLE `donhang` (
  `id` int(11) NOT NULL,
  `id_nguoidung` int(11) NOT NULL,
  `id_phuongthuc` int(11) NOT NULL,
  `id_magiamgia` int(11) DEFAULT NULL,
  `madon` varchar(10) NOT NULL,
  `tongsoluong` int(11) NOT NULL,
  `thanhtien` int(11) NOT NULL,
  `trangthai` enum('Chờ xử lý','Đã chấp nhận','Đang giao hàng','Đã giao hàng','Đã hủy đơn') NOT NULL DEFAULT 'Chờ xử lý',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `donhang`
--

INSERT INTO `donhang` (`id`, `id_nguoidung`, `id_phuongthuc`, `id_magiamgia`, `madon`, `tongsoluong`, `thanhtien`, `trangthai`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 1, 1, 'ecomvina15', 2, 100000, 'Chờ xử lý', '2025-10-15 05:20:22', '2025-10-15 05:20:22', NULL),
(2, 3, 1, 1, 'ecomvina15', 2, 100000, 'Chờ xử lý', '2025-10-15 09:55:11', '2025-10-15 09:55:11', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

CREATE TABLE `giohang` (
  `id` int(11) NOT NULL,
  `id_bienthe` int(11) NOT NULL,
  `id_nguoidung` int(11) NOT NULL,
  `soluong` int(11) NOT NULL,
  `thanhtien` int(11) NOT NULL,
  `trangthai` enum('Hiển thị','Tạm ẩn') NOT NULL DEFAULT 'Hiển thị',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `giohang`
--

INSERT INTO `giohang` (`id`, `id_bienthe`, `id_nguoidung`, `soluong`, `thanhtien`, `trangthai`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 2, 100000, 'Hiển thị', '2025-10-15 09:53:17', '2025-10-15 09:53:17'),
(2, 2, 2, 2, 100000, 'Hiển thị', '2025-10-15 09:53:58', '2025-10-15 09:53:58');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hinhanh_sanpham`
--

CREATE TABLE `hinhanh_sanpham` (
  `id` int(11) NOT NULL,
  `id_sanpham` int(11) NOT NULL,
  `hinhanh` varchar(255) NOT NULL,
  `trangthai` enum('Hiển thị','Tạm ẩn') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `hinhanh_sanpham`
--

INSERT INTO `hinhanh_sanpham` (`id`, `id_sanpham`, `hinhanh`, `trangthai`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'keo-ong-xanh-tracybee-propolis-mint-honey-giam-dau-rat-hong-ho-viem-hong-vi-bac-ha-1.webp', 'Hiển thị', '2025-10-10 07:10:24', '2025-10-10 07:10:24', NULL),
(2, 1, 'keo-ong-xanh-tracybee-propolis-mint-honey-giam-dau-rat-hong-ho-viem-hong-vi-bac-ha-2.webp', 'Hiển thị', '2025-10-10 07:10:24', '2025-10-10 07:10:24', NULL),
(3, 1, 'keo-ong-xanh-tracybee-propolis-mint-honey-giam-dau-rat-hong-ho-viem-hong-vi-bac-ha-3.webp', 'Hiển thị', '2025-10-10 07:10:24', '2025-10-10 07:10:24', NULL),
(4, 1, 'keo-ong-xanh-tracybee-propolis-mint-honey-giam-dau-rat-hong-ho-viem-hong-vi-bac-ha-4.webp', 'Hiển thị', '2025-10-10 07:10:24', '2025-10-10 07:10:24', NULL),
(5, 2, 'mat-ong-tay-bac-dong-trung-ha-thao-x3-hu-240g-1.webp', 'Hiển thị', '2025-10-10 07:13:57', '2025-10-10 07:13:57', NULL),
(6, 2, 'mat-ong-tay-bac-dong-trung-ha-thao-x3-hu-240g-2.webp', 'Hiển thị', '2025-10-10 07:13:57', '2025-10-10 07:13:57', NULL),
(7, 2, 'mat-ong-tay-bac-dong-trung-ha-thao-x3-hu-240g-3.webp', 'Hiển thị', '2025-10-10 07:13:57', '2025-10-10 07:13:57', NULL),
(8, 3, 'sam-ngoc-linh-truong-sinh-do-thung-24lon-1.webp', 'Hiển thị', '2025-10-10 07:16:36', '2025-10-10 07:16:36', NULL),
(9, 3, 'sam-ngoc-linh-truong-sinh-do-thung-24lon-2.webp', 'Hiển thị', '2025-10-10 07:16:36', '2025-10-10 07:16:36', NULL),
(10, 3, 'sam-ngoc-linh-truong-sinh-do-thung-24lon-3.webp', 'Hiển thị', '2025-10-10 07:16:36', '2025-10-10 07:16:36', NULL),
(11, 3, 'sam-ngoc-linh-truong-sinh-do-thung-24lon-4.webp', 'Hiển thị', '2025-10-10 07:16:36', '2025-10-10 07:16:36', NULL),
(12, 3, 'sam-ngoc-linh-truong-sinh-do-thung-24lon-5.webp', 'Hiển thị', '2025-10-10 07:16:36', '2025-10-10 07:16:36', NULL),
(13, 4, 'tinh-dau-tram-tu-nhien-eco-ho-tro-giam-ho-cam-cum-so-mui-cam-lanh-lo-30ml-1.webp', 'Hiển thị', '2025-10-10 07:18:38', '2025-10-10 07:18:38', NULL),
(14, 4, 'tinh-dau-tram-tu-nhien-eco-ho-tro-giam-ho-cam-cum-so-mui-cam-lanh-lo-30ml-2.webp', 'Hiển thị', '2025-10-10 07:18:38', '2025-10-10 07:18:38', NULL),
(15, 4, 'tinh-dau-tram-tu-nhien-eco-ho-tro-giam-ho-cam-cum-so-mui-cam-lanh-lo-30ml-3.webp', 'Hiển thị', '2025-10-10 07:18:38', '2025-10-10 07:18:38', NULL),
(16, 5, 'sua-non-to-yen-papamilk-height-gain-giup-tang-can-tang-chieu-cao-cho-tre-tu-1-19-tuoi-lon-830g-1.webp', 'Hiển thị', '2025-10-10 07:22:36', '2025-10-10 07:22:36', NULL),
(17, 5, 'sua-non-to-yen-papamilk-height-gain-giup-tang-can-tang-chieu-cao-cho-tre-tu-1-19-tuoi-lon-830g-2.webp', 'Hiển thị', '2025-10-10 07:22:36', '2025-10-10 07:22:36', NULL),
(18, 5, 'sua-non-to-yen-papamilk-height-gain-giup-tang-can-tang-chieu-cao-cho-tre-tu-1-19-tuoi-lon-830g-3.webp', 'Hiển thị', '2025-10-10 07:22:36', '2025-10-10 07:22:36', NULL),
(19, 5, 'sua-non-to-yen-papamilk-height-gain-giup-tang-can-tang-chieu-cao-cho-tre-tu-1-19-tuoi-lon-830g-4.webp', 'Hiển thị', '2025-10-10 07:22:36', '2025-10-10 07:22:36', NULL),
(20, 5, 'sua-non-to-yen-papamilk-height-gain-giup-tang-can-tang-chieu-cao-cho-tre-tu-1-19-tuoi-lon-830g-5.webp', 'Hiển thị', '2025-10-10 07:22:36', '2025-10-10 07:22:36', NULL),
(21, 5, 'sua-non-to-yen-papamilk-height-gain-giup-tang-can-tang-chieu-cao-cho-tre-tu-1-19-tuoi-lon-830g-6.webp', 'Hiển thị', '2025-10-10 07:22:36', '2025-10-10 07:22:36', NULL),
(22, 6, 'sam-ngoc-linh-truong-sinh-do-thung-24lon-1.webp', 'Tạm ẩn', '2025-10-11 14:58:11', '2025-10-11 14:58:11', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaibienthe`
--

CREATE TABLE `loaibienthe` (
  `id` int(11) NOT NULL,
  `ten` varchar(255) NOT NULL,
  `trangthai` enum('Hiển thị','Tạm ẩn') NOT NULL DEFAULT 'Hiển thị',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `loaibienthe`
--

INSERT INTO `loaibienthe` (`id`, `ten`, `trangthai`, `created_at`, `updated_at`) VALUES
(1, 'Lọ', 'Hiển thị', '2025-10-10 06:55:28', '2025-10-10 06:55:28'),
(2, 'Hộp', 'Hiển thị', '2025-10-10 07:04:13', '2025-10-10 07:04:13');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `magiamgia`
--

CREATE TABLE `magiamgia` (
  `id` int(11) NOT NULL,
  `magiamgia` int(11) NOT NULL,
  `dieukien` varchar(255) NOT NULL,
  `mota` text DEFAULT NULL,
  `giatri` int(11) NOT NULL,
  `ngaybatdau` date NOT NULL,
  `ngayketthuc` date NOT NULL,
  `trangthai` enum('Hoạt động','Tạm khóa','Dừng hoạt động') NOT NULL DEFAULT 'Hoạt động',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `magiamgia`
--

INSERT INTO `magiamgia` (`id`, `magiamgia`, `dieukien`, `mota`, `giatri`, `ngaybatdau`, `ngayketthuc`, `trangthai`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 321321, 'là khách hàng mới', 'là khách hàng mới sẽ được giảm 20%', 0, '2025-10-09', '2025-10-31', 'Hoạt động', '2025-10-15 05:12:20', '2025-10-15 05:12:20', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
--

CREATE TABLE `nguoidung` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `sodienthoai` varchar(10) NOT NULL,
  `hoten` varchar(255) NOT NULL,
  `gioitinh` enum('Nam','Nữ') NOT NULL,
  `ngaysinh` date NOT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT 'khachhang.jpg',
  `vaitro` enum('admin','seller','client') NOT NULL,
  `trangthai` enum('Hoạt động','Tạm khóa','Dừng hoạt động') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoidung`
--

INSERT INTO `nguoidung` (`id`, `username`, `password`, `sodienthoai`, `hoten`, `gioitinh`, `ngaysinh`, `avatar`, `vaitro`, `trangthai`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'lyhuu123', '$2y$12$wIPmnGuR2oUT9MrzYAIiK.Tv8Sy6dXA5CLEySQ8vZguis7JjilWBu', '0845381121', 'Cao Kiến Hựu', 'Nam', '2004-10-13', 'khachhang.jpg', 'admin', 'Hoạt động', '2025-10-10 06:43:52', '2025-10-10 06:43:52', NULL),
(2, 'admindemo', '$2y$12$wIPmnGuR2oUT9MrzYAIiK.Tv8Sy6dXA5CLEySQ8vZguis7JjilWBu', '9876543212', 'admindemo', 'Nam', '2000-09-06', 'khachhang.jpg', 'admin', 'Hoạt động', '2025-10-15 05:00:01', '2025-10-15 05:00:01', NULL),
(3, 'userdemo', '$2y$12$wIPmnGuR2oUT9MrzYAIiK.Tv8Sy6dXA5CLEySQ8vZguis7JjilWBu', '987654323', 'userdemo', 'Nam', '2000-01-02', 'khachhang.jpg', 'client', 'Hoạt động', '2025-10-15 09:52:19', '2025-10-15 09:52:19', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phuongthuc`
--

CREATE TABLE `phuongthuc` (
  `id` int(11) NOT NULL,
  `ten` varchar(255) NOT NULL,
  `maphuongthuc` text DEFAULT NULL,
  `trangthai` enum('Hoạt động','Tạm khóa','Dừng hoạt động') NOT NULL DEFAULT 'Hoạt động',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phuongthuc`
--

INSERT INTO `phuongthuc` (`id`, `ten`, `maphuongthuc`, `trangthai`, `created_at`, `updated_at`) VALUES
(1, 'Thanh toán khi nhận hàng(Cash on delivery)', 'cod', 'Hoạt động', '2025-10-15 05:16:32', '2025-10-15 05:16:32'),
(2, 'Chuyển khoản ngân hàng trực tiếp(\nDirect Bank transfer)', 'dbt', 'Hoạt động', '2025-10-15 05:17:03', '2025-10-15 05:17:03'),
(3, 'Kiểm tra thanh toán(Check payments)', 'cp', 'Hoạt động', '2025-10-15 05:17:52', '2025-10-15 05:17:52');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quangcao`
--

CREATE TABLE `quangcao` (
  `id` int(11) NOT NULL,
  `vitri` enum('home_banner_slider','home_banner_event_1','home_banner_event_2','home_banner_event_3','home_banner_event_4','home_banner_promotion_1','home_banner_promotion_2','home_banner_promotion_3','home_banner_ads','home_banner_product') NOT NULL,
  `hinhanh` varchar(255) NOT NULL,
  `lienket` text NOT NULL,
  `mota` text NOT NULL,
  `trangthai` enum('Hiển thị','Tạm ẩn') NOT NULL DEFAULT 'Hiển thị',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `quangcao`
--

INSERT INTO `quangcao` (`id`, `vitri`, `hinhanh`, `lienket`, `mota`, `trangthai`, `created_at`, `updated_at`) VALUES
(1, 'home_banner_slider', 'banner-droppii-1.png', 'https://droppii.vn', 'Liên kết đến Droppii Mall', 'Hiển thị', '2025-10-11 06:29:37', '2025-10-11 06:29:37'),
(2, 'home_banner_slider', 'banner-droppii-2.png', 'https://droppii.vn', 'Liên kết đến Droppii Mall', 'Hiển thị', '2025-10-11 06:29:37', '2025-10-11 06:29:37'),
(3, 'home_banner_slider', 'banner-droppii-3.png', 'https://droppii.vn', 'Liên kết đến Droppii Mall', 'Hiển thị', '2025-10-11 06:29:37', '2025-10-11 06:29:37'),
(4, 'home_banner_event_1', 'shopee-1.jpg', 'https://shopee.tw', 'Liên kết đến Shopee', 'Hiển thị', '2025-10-11 06:34:31', '2025-10-11 06:34:31'),
(5, 'home_banner_event_2', 'shopee-2.jpg', 'https://shopee.tw', 'liên kết đến Shopee', 'Hiển thị', '2025-10-11 06:34:31', '2025-10-11 06:34:31'),
(6, 'home_banner_event_3', 'shopee-3.jpg', 'https://shopee.tw', 'Liên kết đến Shopee', 'Hiển thị', '2025-10-11 06:34:31', '2025-10-11 06:34:31'),
(7, 'home_banner_event_4', 'shopee-04.webp', 'https://shopee.tw', 'Liên kết đến shopee', 'Hiển thị', '2025-10-11 06:34:31', '2025-10-11 06:34:31'),
(8, 'home_banner_promotion_1', 'shopee-05.jpg', 'https://shopee.tw', 'Liên kết đến shopee', 'Hiển thị', '2025-10-11 06:37:07', '2025-10-11 06:37:07'),
(9, 'home_banner_promotion_2', 'shopee-06.jpg', 'https://shopee.tw', 'Liên kết đến shopee', 'Hiển thị', '2025-10-11 06:37:07', '2025-10-11 06:37:07'),
(10, 'home_banner_promotion_3', 'shopee-07.jpg', 'https://shopee.tw', 'Liên kết đến shopee', 'Hiển thị', '2025-10-11 06:37:07', '2025-10-11 06:37:07'),
(11, 'home_banner_ads', 'shopee-05.jpg', 'https://shopee.tw', 'Liên kết đến shopee', 'Hiển thị', '2025-10-11 06:40:36', '2025-10-11 06:40:36'),
(12, 'home_banner_product', 'shopee-09.jfif', 'https://shopee.tw', 'Liên kết đến Shopee', 'Hiển thị', '2025-10-11 06:40:36', '2025-10-11 06:40:36');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quatang_sukien`
--

CREATE TABLE `quatang_sukien` (
  `id` int(11) NOT NULL,
  `id_bienthe` int(11) NOT NULL,
  `id_thuonghieu` int(11) NOT NULL,
  `id_sukien` int(11) NOT NULL,
  `soluongapdung` int(11) NOT NULL,
  `tieude` text NOT NULL,
  `thongtin` longtext NOT NULL,
  `trangthai` enum('Hiển thị','Tạm ẩn') NOT NULL DEFAULT 'Hiển thị',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `quatang_sukien`
--

INSERT INTO `quatang_sukien` (`id`, `id_bienthe`, `id_thuonghieu`, `id_sukien`, `soluongapdung`, `tieude`, `thongtin`, `trangthai`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 2, 1, 2, 'Kinh Đô nhân diệp trung thu giảm giá các mặc hàng bánh kẹo', 'Kinh Đô là một thương hiệu gắn liền với ngành bánh kẹo và thực phẩm của Việt Nam, nổi tiếng với các sản phẩm được người tiêu dùng cả nước ưa chuộng, đặc biệt là trong các dịp lễ, Tết. ', 'Hiển thị', '2025-10-15 09:47:21', '2025-10-15 09:47:21', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `id` int(11) NOT NULL,
  `id_thuonghieu` int(11) NOT NULL,
  `ten` text NOT NULL,
  `slug` text NOT NULL,
  `mota` longtext NOT NULL,
  `xuatxu` varchar(255) DEFAULT NULL,
  `sanxuat` varchar(255) DEFAULT NULL,
  `trangthai` enum('Công khai','Chờ duyệt','Tạm ẩn','Tạm khóa') NOT NULL DEFAULT 'Chờ duyệt',
  `giamgia` int(11) NOT NULL DEFAULT 0,
  `luotxem` int(11) NOT NULL DEFAULT 0,
  `luotban` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Sản phẩm';

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`id`, `id_thuonghieu`, `ten`, `slug`, `mota`, `xuatxu`, `sanxuat`, `trangthai`, `giamgia`, `luotxem`, `luotban`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Keo ong xanh Tracybee Propolis Mint & Honey – Giảm đau rát họng, ho, viêm họng (Vị Bạc Hà)', 'keo-ong-xanh-tracybee-propolis-mint-honey-giam-dau-rat-hong-ho-viem-hong-vi-bac-ha', 'Bạn đang tìm kiếm giải pháp kháng khuẩn tự nhiên và giảm đau họng tức thì? Keo ong xanh Tracybee Propolis Mint & Honey là sự kết hợp hoàn hảo giữa dược liệu quý từ thiên nhiên và hương vị the mát, giúp bạn vượt qua những cơn đau rát họng, ho và viêm họng khó chịu một cách nhanh chóng.', 'Brazil', 'Nhập khẩu chính ngạch bởi Siêu Thị Vina', 'Công khai', 10, 0, 10, '2025-10-10 06:52:46', '2025-10-10 06:52:46', NULL),
(2, 1, 'Mật ong Tây Bắc đông trùng hạ thảo X3 (Hũ 240g)', 'mat-ong-tay-bac-dong-trung-ha-thao-x3-hu-240g', 'Mật ong Tây Bắc Đông Trùng Hạ Thảo X3 là siêu phẩm bồi bổ sức khỏe, kết hợp giữa mật ong rừng Tây Bắc nguyên chất và hàm lượng Đông Trùng Hạ Thảo được tăng cường gấp 3 lần (X3). Sản phẩm mang đến giải pháp tiện lợi và hiệu quả tối ưu để nâng cao thể trạng, tăng cường đề kháng và phục hồi sức khỏe.', 'Việt Nam', 'Việt Nam', 'Công khai', 20, 0, 100, '2025-10-10 07:03:55', '2025-10-10 07:03:55', NULL),
(3, 1, 'Sâm Ngọc Linh trường sinh đỏ (Thùng 24lon)', 'sam-ngoc-linh-truong-sinh-do-thung-24lon', 'Sâm Ngọc Linh Trường Sinh Đỏ là tinh hoa của dược liệu quý hiếm, mang đến giải pháp tiện lợi để bồi bổ sức khỏe và nâng cao thể trạng mỗi ngày. Được chiết xuất từ Sâm Ngọc Linh quý giá – \"Quốc bảo của Việt Nam\" – sản phẩm ở dạng lon uống liền giúp bạn hấp thu trọn vẹn dưỡng chất một cách nhanh chóng và hiệu quả.', 'Việt Nam', 'Việt Nam', 'Công khai', 10, 0, 0, '2025-10-10 07:03:55', '2025-10-10 07:03:55', NULL),
(4, 1, 'Tinh dầu tràm tự nhiên ECO - Hỗ trợ giảm ho, cảm cúm, sổ mũi, cảm lạnh (Lọ 30ml)', 'tinh-dau-tram-tu-nhien-eco-ho-tro-giam-ho-cam-cum-so-mui-cam-lanh-lo-30ml', 'Tinh Dầu Tràm Tự Nhiên ECO là sản phẩm chiết xuất 100% từ lá tràm nguyên chất, mang trong mình những công dụng truyền thống tuyệt vời trong việc bảo vệ sức khỏe, đặc biệt là hệ hô hấp. Với khả năng kháng khuẩn, làm ấm và thư giãn, Tinh dầu Tràm ECO là người bạn đồng hành không thể thiếu trong tủ thuốc gia đình, giúp đối phó hiệu quả với các triệu chứng cảm thông thường.', 'Việt Nam', 'Việt Nam', 'Công khai', 85, 0, 0, '2025-10-10 07:03:55', '2025-10-10 07:03:55', NULL),
(5, 1, 'Sữa non tổ yến Papamilk Height & Gain giúp tăng cân tăng chiều cao cho Trẻ từ 1-19 tuổi - Lon 830G', 'sua-non-to-yen-papamilk-height-gain-giup-tang-can-tang-chieu-cao-cho-tre-tu-1-19-tuoi-lon-830g', 'Sữa Non Tổ Yến Papamilk Height & Gain là công thức dinh dưỡng đột phá được thiết kế chuyên biệt để hỗ trợ tăng cân khỏe mạnh và tối ưu hóa chiều cao cho trẻ em và thanh thiếu niên từ 1 đến 19 tuổi. Sự kết hợp độc đáo giữa Sữa Non cao cấp, Tổ Yến quý giá cùng hệ dưỡng chất khoa học giúp con bạn xây dựng nền tảng vững chắc cho một tương lai phát triển vượt trội.', 'Việt Nam', 'Việt Nam', 'Công khai', 20, 0, 0, '2025-10-10 07:03:55', '2025-10-10 07:03:55', NULL),
(6, 1, 'hahaha', 'hahahaha', 'ádasdasd', 'ss', 'ss', 'Công khai', 20, 1, 2, '2025-10-11 14:57:25', '2025-10-11 14:57:25', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sukien`
--

CREATE TABLE `sukien` (
  `id` int(11) NOT NULL,
  `tieude` text NOT NULL,
  `slug` text NOT NULL,
  `hinhanh` varchar(255) NOT NULL,
  `noidung` longtext NOT NULL,
  `ngaybatdau` date NOT NULL,
  `ngayketthuc` date NOT NULL,
  `trangthai` enum('Hiển thị','Tạm ẩn') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sukien`
--

INSERT INTO `sukien` (`id`, `tieude`, `slug`, `hinhanh`, `noidung`, `ngaybatdau`, `ngayketthuc`, `trangthai`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Giảm giá sập sàn mùa trung thu', 'giam-gia-sap-san-mua-trung-thu', 'giam-gia-sap-san-mua-trung-thu.png', 'Giảm giá sập sàn mùa trung thu với các mặt hàng của đến từ thương hiệu kinh đô', '2025-10-01', '2025-10-31', 'Hiển thị', '2025-10-15 09:42:02', '2025-10-15 09:42:02', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thongbao`
--

CREATE TABLE `thongbao` (
  `id` int(11) NOT NULL,
  `id_nguoidung` int(11) NOT NULL,
  `tieude` text NOT NULL,
  `noidung` text NOT NULL,
  `lienket` text DEFAULT NULL,
  `trangthai` enum('Đã đọc','Chưa đọc','Tạm ẩn') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `thongbao`
--

INSERT INTO `thongbao` (`id`, `id_nguoidung`, `tieude`, `noidung`, `lienket`, `trangthai`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 'Bạn có đơn hàng mới ', 'Bạn có đơn hàng mới mới đã được xác nhận', NULL, 'Chưa đọc', '2025-10-15 09:59:13', '2025-10-15 09:59:13', NULL),
(2, 2, 'test admin gửi thông báo cho admin postmen', '', 'test admin gửi thông báo cho admin postmen', 'Chưa đọc', '2025-10-15 13:49:19', '2025-10-15 13:49:19', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thuonghieu`
--

CREATE TABLE `thuonghieu` (
  `id` int(11) NOT NULL,
  `ten` text NOT NULL,
  `slug` text DEFAULT NULL,
  `mota` longtext DEFAULT NULL,
  `trangthai` enum('Hiển thị','Tạm ẩn') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `thuonghieu`
--

INSERT INTO `thuonghieu` (`id`, `ten`, `slug`, `mota`, `trangthai`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Vina Mild', 'Vina-Mild', 'Vina Mild nhãn hiệu bán chạy nhất ', 'Hiển thị', '2025-10-15 03:45:58', '2025-10-15 03:45:58', NULL),
(2, 'kinh đô', 'kinh-do', 'Kinh Đô là một thương hiệu gắn liền với ngành bánh kẹo và thực phẩm của Việt Nam, nổi tiếng với các sản phẩm được người tiêu dùng cả nước ưa chuộng, đặc biệt là trong các dịp lễ, Tết.', 'Hiển thị', '2025-10-15 09:44:50', '2025-10-15 09:44:50', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tukhoa`
--

CREATE TABLE `tukhoa` (
  `id` int(11) NOT NULL,
  `tukhoa` text NOT NULL,
  `luottruycap` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tukhoa`
--

INSERT INTO `tukhoa` (`id`, `tukhoa`, `luottruycap`) VALUES
(1, 'Máy massage', 5),
(2, 'Điện gia dụng', 1),
(3, 'Đồ chơi minecraft', 152),
(4, 'Sách hán ngữ 3', 596),
(5, 'Huyndai decor', 62),
(6, 'Điện nội thất', 125),
(7, 'Móc khóa genshin', 246),
(8, 'Phiền Muộn Của Afratu', 9),
(9, 'Kẹo', 50),
(10, 'Sâm Ngọc Linh', 606),
(11, 'Thầy Hộ', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `yeuthich`
--

CREATE TABLE `yeuthich` (
  `id` int(11) NOT NULL,
  `id_nguoidung` int(11) NOT NULL,
  `id_sanpham` int(11) NOT NULL,
  `trangthai` enum('Hiển thị','Tạm ẩn') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `yeuthich`
--

INSERT INTO `yeuthich` (`id`, `id_nguoidung`, `id_sanpham`, `trangthai`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'Hiển thị', '2025-10-15 09:59:37', '2025-10-15 09:59:37'),
(2, 2, 4, 'Hiển thị', '2025-10-15 11:11:55', '2025-10-15 11:11:55');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `baiviet`
--
ALTER TABLE `baiviet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nguoidung` (`id_nguoidung`);

--
-- Chỉ mục cho bảng `bienthe`
--
ALTER TABLE `bienthe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sanpham` (`id_sanpham`),
  ADD KEY `id_loaibienthe` (`id_loaibienthe`);

--
-- Chỉ mục cho bảng `chitiet_donhang`
--
ALTER TABLE `chitiet_donhang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_bienthe` (`id_bienthe`),
  ADD KEY `id_donhang` (`id_donhang`);

--
-- Chỉ mục cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nguoidung` (`id_nguoidung`),
  ADD KEY `id_sanpham` (`id_sanpham`);

--
-- Chỉ mục cho bảng `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `danhmuc_sanpham`
--
ALTER TABLE `danhmuc_sanpham`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_danhmuc` (`id_danhmuc`),
  ADD KEY `id_sanpham` (`id_sanpham`);

--
-- Chỉ mục cho bảng `diachi_nguoidung`
--
ALTER TABLE `diachi_nguoidung`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nguoidung` (`id_nguoidung`);

--
-- Chỉ mục cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nguoidung` (`id_nguoidung`),
  ADD KEY `id_magiamgia` (`id_magiamgia`),
  ADD KEY `id_phuongthuc` (`id_phuongthuc`);

--
-- Chỉ mục cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_bienthe` (`id_bienthe`),
  ADD KEY `id_nguoidung` (`id_nguoidung`);

--
-- Chỉ mục cho bảng `hinhanh_sanpham`
--
ALTER TABLE `hinhanh_sanpham`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sanpham` (`id_sanpham`);

--
-- Chỉ mục cho bảng `loaibienthe`
--
ALTER TABLE `loaibienthe`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `magiamgia`
--
ALTER TABLE `magiamgia`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `phuongthuc`
--
ALTER TABLE `phuongthuc`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `quangcao`
--
ALTER TABLE `quangcao`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `quatang_sukien`
--
ALTER TABLE `quatang_sukien`
  ADD KEY `id_bienthe` (`id_bienthe`),
  ADD KEY `id_cuahang` (`id_thuonghieu`),
  ADD KEY `id_sukien` (`id_sukien`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`id`),
  ADD KEY `thuonghieu_ibfk_1` (`id_thuonghieu`);

--
-- Chỉ mục cho bảng `sukien`
--
ALTER TABLE `sukien`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `thongbao`
--
ALTER TABLE `thongbao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nguoidung` (`id_nguoidung`);

--
-- Chỉ mục cho bảng `thuonghieu`
--
ALTER TABLE `thuonghieu`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tukhoa`
--
ALTER TABLE `tukhoa`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `yeuthich`
--
ALTER TABLE `yeuthich`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_nguoidung` (`id_nguoidung`,`id_sanpham`),
  ADD KEY `id_sanpham` (`id_sanpham`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bienthe`
--
ALTER TABLE `bienthe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `danhmuc`
--
ALTER TABLE `danhmuc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `danhmuc_sanpham`
--
ALTER TABLE `danhmuc_sanpham`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `hinhanh_sanpham`
--
ALTER TABLE `hinhanh_sanpham`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `loaibienthe`
--
ALTER TABLE `loaibienthe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `quangcao`
--
ALTER TABLE `quangcao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `tukhoa`
--
ALTER TABLE `tukhoa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `baiviet`
--
ALTER TABLE `baiviet`
  ADD CONSTRAINT `baiviet_ibfk_1` FOREIGN KEY (`id_nguoidung`) REFERENCES `nguoidung` (`id`);

--
-- Các ràng buộc cho bảng `bienthe`
--
ALTER TABLE `bienthe`
  ADD CONSTRAINT `bienthe_ibfk_1` FOREIGN KEY (`id_sanpham`) REFERENCES `sanpham` (`id`),
  ADD CONSTRAINT `bienthe_ibfk_2` FOREIGN KEY (`id_loaibienthe`) REFERENCES `loaibienthe` (`id`);

--
-- Các ràng buộc cho bảng `chitiet_donhang`
--
ALTER TABLE `chitiet_donhang`
  ADD CONSTRAINT `chitiet_donhang_ibfk_1` FOREIGN KEY (`id_bienthe`) REFERENCES `bienthe` (`id`),
  ADD CONSTRAINT `chitiet_donhang_ibfk_2` FOREIGN KEY (`id_donhang`) REFERENCES `donhang` (`id`);

--
-- Các ràng buộc cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  ADD CONSTRAINT `danhgia_ibfk_1` FOREIGN KEY (`id_nguoidung`) REFERENCES `nguoidung` (`id`),
  ADD CONSTRAINT `danhgia_ibfk_2` FOREIGN KEY (`id_sanpham`) REFERENCES `sanpham` (`id`);

--
-- Các ràng buộc cho bảng `danhmuc_sanpham`
--
ALTER TABLE `danhmuc_sanpham`
  ADD CONSTRAINT `danhmuc_sanpham_ibfk_1` FOREIGN KEY (`id_danhmuc`) REFERENCES `danhmuc` (`id`),
  ADD CONSTRAINT `danhmuc_sanpham_ibfk_2` FOREIGN KEY (`id_sanpham`) REFERENCES `sanpham` (`id`);

--
-- Các ràng buộc cho bảng `diachi_nguoidung`
--
ALTER TABLE `diachi_nguoidung`
  ADD CONSTRAINT `diachi_nguoidung_ibfk_1` FOREIGN KEY (`id_nguoidung`) REFERENCES `nguoidung` (`id`);

--
-- Các ràng buộc cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`id_nguoidung`) REFERENCES `nguoidung` (`id`),
  ADD CONSTRAINT `donhang_ibfk_2` FOREIGN KEY (`id_magiamgia`) REFERENCES `magiamgia` (`id`),
  ADD CONSTRAINT `donhang_ibfk_3` FOREIGN KEY (`id_phuongthuc`) REFERENCES `phuongthuc` (`id`);

--
-- Các ràng buộc cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD CONSTRAINT `giohang_ibfk_1` FOREIGN KEY (`id_bienthe`) REFERENCES `bienthe` (`id`),
  ADD CONSTRAINT `giohang_ibfk_2` FOREIGN KEY (`id_nguoidung`) REFERENCES `nguoidung` (`id`);

--
-- Các ràng buộc cho bảng `hinhanh_sanpham`
--
ALTER TABLE `hinhanh_sanpham`
  ADD CONSTRAINT `hinhanh_sanpham_ibfk_1` FOREIGN KEY (`id_sanpham`) REFERENCES `sanpham` (`id`);

--
-- Các ràng buộc cho bảng `quatang_sukien`
--
ALTER TABLE `quatang_sukien`
  ADD CONSTRAINT `quatang_sukien_ibfk_1` FOREIGN KEY (`id_bienthe`) REFERENCES `bienthe` (`id`),
  ADD CONSTRAINT `quatang_sukien_ibfk_3` FOREIGN KEY (`id_sukien`) REFERENCES `sukien` (`id`),
  ADD CONSTRAINT `thuonghieu_quatang_sukien_ibfk_2` FOREIGN KEY (`id_thuonghieu`) REFERENCES `thuonghieu` (`id`);

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `thuonghieu_ibfk_1` FOREIGN KEY (`id_thuonghieu`) REFERENCES `thuonghieu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `thongbao`
--
ALTER TABLE `thongbao`
  ADD CONSTRAINT `thongbao_ibfk_1` FOREIGN KEY (`id_nguoidung`) REFERENCES `nguoidung` (`id`);

--
-- Các ràng buộc cho bảng `yeuthich`
--
ALTER TABLE `yeuthich`
  ADD CONSTRAINT `yeuthich_ibfk_1` FOREIGN KEY (`id_nguoidung`) REFERENCES `nguoidung` (`id`),
  ADD CONSTRAINT `yeuthich_ibfk_2` FOREIGN KEY (`id_sanpham`) REFERENCES `sanpham` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
