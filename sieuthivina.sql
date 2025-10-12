-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20251008.967007883e
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 12, 2025 at 04:00 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sieuthivina`
--

-- --------------------------------------------------------

--
-- Table structure for table `baiviet`
--

CREATE TABLE `baiviet` (
  `id` int NOT NULL,
  `id_nguoidung` int NOT NULL,
  `tieude` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `noidung` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `luotxem` int NOT NULL DEFAULT '0',
  `hinhanh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `trangthai` enum('Hiển thị','Tạm ẩn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hiển thị',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bienthe`
--

CREATE TABLE `bienthe` (
  `id` int NOT NULL,
  `id_loaibienthe` int NOT NULL,
  `id_sanpham` int NOT NULL,
  `giagoc` int NOT NULL,
  `soluong` int NOT NULL DEFAULT '0',
  `trangthai` enum('Còn hàng','Hết hàng','Sắp hết hàng') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Còn hàng',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bienthe`
--

INSERT INTO `bienthe` (`id`, `id_loaibienthe`, `id_sanpham`, `giagoc`, `soluong`, `trangthai`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 270000, 10, 'Còn hàng', '2025-10-10 06:56:49', '2025-10-10 06:56:49', NULL),
(2, 2, 2, 385000, 10, 'Còn hàng', '2025-10-10 07:05:14', '2025-10-10 07:05:14', NULL),
(3, 1, 3, 466560, 10, 'Còn hàng', '2025-10-10 07:06:58', '2025-10-10 07:06:58', NULL),
(4, 1, 4, 260000, 10, 'Còn hàng', '2025-10-10 07:06:58', '2025-10-10 07:06:58', NULL),
(5, 2, 5, 512000, 10, 'Còn hàng', '2025-10-10 07:19:41', '2025-10-10 07:19:41', NULL),
(6, 1, 6, 270000, 2, 'Còn hàng', '2025-10-11 14:57:46', '2025-10-11 14:57:46', NULL),
(7, 2, 9, 360000, 253, 'Còn hàng', '2025-10-12 04:53:19', '2025-10-12 04:53:19', NULL),
(8, 1, 9, 260000, 5, 'Còn hàng', '2025-10-12 04:53:19', '2025-10-12 04:53:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chitiet_donhang`
--

CREATE TABLE `chitiet_donhang` (
  `id` int NOT NULL,
  `id_bienthe` int NOT NULL,
  `id_donhang` int NOT NULL,
  `soluong` int NOT NULL,
  `dongia` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cuahang`
--

CREATE TABLE `cuahang` (
  `id` int NOT NULL,
  `id_nguoidung` int NOT NULL,
  `ten` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mota` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'logo_shop.jpg',
  `bianen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bianen-shop.jpg',
  `giayphep` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `luottheodoi` int NOT NULL DEFAULT '0',
  `luotban` int NOT NULL DEFAULT '0',
  `sodienthoai` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `diachi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `trangthai` enum('Hoạt động','Tạm khóa','Dừng hoạt động') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cuahang`
--

INSERT INTO `cuahang` (`id`, `id_nguoidung`, `ten`, `slug`, `mota`, `logo`, `bianen`, `giayphep`, `luottheodoi`, `luotban`, `sodienthoai`, `diachi`, `trangthai`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Trung Tâm Bán Hàng Siêu Thị Vina', 'trung-tam-ban-hang-sieu-thi-vina', 'Chào mừng đến với Trung Tâm Bán Hàng Siêu Thị Vina, nơi hội tụ hàng ngàn sản phẩm chất lượng cao, đáp ứng mọi nhu cầu sinh hoạt, ẩm thực và tiêu dùng của gia đình bạn. Chúng tôi tự hào mang đến một không gian mua sắm hiện đại, tiện nghi và thân thiện, giúp bạn tiết kiệm tối đa thời gian và chi phí.', 'logo_shop.jpg', 'bianen-shop.jpg', NULL, 0, 0, '0845381121', 'Đài Loan', 'Hoạt động', '2025-10-10 06:48:11', '2025-10-10 06:48:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `danhgia`
--

CREATE TABLE `danhgia` (
  `id` int NOT NULL,
  `id_sanpham` int NOT NULL,
  `id_nguoidung` int NOT NULL,
  `diem` int NOT NULL,
  `noidung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `trangthai` enum('Hiển thị','Tạm ẩn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hiển thị',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `danhmuc`
--

CREATE TABLE `danhmuc` (
  `id` int NOT NULL,
  `ten` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'danhmuc.jpg',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `danhmuc`
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
-- Table structure for table `danhmuc_sanpham`
--

CREATE TABLE `danhmuc_sanpham` (
  `id` int NOT NULL,
  `id_danhmuc` int NOT NULL,
  `id_sanpham` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `danhmuc_sanpham`
--

INSERT INTO `danhmuc_sanpham` (`id`, `id_danhmuc`, `id_sanpham`, `created_at`, `updated_at`) VALUES
(1, 1, 5, '2025-10-10 07:27:45', '2025-10-10 07:27:45'),
(2, 1, 4, '2025-10-10 07:27:45', '2025-10-10 07:27:45'),
(3, 2, 1, '2025-10-10 07:27:45', '2025-10-10 07:27:45'),
(4, 2, 3, '2025-10-10 07:27:45', '2025-10-10 07:27:45'),
(5, 1, 2, '2025-10-10 07:27:45', '2025-10-10 07:27:45');

-- --------------------------------------------------------

--
-- Table structure for table `diachi_nguoidung`
--

CREATE TABLE `diachi_nguoidung` (
  `id` int NOT NULL,
  `id_nguoidung` int NOT NULL,
  `hoten` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sodienthoai` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `diachi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `trangthai` enum('Mặc định','Khác','Tạm ẩn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donhang`
--

CREATE TABLE `donhang` (
  `id` int NOT NULL,
  `id_nguoidung` int NOT NULL,
  `id_phuongthuc` int NOT NULL,
  `id_magiamgia` int DEFAULT NULL,
  `madon` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tongsoluong` int NOT NULL,
  `thanhtien` int NOT NULL,
  `trangthai` enum('Chờ xử lý','Đã chấp nhận','Đang giao hàng','Đã giao hàng','Đã hủy đơn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Chờ xử lý',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `giohang`
--

CREATE TABLE `giohang` (
  `id` int NOT NULL,
  `id_bienthe` int NOT NULL,
  `id_nguoidung` int NOT NULL,
  `soluong` int NOT NULL,
  `thanhtien` int NOT NULL,
  `trangthai` enum('Hiển thị','Tạm ẩn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hiển thị',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hinhanh_sanpham`
--

CREATE TABLE `hinhanh_sanpham` (
  `id` int NOT NULL,
  `id_sanpham` int NOT NULL,
  `hinhanh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `trangthai` enum('Hiển thị','Tạm ẩn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hiển thị',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hinhanh_sanpham`
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
(22, 6, 'sam-ngoc-linh-truong-sinh-do-thung-24lon-1.webp', 'Hiển thị', '2025-10-11 14:58:11', '2025-10-11 14:58:11', NULL),
(23, 9, 'thuc-pham-bao-ve-suc-khoe-midu-menaq7-180mcg-1.webp', 'Hiển thị', '2025-10-12 04:57:44', '2025-10-12 04:57:44', NULL),
(24, 9, 'thuc-pham-bao-ve-suc-khoe-midu-menaq7-180mcg-2.webp', 'Hiển thị', '2025-10-12 04:57:44', '2025-10-12 04:57:44', NULL),
(25, 9, 'thuc-pham-bao-ve-suc-khoe-midu-menaq7-180mcg-3.webp', 'Hiển thị', '2025-10-12 04:57:44', '2025-10-12 04:57:44', NULL),
(26, 9, 'thuc-pham-bao-ve-suc-khoe-midu-menaq7-180mcg-4.webp', 'Hiển thị', '2025-10-12 04:57:44', '2025-10-12 04:57:44', NULL),
(27, 9, 'thuc-pham-bao-ve-suc-khoe-midu-menaq7-180mcg-5.webp', 'Hiển thị', '2025-10-12 04:57:44', '2025-10-12 04:57:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `loaibienthe`
--

CREATE TABLE `loaibienthe` (
  `id` int NOT NULL,
  `ten` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `trangthai` enum('Hiển thị','Tạm ẩn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hiển thị',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loaibienthe`
--

INSERT INTO `loaibienthe` (`id`, `ten`, `trangthai`, `created_at`, `updated_at`) VALUES
(1, 'Lọ', 'Hiển thị', '2025-10-10 06:55:28', '2025-10-10 06:55:28'),
(2, 'Hộp', 'Hiển thị', '2025-10-10 07:04:13', '2025-10-10 07:04:13');

-- --------------------------------------------------------

--
-- Table structure for table `magiamgia`
--

CREATE TABLE `magiamgia` (
  `id` int NOT NULL,
  `magiamgia` int NOT NULL,
  `dieukien` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mota` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `giatri` int NOT NULL,
  `ngaybatdau` date NOT NULL,
  `ngayketthuc` date NOT NULL,
  `trangthai` enum('Hoạt động','Tạm khóa','Dừng hoạt động') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hoạt động',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nguoidung`
--

CREATE TABLE `nguoidung` (
  `id` int NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sodienthoai` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hoten` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gioitinh` enum('Nam','Nữ') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngaysinh` date NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'khachhang.jpg',
  `vaitro` enum('admin','seller','client') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `trangthai` enum('Hoạt động','Tạm khóa','Dừng hoạt động') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nguoidung`
--

INSERT INTO `nguoidung` (`id`, `username`, `password`, `sodienthoai`, `hoten`, `gioitinh`, `ngaysinh`, `avatar`, `vaitro`, `trangthai`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'lyhuu123', '123@#', '0845381121', 'Cao Kiến Hựu', 'Nam', '2004-10-13', 'khachhang.jpg', 'seller', 'Hoạt động', '2025-10-10 06:43:52', '2025-10-10 06:43:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phuongthuc`
--

CREATE TABLE `phuongthuc` (
  `id` int NOT NULL,
  `ten` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `maphuongthuc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `trangthai` enum('Hoạt động','Tạm khóa','Dừng hoạt động') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hoạt động',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quangcao`
--

CREATE TABLE `quangcao` (
  `id` int NOT NULL,
  `vitri` enum('home_banner_slider','home_banner_event_1','home_banner_event_2','home_banner_event_3','home_banner_event_4','home_banner_promotion_1','home_banner_promotion_2','home_banner_promotion_3','home_banner_ads','home_banner_product') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hinhanh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lienket` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mota` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `trangthai` enum('Hiển thị','Tạm ẩn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hiển thị',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quangcao`
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
-- Table structure for table `quatang_sukien`
--

CREATE TABLE `quatang_sukien` (
  `id` int NOT NULL,
  `id_bienthe` int NOT NULL,
  `id_cuahang` int NOT NULL,
  `id_sukien` int NOT NULL,
  `soluongapdung` int NOT NULL,
  `tieude` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thongtin` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `trangthai` enum('Hiển thị','Tạm ẩn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hiển thị',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quatang_sukien`
--

INSERT INTO `quatang_sukien` (`id`, `id_bienthe`, `id_cuahang`, `id_sukien`, `soluongapdung`, `tieude`, `thongtin`, `trangthai`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1, 2, 'Ưu đãi sinh nhật 13/10 - Tặng 1 sản phẩm bất kỳ', 'Mua 2 sản phẩm từ Trung Tâm Bán Hàng Siêu Thị Vina để nhận được ưu đãi tặng 1 sản phẩm nhân ngày sinh nhật 13/10', 'Hiển thị', '2025-10-12 05:36:17', '2025-10-12 05:36:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sanpham`
--

CREATE TABLE `sanpham` (
  `id` int NOT NULL,
  `id_cuahang` int NOT NULL,
  `ten` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mota` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `xuatxu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sanxuat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trangthai` enum('Công khai','Chờ duyệt','Tạm ẩn','Tạm khóa') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Chờ duyệt',
  `giamgia` int NOT NULL DEFAULT '0',
  `luotxem` int NOT NULL DEFAULT '0',
  `luotban` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `thuonghieu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Sản phẩm';

--
-- Dumping data for table `sanpham`
--

INSERT INTO `sanpham` (`id`, `id_cuahang`, `ten`, `slug`, `mota`, `xuatxu`, `sanxuat`, `trangthai`, `giamgia`, `luotxem`, `luotban`, `created_at`, `updated_at`, `deleted_at`, `thuonghieu`) VALUES
(1, 1, 'Keo ong xanh Tracybee Propolis Mint & Honey – Giảm đau rát họng, ho, viêm họng (Vị Bạc Hà)', 'keo-ong-xanh-tracybee-propolis-mint-honey-giam-dau-rat-hong-ho-viem-hong-vi-bac-ha', 'Bạn đang tìm kiếm giải pháp kháng khuẩn tự nhiên và giảm đau họng tức thì? Keo ong xanh Tracybee Propolis Mint & Honey là sự kết hợp hoàn hảo giữa dược liệu quý từ thiên nhiên và hương vị the mát, giúp bạn vượt qua những cơn đau rát họng, ho và viêm họng khó chịu một cách nhanh chóng.', 'Brazil', 'Nhập khẩu chính ngạch bởi Siêu Thị Vina', 'Công khai', 10, 0, 10, '2025-10-10 06:52:46', '2025-10-10 06:52:46', NULL, 'TRACBEE'),
(2, 1, 'Mật ong Tây Bắc đông trùng hạ thảo X3 (Hũ 240g)', 'mat-ong-tay-bac-dong-trung-ha-thao-x3-hu-240g', 'Mật ong Tây Bắc Đông Trùng Hạ Thảo X3 là siêu phẩm bồi bổ sức khỏe, kết hợp giữa mật ong rừng Tây Bắc nguyên chất và hàm lượng Đông Trùng Hạ Thảo được tăng cường gấp 3 lần (X3). Sản phẩm mang đến giải pháp tiện lợi và hiệu quả tối ưu để nâng cao thể trạng, tăng cường đề kháng và phục hồi sức khỏe.', 'Việt Nam', 'Việt Nam', 'Công khai', 20, 0, 100, '2025-10-10 07:03:55', '2025-10-10 07:03:55', NULL, 'TRUNG NHÂN'),
(3, 1, 'Sâm Ngọc Linh trường sinh đỏ (Thùng 24lon)', 'sam-ngoc-linh-truong-sinh-do-thung-24lon', 'Sâm Ngọc Linh Trường Sinh Đỏ là tinh hoa của dược liệu quý hiếm, mang đến giải pháp tiện lợi để bồi bổ sức khỏe và nâng cao thể trạng mỗi ngày. Được chiết xuất từ Sâm Ngọc Linh quý giá – \"Quốc bảo của Việt Nam\" – sản phẩm ở dạng lon uống liền giúp bạn hấp thu trọn vẹn dưỡng chất một cách nhanh chóng và hiệu quả.', 'Việt Nam', 'Việt Nam', 'Công khai', 10, 0, 0, '2025-10-10 07:03:55', '2025-10-10 07:03:55', NULL, '\r\nTRUONG SINH GROUP'),
(4, 1, 'Tinh dầu tràm tự nhiên ECO - Hỗ trợ giảm ho, cảm cúm, sổ mũi, cảm lạnh (Lọ 30ml)', 'tinh-dau-tram-tu-nhien-eco-ho-tro-giam-ho-cam-cum-so-mui-cam-lanh-lo-30ml', 'Tinh Dầu Tràm Tự Nhiên ECO là sản phẩm chiết xuất 100% từ lá tràm nguyên chất, mang trong mình những công dụng truyền thống tuyệt vời trong việc bảo vệ sức khỏe, đặc biệt là hệ hô hấp. Với khả năng kháng khuẩn, làm ấm và thư giãn, Tinh dầu Tràm ECO là người bạn đồng hành không thể thiếu trong tủ thuốc gia đình, giúp đối phó hiệu quả với các triệu chứng cảm thông thường.', 'Việt Nam', 'Việt Nam', 'Công khai', 85, 0, 0, '2025-10-10 07:03:55', '2025-10-10 07:03:55', NULL, 'ECO'),
(5, 1, 'Sữa non tổ yến Papamilk Height & Gain giúp tăng cân tăng chiều cao cho Trẻ từ 1-19 tuổi - Lon 830G', 'sua-non-to-yen-papamilk-height-gain-giup-tang-can-tang-chieu-cao-cho-tre-tu-1-19-tuoi-lon-830g', 'Sữa Non Tổ Yến Papamilk Height & Gain là công thức dinh dưỡng đột phá được thiết kế chuyên biệt để hỗ trợ tăng cân khỏe mạnh và tối ưu hóa chiều cao cho trẻ em và thanh thiếu niên từ 1 đến 19 tuổi. Sự kết hợp độc đáo giữa Sữa Non cao cấp, Tổ Yến quý giá cùng hệ dưỡng chất khoa học giúp con bạn xây dựng nền tảng vững chắc cho một tương lai phát triển vượt trội.', 'Việt Nam', 'Việt Nam', 'Công khai', 20, 0, 0, '2025-10-10 07:03:55', '2025-10-10 07:03:55', NULL, '\r\nVKAIZEN'),
(6, 1, 'hahaha', 'hahahaha', 'ádasdasd', 'ss', 'ss', 'Công khai', 20, 1, 2, '2025-10-11 14:57:25', '2025-10-11 14:57:25', NULL, 'ghaa'),
(9, 1, 'Thực phẩm bảo vệ sức khỏe: Midu MenaQ7 180mcg', 'thuc-pham-bao-ve-suc-khoe-midu-menaq7-180mcg', 'Midu MenaQ7 180mcg bổ sung canxi, Vitamin D3, Vitamin K2 dạng MenaQ7 và Arginine phù hợp với tất cả độ tuổi từ 1 đến 100 tuổi. Đặc biệt giúp phát triển chiều cao cho trẻ em 1-15 tuổi; mẹ bầu bổ sung canxi trong giai đoạn thai kì không gây tiểu đường, không gây táo bón và giúp con cao ngay từ trong bụng mẹ.', 'Việt Nam', 'Việt Nam', 'Công khai', 0, 23, 100, '2025-10-12 04:51:39', '2025-10-12 04:51:39', NULL, 'Midu MenaQ7');

-- --------------------------------------------------------

--
-- Table structure for table `sukien`
--

CREATE TABLE `sukien` (
  `id` int NOT NULL,
  `tieude` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hinhanh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `noidung` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngaybatdau` date NOT NULL,
  `ngayketthuc` date NOT NULL,
  `trangthai` enum('Hiển thị','Tạm ẩn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sukien`
--

INSERT INTO `sukien` (`id`, `tieude`, `slug`, `hinhanh`, `noidung`, `ngaybatdau`, `ngayketthuc`, `trangthai`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Sinh Nhật 13/10', 'sinh-nhat-13-10', 'sinhnhat13102025.png', 'không có', '2025-10-12', '2025-10-31', 'Hiển thị', '2025-10-12 05:31:27', '2025-10-12 05:31:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `thongbao`
--

CREATE TABLE `thongbao` (
  `id` int NOT NULL,
  `id_nguoidung` int NOT NULL,
  `tieude` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `noidung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lienket` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `trangthai` enum('Đã đọc','Chưa đọc','Tạm ẩn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tukhoa`
--

CREATE TABLE `tukhoa` (
  `id` int NOT NULL,
  `tukhoa` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `luottruycap` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tukhoa`
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
-- Table structure for table `yeuthich`
--

CREATE TABLE `yeuthich` (
  `id` int NOT NULL,
  `id_nguoidung` int NOT NULL,
  `id_sanpham` int NOT NULL,
  `trangthai` enum('Hiển thị','Tạm ẩn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `baiviet`
--
ALTER TABLE `baiviet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nguoidung` (`id_nguoidung`);

--
-- Indexes for table `bienthe`
--
ALTER TABLE `bienthe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sanpham` (`id_sanpham`),
  ADD KEY `id_loaibienthe` (`id_loaibienthe`);

--
-- Indexes for table `chitiet_donhang`
--
ALTER TABLE `chitiet_donhang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_bienthe` (`id_bienthe`),
  ADD KEY `id_donhang` (`id_donhang`);

--
-- Indexes for table `cuahang`
--
ALTER TABLE `cuahang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_nguoidung` (`id_nguoidung`) USING BTREE;

--
-- Indexes for table `danhgia`
--
ALTER TABLE `danhgia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nguoidung` (`id_nguoidung`),
  ADD KEY `id_sanpham` (`id_sanpham`);

--
-- Indexes for table `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `danhmuc_sanpham`
--
ALTER TABLE `danhmuc_sanpham`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_danhmuc` (`id_danhmuc`),
  ADD KEY `id_sanpham` (`id_sanpham`);

--
-- Indexes for table `diachi_nguoidung`
--
ALTER TABLE `diachi_nguoidung`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nguoidung` (`id_nguoidung`);

--
-- Indexes for table `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nguoidung` (`id_nguoidung`),
  ADD KEY `id_magiamgia` (`id_magiamgia`),
  ADD KEY `id_phuongthuc` (`id_phuongthuc`);

--
-- Indexes for table `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_bienthe` (`id_bienthe`),
  ADD KEY `id_nguoidung` (`id_nguoidung`);

--
-- Indexes for table `hinhanh_sanpham`
--
ALTER TABLE `hinhanh_sanpham`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sanpham` (`id_sanpham`);

--
-- Indexes for table `loaibienthe`
--
ALTER TABLE `loaibienthe`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `magiamgia`
--
ALTER TABLE `magiamgia`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phuongthuc`
--
ALTER TABLE `phuongthuc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quangcao`
--
ALTER TABLE `quangcao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quatang_sukien`
--
ALTER TABLE `quatang_sukien`
  ADD KEY `id_bienthe` (`id_bienthe`),
  ADD KEY `id_cuahang` (`id_cuahang`),
  ADD KEY `id_sukien` (`id_sukien`);

--
-- Indexes for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cuahang` (`id_cuahang`);

--
-- Indexes for table `sukien`
--
ALTER TABLE `sukien`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `thongbao`
--
ALTER TABLE `thongbao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nguoidung` (`id_nguoidung`);

--
-- Indexes for table `tukhoa`
--
ALTER TABLE `tukhoa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `yeuthich`
--
ALTER TABLE `yeuthich`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_nguoidung` (`id_nguoidung`,`id_sanpham`),
  ADD KEY `id_sanpham` (`id_sanpham`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bienthe`
--
ALTER TABLE `bienthe`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cuahang`
--
ALTER TABLE `cuahang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `danhmuc`
--
ALTER TABLE `danhmuc`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `danhmuc_sanpham`
--
ALTER TABLE `danhmuc_sanpham`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hinhanh_sanpham`
--
ALTER TABLE `hinhanh_sanpham`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `loaibienthe`
--
ALTER TABLE `loaibienthe`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quangcao`
--
ALTER TABLE `quangcao`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sukien`
--
ALTER TABLE `sukien`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tukhoa`
--
ALTER TABLE `tukhoa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `baiviet`
--
ALTER TABLE `baiviet`
  ADD CONSTRAINT `baiviet_ibfk_1` FOREIGN KEY (`id_nguoidung`) REFERENCES `nguoidung` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `bienthe`
--
ALTER TABLE `bienthe`
  ADD CONSTRAINT `bienthe_ibfk_1` FOREIGN KEY (`id_sanpham`) REFERENCES `sanpham` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `bienthe_ibfk_2` FOREIGN KEY (`id_loaibienthe`) REFERENCES `loaibienthe` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `chitiet_donhang`
--
ALTER TABLE `chitiet_donhang`
  ADD CONSTRAINT `chitiet_donhang_ibfk_1` FOREIGN KEY (`id_bienthe`) REFERENCES `bienthe` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `chitiet_donhang_ibfk_2` FOREIGN KEY (`id_donhang`) REFERENCES `donhang` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `cuahang`
--
ALTER TABLE `cuahang`
  ADD CONSTRAINT `cuahang_ibfk_1` FOREIGN KEY (`id_nguoidung`) REFERENCES `nguoidung` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `danhgia`
--
ALTER TABLE `danhgia`
  ADD CONSTRAINT `danhgia_ibfk_1` FOREIGN KEY (`id_nguoidung`) REFERENCES `nguoidung` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `danhgia_ibfk_2` FOREIGN KEY (`id_sanpham`) REFERENCES `sanpham` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `danhmuc_sanpham`
--
ALTER TABLE `danhmuc_sanpham`
  ADD CONSTRAINT `danhmuc_sanpham_ibfk_1` FOREIGN KEY (`id_danhmuc`) REFERENCES `danhmuc` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `danhmuc_sanpham_ibfk_2` FOREIGN KEY (`id_sanpham`) REFERENCES `sanpham` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `diachi_nguoidung`
--
ALTER TABLE `diachi_nguoidung`
  ADD CONSTRAINT `diachi_nguoidung_ibfk_1` FOREIGN KEY (`id_nguoidung`) REFERENCES `nguoidung` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`id_nguoidung`) REFERENCES `nguoidung` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `donhang_ibfk_2` FOREIGN KEY (`id_magiamgia`) REFERENCES `magiamgia` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `donhang_ibfk_3` FOREIGN KEY (`id_phuongthuc`) REFERENCES `phuongthuc` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `giohang`
--
ALTER TABLE `giohang`
  ADD CONSTRAINT `giohang_ibfk_1` FOREIGN KEY (`id_bienthe`) REFERENCES `bienthe` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `giohang_ibfk_2` FOREIGN KEY (`id_nguoidung`) REFERENCES `nguoidung` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `hinhanh_sanpham`
--
ALTER TABLE `hinhanh_sanpham`
  ADD CONSTRAINT `hinhanh_sanpham_ibfk_1` FOREIGN KEY (`id_sanpham`) REFERENCES `sanpham` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `quatang_sukien`
--
ALTER TABLE `quatang_sukien`
  ADD CONSTRAINT `quatang_sukien_ibfk_1` FOREIGN KEY (`id_bienthe`) REFERENCES `bienthe` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `quatang_sukien_ibfk_2` FOREIGN KEY (`id_cuahang`) REFERENCES `cuahang` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `quatang_sukien_ibfk_3` FOREIGN KEY (`id_sukien`) REFERENCES `sukien` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`id_cuahang`) REFERENCES `cuahang` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `thongbao`
--
ALTER TABLE `thongbao`
  ADD CONSTRAINT `thongbao_ibfk_1` FOREIGN KEY (`id_nguoidung`) REFERENCES `nguoidung` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `yeuthich`
--
ALTER TABLE `yeuthich`
  ADD CONSTRAINT `yeuthich_ibfk_1` FOREIGN KEY (`id_nguoidung`) REFERENCES `nguoidung` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `yeuthich_ibfk_2` FOREIGN KEY (`id_sanpham`) REFERENCES `sanpham` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
