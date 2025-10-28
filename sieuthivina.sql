-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 28, 2025 at 10:24 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

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
  `trangthai` enum('Hiển thị','Tạm ẩn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hiển thị'
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
  `luottang` int NOT NULL DEFAULT '0',
  `luotban` int NOT NULL DEFAULT '0',
  `trangthai` enum('Còn hàng','Hết hàng','Sắp hết hàng') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Còn hàng',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bienthe`
--

INSERT INTO `bienthe` (`id`, `id_loaibienthe`, `id_sanpham`, `giagoc`, `soluong`, `luottang`, `luotban`, `trangthai`, `deleted_at`) VALUES
(1, 1, 1, 270000, 10, 0, 0, 'Còn hàng', NULL),
(2, 2, 2, 385000, 10, 0, 0, 'Còn hàng', NULL),
(3, 1, 3, 466560, 10, 0, 23, 'Còn hàng', NULL),
(4, 1, 4, 260000, 10, 0, 0, 'Còn hàng', NULL),
(5, 2, 5, 512000, 10, 0, 0, 'Còn hàng', NULL),
(6, 1, 6, 270000, 2, 0, 0, 'Sắp hết hàng', NULL),
(7, 2, 9, 360000, 253, 0, 28, 'Còn hàng', NULL),
(8, 1, 9, 260000, 5, 0, 2, 'Sắp hết hàng', NULL),
(9, 1, 10, 795000, 200, 0, 10, 'Còn hàng', NULL),
(10, 2, 11, 950000, 27, 0, 124, 'Còn hàng', NULL),
(11, 1, 11, 500000, 5, 0, 10, 'Sắp hết hàng', NULL),
(12, 1, 12, 330000, 63, 0, 12, 'Còn hàng', NULL),
(13, 2, 12, 330000, 92, 0, 72, 'Còn hàng', NULL),
(14, 3, 12, 512000, 12, 0, 0, 'Còn hàng', NULL),
(15, 4, 13, 90000, 240, 7, 142, 'Còn hàng', NULL),
(16, 2, 14, 369000, 75, 20, 472, 'Còn hàng', NULL),
(17, 5, 15, 282000, 25, 0, 782, 'Còn hàng', NULL),
(18, 6, 15, 300000, 23, 0, 0, 'Còn hàng', NULL),
(19, 3, 16, 249000, 2, 0, 187, 'Sắp hết hàng', NULL),
(20, 3, 17, 220800, 12, 0, 17, 'Còn hàng', NULL),
(21, 8, 18, 69000, 76, 5, 76, 'Còn hàng', NULL),
(22, 3, 19, 160000, 1214, 0, 67, 'Còn hàng', NULL),
(23, 9, 20, 490000, 107, 0, 193, 'Còn hàng', NULL),
(24, 9, 21, 799000, 123, 1, 3, 'Còn hàng', NULL),
(25, 1, 22, 42000, 7, 0, 3, 'Sắp hết hàng', NULL),
(26, 9, 23, 290000, 100, 0, 74, 'Còn hàng', NULL),
(27, 8, 22, 89000, 123, 0, 3, 'Còn hàng', NULL),
(28, 11, 24, 285000, 800, 0, 1300, 'Còn hàng', NULL),
(29, 10, 24, 285000, 401, 0, 268, 'Còn hàng', NULL),
(30, 11, 25, 51000, 234, 0, 7500, 'Còn hàng', NULL),
(31, 12, 25, 51000, 856, 0, 3300, 'Còn hàng', NULL),
(32, 13, 26, 3800000, 0, 0, 27, 'Còn hàng', NULL),
(33, 14, 26, 3400000, 1246, 0, 23, 'Còn hàng', NULL),
(34, 16, 27, 59500, 643, 0, 17700, 'Còn hàng', NULL),
(35, 15, 27, 245000, 421, 0, 15400, 'Còn hàng', NULL),
(36, 17, 28, 110000, 231, 0, 9500, 'Còn hàng', NULL),
(37, 18, 28, 290000, 423, 0, 4100, 'Còn hàng', NULL),
(38, 19, 29, 340000, 25, 0, 3500, 'Còn hàng', NULL),
(39, 20, 29, 360000, 0, 0, 6800, 'Còn hàng', NULL),
(40, 22, 30, 43000, 100, 0, 1600, 'Còn hàng', NULL),
(41, 21, 30, 265000, 100, 0, 786, 'Còn hàng', NULL),
(42, 22, 31, 44000, 50, 0, 855, 'Còn hàng', NULL),
(43, 21, 31, 271000, 50, 0, 398, 'Còn hàng', NULL),
(44, 23, 32, 879000, 75, 0, 149, 'Còn hàng', NULL);

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
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chuongtrinh`
--

CREATE TABLE `chuongtrinh` (
  `id` int NOT NULL,
  `tieude` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hinhanh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `noidung` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `trangthai` enum('Hiển thị','Tạm ẩn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chuongtrinh`
--

INSERT INTO `chuongtrinh` (`id`, `tieude`, `slug`, `hinhanh`, `noidung`, `trangthai`) VALUES
(1, 'Sinh Nhật 13/10', 'sinh-nhat-13-10', 'sinhnhat13102025.png', 'không có', 'Hiển thị');

-- --------------------------------------------------------

--
-- Table structure for table `danhgia`
--

CREATE TABLE `danhgia` (
  `id` int NOT NULL,
  `id_sanpham` int NOT NULL,
  `id_nguoidung` int NOT NULL,
  `id_chitietdonhang` int NOT NULL,
  `diem` int NOT NULL DEFAULT '5',
  `noidung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `trangthai` enum('Hiển thị','Tạm ẩn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hiển thị'
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
  `parent` enum('Cha','Con') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Cha',
  `trangthai` enum('Hiển thị','Tạm ẩn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hiển thị'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `danhmuc`
--

INSERT INTO `danhmuc` (`id`, `ten`, `slug`, `logo`, `parent`, `trangthai`) VALUES
(1, 'Sức khỏe', 'suc-khoe', 'suc-khoe.svg', 'Cha', 'Hiển thị'),
(2, 'Thực phẩm chức năng', 'thuc-pham-chuc-nang', 'thuc-pham-chuc-nang.svg', 'Cha', 'Hiển thị'),
(3, 'Chăm sóc cá nhân', 'cham-soc-ca-nhan', 'cham-soc-ca-nhan.svg', 'Cha', 'Hiển thị'),
(4, 'Làm đẹp', 'lam-dep', 'lam-dep.svg', 'Cha', 'Hiển thị'),
(5, 'Điện máy', 'dien-may', 'dien-may.svg', 'Cha', 'Hiển thị'),
(6, 'Thiết bị y tế', 'thiet-bi-y-te', 'thiet-bi-y-te.svg', 'Cha', 'Hiển thị'),
(7, 'Bách hóa', 'bach-hoa', 'bach-hoa.svg', 'Cha', 'Hiển thị'),
(8, 'Nội thất - Trang trí', 'noi-that-trang-tri', 'noi-that-trang-tri.svg', 'Cha', 'Hiển thị'),
(9, 'Mẹ & bé', 'me-va-be', 'me-va-be.svg', 'Cha', 'Hiển thị'),
(10, 'Thời trang', 'thoi-trang', 'thoi-trang.svg', 'Cha', 'Hiển thị'),
(11, 'Thực phẩm - đồ ăn', 'thuc-pham-do-an', 'thuc-pham-do-an.svg', 'Con', 'Hiển thị');

-- --------------------------------------------------------

--
-- Table structure for table `danhmuc_sanpham`
--

CREATE TABLE `danhmuc_sanpham` (
  `id` int NOT NULL,
  `id_danhmuc` int NOT NULL,
  `id_sanpham` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `danhmuc_sanpham`
--

INSERT INTO `danhmuc_sanpham` (`id`, `id_danhmuc`, `id_sanpham`) VALUES
(1, 1, 5),
(2, 1, 4),
(3, 2, 1),
(4, 2, 3),
(5, 1, 2),
(6, 2, 9),
(7, 3, 9),
(8, 1, 9),
(9, 7, 6),
(10, 1, 10),
(11, 4, 10),
(12, 4, 11),
(13, 4, 12),
(14, 7, 15),
(15, 7, 14),
(16, 7, 13),
(17, 11, 14),
(18, 11, 15),
(23, 7, 16),
(24, 7, 17),
(25, 7, 18),
(26, 6, 19),
(27, 6, 20),
(28, 6, 21),
(29, 6, 22),
(30, 6, 23),
(41, 1, 27),
(42, 7, 24),
(43, 11, 24),
(44, 7, 25),
(45, 11, 25),
(46, 7, 26),
(47, 7, 28),
(48, 7, 29),
(49, 11, 26),
(50, 11, 29),
(51, 7, 30),
(52, 7, 31),
(53, 7, 32);

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
  `trangthai` enum('Mặc định','Khác','Tạm ẩn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Khác',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donhang`
--

CREATE TABLE `donhang` (
  `id` int NOT NULL,
  `id_nguoidung` int NOT NULL,
  `id_diachinguoidung` int NOT NULL,
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
  `trangthai` enum('Hiển thị','Tạm ẩn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hiển thị'
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
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hinhanh_sanpham`
--

INSERT INTO `hinhanh_sanpham` (`id`, `id_sanpham`, `hinhanh`, `trangthai`, `deleted_at`) VALUES
(1, 1, 'keo-ong-xanh-tracybee-propolis-mint-honey-giam-dau-rat-hong-ho-viem-hong-vi-bac-ha-1.webp', 'Hiển thị', NULL),
(2, 1, 'keo-ong-xanh-tracybee-propolis-mint-honey-giam-dau-rat-hong-ho-viem-hong-vi-bac-ha-2.webp', 'Hiển thị', NULL),
(3, 1, 'keo-ong-xanh-tracybee-propolis-mint-honey-giam-dau-rat-hong-ho-viem-hong-vi-bac-ha-3.webp', 'Hiển thị', NULL),
(4, 1, 'keo-ong-xanh-tracybee-propolis-mint-honey-giam-dau-rat-hong-ho-viem-hong-vi-bac-ha-4.webp', 'Hiển thị', NULL),
(5, 2, 'mat-ong-tay-bac-dong-trung-ha-thao-x3-hu-240g-1.webp', 'Hiển thị', NULL),
(6, 2, 'mat-ong-tay-bac-dong-trung-ha-thao-x3-hu-240g-2.webp', 'Hiển thị', NULL),
(7, 2, 'mat-ong-tay-bac-dong-trung-ha-thao-x3-hu-240g-3.webp', 'Hiển thị', NULL),
(8, 3, 'sam-ngoc-linh-truong-sinh-do-thung-24lon-1.webp', 'Hiển thị', NULL),
(9, 3, 'sam-ngoc-linh-truong-sinh-do-thung-24lon-2.webp', 'Hiển thị', NULL),
(10, 3, 'sam-ngoc-linh-truong-sinh-do-thung-24lon-3.webp', 'Hiển thị', NULL),
(11, 3, 'sam-ngoc-linh-truong-sinh-do-thung-24lon-4.webp', 'Hiển thị', NULL),
(12, 3, 'sam-ngoc-linh-truong-sinh-do-thung-24lon-5.webp', 'Hiển thị', NULL),
(13, 4, 'tinh-dau-tram-tu-nhien-eco-ho-tro-giam-ho-cam-cum-so-mui-cam-lanh-lo-30ml-1.webp', 'Hiển thị', NULL),
(14, 4, 'tinh-dau-tram-tu-nhien-eco-ho-tro-giam-ho-cam-cum-so-mui-cam-lanh-lo-30ml-2.webp', 'Hiển thị', NULL),
(15, 4, 'tinh-dau-tram-tu-nhien-eco-ho-tro-giam-ho-cam-cum-so-mui-cam-lanh-lo-30ml-3.webp', 'Hiển thị', NULL),
(16, 5, 'sua-non-to-yen-papamilk-height-gain-giup-tang-can-tang-chieu-cao-cho-tre-tu-1-19-tuoi-lon-830g-1.webp', 'Hiển thị', NULL),
(17, 5, 'sua-non-to-yen-papamilk-height-gain-giup-tang-can-tang-chieu-cao-cho-tre-tu-1-19-tuoi-lon-830g-2.webp', 'Hiển thị', NULL),
(18, 5, 'sua-non-to-yen-papamilk-height-gain-giup-tang-can-tang-chieu-cao-cho-tre-tu-1-19-tuoi-lon-830g-3.webp', 'Hiển thị', NULL),
(19, 5, 'sua-non-to-yen-papamilk-height-gain-giup-tang-can-tang-chieu-cao-cho-tre-tu-1-19-tuoi-lon-830g-4.webp', 'Hiển thị', NULL),
(20, 5, 'sua-non-to-yen-papamilk-height-gain-giup-tang-can-tang-chieu-cao-cho-tre-tu-1-19-tuoi-lon-830g-5.webp', 'Hiển thị', NULL),
(21, 5, 'sua-non-to-yen-papamilk-height-gain-giup-tang-can-tang-chieu-cao-cho-tre-tu-1-19-tuoi-lon-830g-6.webp', 'Hiển thị', NULL),
(22, 6, 'sam-ngoc-linh-truong-sinh-do-thung-24lon-1.webp', 'Hiển thị', NULL),
(23, 9, 'thuc-pham-bao-ve-suc-khoe-midu-menaq7-180mcg-1.webp', 'Hiển thị', NULL),
(24, 9, 'thuc-pham-bao-ve-suc-khoe-midu-menaq7-180mcg-2.webp', 'Hiển thị', NULL),
(25, 9, 'thuc-pham-bao-ve-suc-khoe-midu-menaq7-180mcg-3.webp', 'Hiển thị', NULL),
(26, 9, 'thuc-pham-bao-ve-suc-khoe-midu-menaq7-180mcg-4.webp', 'Hiển thị', NULL),
(27, 9, 'thuc-pham-bao-ve-suc-khoe-midu-menaq7-180mcg-5.webp', 'Hiển thị', NULL),
(28, 10, 'collagen-thuy-phan-ho-tro-da-mong-toc-acai-labs-marine-collagen-beauty-australia-90v-1.webp', 'Hiển thị', NULL),
(29, 10, 'collagen-thuy-phan-ho-tro-da-mong-toc-acai-labs-marine-collagen-beauty-australia-90v-2.webp', 'Hiển thị', NULL),
(30, 10, 'collagen-thuy-phan-ho-tro-da-mong-toc-acai-labs-marine-collagen-beauty-australia-90v-3.webp', 'Hiển thị', NULL),
(31, 10, 'collagen-thuy-phan-ho-tro-da-mong-toc-acai-labs-marine-collagen-beauty-australia-90v-4.webp', 'Hiển thị', NULL),
(32, 10, 'collagen-thuy-phan-ho-tro-da-mong-toc-acai-labs-marine-collagen-beauty-australia-90v-5.webp', 'Hiển thị', NULL),
(33, 11, 'vien-uong-bishin-tripeptide-collagen-nhat-ban-60v-1.webp', 'Hiển thị', NULL),
(34, 11, 'vien-uong-bishin-tripeptide-collagen-nhat-ban-60v-2.webp', 'Hiển thị', NULL),
(35, 11, 'vien-uong-bishin-tripeptide-collagen-nhat-ban-60v-3.webp', 'Hiển thị', NULL),
(36, 11, 'vien-uong-bishin-tripeptide-collagen-nhat-ban-60v-4.webp', 'Hiển thị', NULL),
(37, 12, 'duong-mi-te-bao-goc-cchoi-bio-placenta-lash-serum-1.webp', 'Hiển thị', NULL),
(38, 12, 'duong-mi-te-bao-goc-cchoi-bio-placenta-lash-serum-2.webp', 'Hiển thị', NULL),
(39, 12, 'duong-mi-te-bao-goc-cchoi-bio-placenta-lash-serum-3.webp', 'Hiển thị', NULL),
(40, 12, 'duong-mi-te-bao-goc-cchoi-bio-placenta-lash-serum-4.webp', 'Hiển thị', NULL),
(41, 13, 'nuoc-rua-bat-bio-formula-bo-va-lo-hoi-tui-500ml-1.webp', 'Hiển thị', NULL),
(42, 13, 'nuoc-rua-bat-bio-formula-bo-va-lo-hoi-tui-500ml-2.webp', 'Hiển thị', NULL),
(43, 13, 'nuoc-rua-bat-bio-formula-bo-va-lo-hoi-tui-500ml-3.webp', 'Hiển thị', NULL),
(44, 14, 'banh-trung-thu-2025-thu-an-nhien-banh-chay-hop-2-banh-1-tra-1.webp', 'Hiển thị', NULL),
(45, 14, 'banh-trung-thu-2025-thu-an-nhien-banh-chay-hop-2-banh-1-tra-2.webp', 'Hiển thị', NULL),
(46, 14, 'banh-trung-thu-2025-thu-an-nhien-banh-chay-hop-2-banh-1-tra-3.webp', 'Hiển thị', NULL),
(47, 14, 'banh-trung-thu-2025-thu-an-nhien-banh-chay-hop-2-banh-1-tra-4.webp', 'Hiển thị', NULL),
(48, 14, 'banh-trung-thu-2025-thu-an-nhien-banh-chay-hop-2-banh-1-tra-5.webp', 'Hiển thị', NULL),
(49, 15, 'hat-dieu-rang-muoi-loai-1-con-vo-lua-happy-nuts-500g-1.webp', 'Hiển thị', NULL),
(50, 15, 'hat-dieu-rang-muoi-loai-1-con-vo-lua-happy-nuts-500g-2.webp', 'Hiển thị', NULL),
(51, 15, 'hat-dieu-rang-muoi-loai-1-con-vo-lua-happy-nuts-500g-3.webp', 'Hiển thị', NULL),
(52, 16, 'keo-qua-sam-khong-duong-free-suger-ginseng-berry-s-candy-200g-1.webp', 'Hiển thị', NULL),
(53, 16, 'keo-qua-sam-khong-duong-free-suger-ginseng-berry-s-candy-200g-2.webp', 'Hiển thị', NULL),
(54, 16, 'keo-qua-sam-khong-duong-free-suger-ginseng-berry-s-candy-200g-3.webp', 'Hiển thị', NULL),
(55, 16, 'keo-qua-sam-khong-duong-free-suger-ginseng-berry-s-candy-200g-4.webp', 'Hiển thị', NULL),
(56, 17, 'bot-matcha-gao-rang-nhat-ban-onelife-goi-100g-1.webp', 'Hiển thị', NULL),
(57, 17, 'bot-matcha-gao-rang-nhat-ban-onelife-goi-100g-2.webp', 'Hiển thị', NULL),
(58, 17, 'bot-matcha-gao-rang-nhat-ban-onelife-goi-100g-3.webp', 'Hiển thị', NULL),
(59, 18, 'nuoc-rua-chen-sa-chanh-come-on-lam-sach-bat-dia-an-toan-da-tay-1-lit-1.webp', 'Hiển thị', NULL),
(60, 18, 'nuoc-rua-chen-sa-chanh-come-on-lam-sach-bat-dia-an-toan-da-tay-1-lit-2.webp', 'Hiển thị', NULL),
(61, 19, 'gang-lau-abena-wash-gloves-50-mienggoi-1.webp', 'Hiển thị', NULL),
(62, 19, 'gang-lau-abena-wash-gloves-50-mienggoi-2.webp', 'Hiển thị', NULL),
(63, 19, 'gang-lau-abena-wash-gloves-50-mienggoi-3.webp', 'Hiển thị', NULL),
(64, 20, 'tam-lot-giuong-abena-pad-giat-duoc-85x90cm-1.webp', 'Hiển thị', NULL),
(65, 20, 'tam-lot-giuong-abena-pad-giat-duoc-85x90cm-2.webp', 'Hiển thị', NULL),
(66, 20, 'tam-lot-giuong-abena-pad-giat-duoc-85x90cm-3.webp', 'Hiển thị', NULL),
(67, 21, 'may-xong-khi-dung-cam-tay-kachi-ys35-giai-phap-ho-hap-linh-hoat-moi-luc-moi-noi-1.webp', 'Hiển thị', NULL),
(68, 21, 'may-xong-khi-dung-cam-tay-kachi-ys35-giai-phap-ho-hap-linh-hoat-moi-luc-moi-noi-2.webp', 'Hiển thị', NULL),
(69, 21, 'may-xong-khi-dung-cam-tay-kachi-ys35-giai-phap-ho-hap-linh-hoat-moi-luc-moi-noi-3.webp', 'Hiển thị', NULL),
(70, 21, 'may-xong-khi-dung-cam-tay-kachi-ys35-giai-phap-ho-hap-linh-hoat-moi-luc-moi-noi-4.webp', 'Hiển thị', NULL),
(71, 21, 'may-xong-khi-dung-cam-tay-kachi-ys35-giai-phap-ho-hap-linh-hoat-moi-luc-moi-noi-5.webp', 'Hiển thị', NULL),
(72, 21, 'may-xong-khi-dung-cam-tay-kachi-ys35-giai-phap-ho-hap-linh-hoat-moi-luc-moi-noi-6.webp', 'Hiển thị', NULL),
(73, 21, 'may-xong-khi-dung-cam-tay-kachi-ys35-giai-phap-ho-hap-linh-hoat-moi-luc-moi-noi-7.webp', 'Hiển thị', NULL),
(74, 21, 'may-xong-khi-dung-cam-tay-kachi-ys35-giai-phap-ho-hap-linh-hoat-moi-luc-moi-noi-8.webp', 'Hiển thị', NULL),
(75, 22, 'hu-hit-thao-duoc-nhi-thien-duong-hu-5g-1.webp', 'Hiển thị', NULL),
(76, 22, 'hu-hit-thao-duoc-nhi-thien-duong-hu-5g-2.webp', 'Hiển thị', NULL),
(77, 22, 'hu-hit-thao-duoc-nhi-thien-duong-hu-5g-3.webp', 'Hiển thị', NULL),
(78, 23, 'tam-lot-abena-pad-45x45-1.webp', 'Hiển thị', NULL),
(79, 23, 'tam-lot-abena-pad-45x45-2.webp', 'Hiển thị', NULL),
(80, 23, 'tam-lot-abena-pad-45x45-3.webp', 'Hiển thị', NULL),
(81, 24, 'nuoc-yen-sao-nest100-lon-190ml-khay-30-lon-1.webp', 'Hiển thị', NULL),
(82, 24, 'nuoc-yen-sao-nest100-lon-190ml-khay-30-lon-2.webp', 'Hiển thị', NULL),
(83, 24, 'nuoc-yen-sao-nest100-lon-190ml-khay-30-lon-3.webp', 'Hiển thị', NULL),
(84, 24, 'nuoc-yen-sao-nest100-lon-190ml-khay-30-lon-4.webp', 'Hiển thị', NULL),
(85, 24, 'nuoc-yen-sao-nest100-lon-190ml-khay-30-lon-5.webp', 'Hiển thị', NULL),
(86, 24, 'nuoc-yen-sao-nest100-lon-190ml-khay-30-lon-6.webp', 'Hiển thị', NULL),
(87, 25, 'nuoc-yen-sao-nest100-lon-190ml-hop-5-lon-1.webp', 'Hiển thị', NULL),
(88, 25, 'nuoc-yen-sao-nest100-lon-190ml-hop-5-lon-2.webp', 'Hiển thị', NULL),
(89, 25, 'nuoc-yen-sao-nest100-lon-190ml-hop-5-lon-3.webp', 'Hiển thị', NULL),
(90, 25, 'nuoc-yen-sao-nest100-lon-190ml-hop-5-lon-4.webp', 'Hiển thị', NULL),
(91, 25, 'nuoc-yen-sao-nest100-lon-190ml-hop-5-lon-5.webp', 'Hiển thị', NULL),
(92, 25, 'nuoc-yen-sao-nest100-lon-190ml-hop-5-lon-6.webp', 'Hiển thị', NULL),
(93, 26, 'yen-to-nest100-hop-50g-tui-1.webp', 'Hiển thị', NULL),
(94, 26, 'yen-to-nest100-hop-50g-tui-2.webp', 'Hiển thị', NULL),
(95, 26, 'yen-to-nest100-hop-50g-tui-3.webp', 'Hiển thị', NULL),
(96, 26, 'yen-to-nest100-hop-50g-tui-4.webp', 'Hiển thị', NULL),
(97, 26, 'yen-to-nest100-hop-50g-tui-5.webp', 'Hiển thị', NULL),
(98, 27, 'thuc-pham-bao-ve-suc-khoe-byealco-5-vien-vi-1.webp', 'Hiển thị', NULL),
(99, 27, 'thuc-pham-bao-ve-suc-khoe-byealco-5-vien-vi-2.webp', 'Hiển thị', NULL),
(100, 27, 'thuc-pham-bao-ve-suc-khoe-byealco-5-vien-vi-3.webp', 'Hiển thị', NULL),
(101, 27, 'thuc-pham-bao-ve-suc-khoe-byealco-5-vien-vi-4.webp', 'Hiển thị', NULL),
(102, 27, 'thuc-pham-bao-ve-suc-khoe-byealco-5-vien-vi-5.webp', 'Hiển thị', NULL),
(103, 27, 'thuc-pham-bao-ve-suc-khoe-byealco-5-vien-vi-6.webp', 'Hiển thị', NULL),
(104, 28, 'ca-phe-sam-canada-1.webp', 'Hiển thị', NULL),
(105, 28, 'ca-phe-sam-canada-2.webp', 'Hiển thị', NULL),
(106, 28, 'ca-phe-sam-canada-3.webp', 'Hiển thị', NULL),
(107, 28, 'ca-phe-sam-canada-4.webp', 'Hiển thị', NULL),
(108, 28, 'ca-phe-sam-canada-5.webp', 'Hiển thị', NULL),
(109, 29, 'ca-phe-bao-tu-linh-chi-pha-vach-giup-tinh-tao-1.webp', 'Hiển thị', NULL),
(110, 29, 'ca-phe-bao-tu-linh-chi-pha-vach-giup-tinh-tao-2.webp', 'Hiển thị', NULL),
(111, 29, 'ca-phe-bao-tu-linh-chi-pha-vach-giup-tinh-tao-3.webp', 'Hiển thị', NULL),
(112, 29, 'ca-phe-bao-tu-linh-chi-pha-vach-giup-tinh-tao-4.webp', 'Hiển thị', NULL),
(113, 29, 'ca-phe-bao-tu-linh-chi-pha-vach-giup-tinh-tao-5.webp', 'Hiển thị', NULL),
(114, 29, 'ca-phe-bao-tu-linh-chi-pha-vach-giup-tinh-tao-6.webp', 'Hiển thị', NULL),
(115, 30, 'nuoc-yen-sao-dong-trung-ha-thao-nest100-co-duong-1.webp', 'Hiển thị', NULL),
(116, 30, 'nuoc-yen-sao-dong-trung-ha-thao-nest100-co-duong-2.webp', 'Hiển thị', NULL),
(117, 30, 'nuoc-yen-sao-dong-trung-ha-thao-nest100-co-duong-3.webp', 'Hiển thị', NULL),
(118, 30, 'nuoc-yen-sao-dong-trung-ha-thao-nest100-co-duong-4.webp', 'Hiển thị', NULL),
(119, 30, 'nuoc-yen-sao-dong-trung-ha-thao-nest100-co-duong-5.webp', 'Hiển thị', NULL),
(120, 30, 'nuoc-yen-sao-dong-trung-ha-thao-nest100-co-duong-6.webp', 'Hiển thị', NULL),
(121, 31, 'nuoc-yen-sam-ginnest-co-duong-1.webp', 'Hiển thị', NULL),
(122, 31, 'nuoc-yen-sam-ginnest-co-duong-2.webp', 'Hiển thị', NULL),
(123, 31, 'nuoc-yen-sam-ginnest-co-duong-3.webp', 'Hiển thị', NULL),
(124, 31, 'nuoc-yen-sam-ginnest-co-duong-4.webp', 'Hiển thị', NULL),
(125, 31, 'nuoc-yen-sam-ginnest-co-duong-5.webp', 'Hiển thị', NULL),
(126, 31, 'nuoc-yen-sam-ginnest-co-duong-6.webp', 'Hiển thị', NULL),
(127, 32, 'hop-qua-tang-cao-cap-ngu-phuc-luxury-to-yen-tinh-che-va-yen-chung-nest100-cao-cap-kem-tui-1.webp', 'Hiển thị', NULL),
(128, 32, 'hop-qua-tang-cao-cap-ngu-phuc-luxury-to-yen-tinh-che-va-yen-chung-nest100-cao-cap-kem-tui-2.webp', 'Hiển thị', NULL),
(129, 32, 'hop-qua-tang-cao-cap-ngu-phuc-luxury-to-yen-tinh-che-va-yen-chung-nest100-cao-cap-kem-tui-3.webp', 'Hiển thị', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `loaibienthe`
--

CREATE TABLE `loaibienthe` (
  `id` int NOT NULL,
  `ten` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `trangthai` enum('Hiển thị','Tạm ẩn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hiển thị'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loaibienthe`
--

INSERT INTO `loaibienthe` (`id`, `ten`, `trangthai`) VALUES
(1, 'Lọ', 'Hiển thị'),
(2, 'Hộp', 'Hiển thị'),
(3, 'Gói', 'Hiển thị'),
(4, 'Túi 500ml', 'Hiển thị'),
(5, 'Hộp (Vỏ lụa) 500g', 'Hiển thị'),
(6, 'Hộp (đã lột vỏ) 500g', 'Hiển thị'),
(7, 'Chai', 'Hiển thị'),
(8, 'Bình xịt', 'Hiển thị'),
(9, 'Cái', 'Hiển thị'),
(10, 'Đường ăn kiêng (190ml/lon)', 'Hiển thị'),
(11, 'Có đường (190ml/lon)', 'Hiển thị'),
(12, 'Plus ít đường (190ml/lon)', 'Hiển thị'),
(13, 'Rút lông loại đặc biệt (50g/hộp)', 'Hiển thị'),
(14, 'Tinh chế loại 1 (50g/hộp)', 'Hiển thị'),
(15, 'Hộp 5 vỉ (5 viên/vỉ)', 'Hiển thị'),
(16, 'Hộp 1 vỉ (5 viên/vỉ)', 'Hiển thị'),
(17, 'Hộp 10 gói', 'Hiển thị'),
(18, 'Hộp 30 gói', 'Hiển thị'),
(19, 'Loại thường (20 gói x 15g)', 'Hiển thị'),
(20, 'Vị sữa (20g x 18g)', 'Hiển thị'),
(21, 'Hộp 6 lọ + túi (70ml/lọ)', 'Hiển thị'),
(22, 'Hộp 1 lọ (70ml/lọ)', 'Hiển thị'),
(23, 'Hộp Ngũ Phúc Luxury - 5 quà tặng cao cấp', 'Hiển thị');

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
  `vaitro` enum('admin','seller','client') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'client',
  `trangthai` enum('Hoạt động','Tạm khóa','Dừng hoạt động') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nguoidung`
--

INSERT INTO `nguoidung` (`id`, `username`, `password`, `sodienthoai`, `hoten`, `gioitinh`, `ngaysinh`, `avatar`, `vaitro`, `trangthai`, `deleted_at`, `remember_token`) VALUES
(2, 'caokienhuu2004', '$2y$12$/8kG3YP.cDE22cEm2IQBvOLDlcOeCFQGkY5bpfurTLgNt.uo3lARa', '0845381121', 'Cao Kiến Hựu', 'Nam', '2004-10-13', 'caokienhuu2004.jpg', 'client', 'Hoạt động', NULL, 'GQ3D8lIcCgK3iRKAvVYB8zfNXIDSHmvIEvpWuTleUowGtO9jjmCxyYNIoLcv');

-- --------------------------------------------------------

--
-- Table structure for table `phuongthuc`
--

CREATE TABLE `phuongthuc` (
  `id` int NOT NULL,
  `ten` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `maphuongthuc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `trangthai` enum('Hoạt động','Tạm khóa','Dừng hoạt động') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hoạt động'
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
  `trangthai` enum('Hiển thị','Tạm ẩn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hiển thị'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quangcao`
--

INSERT INTO `quangcao` (`id`, `vitri`, `hinhanh`, `lienket`, `mota`, `trangthai`) VALUES
(1, 'home_banner_slider', 'banner-droppii-1.png', 'https://droppii.vn', 'Liên kết đến Droppii Mall', 'Hiển thị'),
(2, 'home_banner_slider', 'banner-droppii-2.png', 'https://droppii.vn', 'Liên kết đến Droppii Mall', 'Hiển thị'),
(3, 'home_banner_slider', 'banner-droppii-3.png', 'https://droppii.vn', 'Liên kết đến Droppii Mall', 'Hiển thị'),
(4, 'home_banner_event_1', 'shopee-1.jpg', 'https://shopee.tw', 'Liên kết đến Shopee', 'Hiển thị'),
(5, 'home_banner_event_2', 'shopee-2.jpg', 'https://shopee.tw', 'liên kết đến Shopee', 'Hiển thị'),
(6, 'home_banner_event_3', 'shopee-3.jpg', 'https://shopee.tw', 'Liên kết đến Shopee', 'Hiển thị'),
(7, 'home_banner_event_4', 'shopee-04.webp', 'https://shopee.tw', 'Liên kết đến shopee', 'Hiển thị'),
(8, 'home_banner_promotion_1', 'shopee-05.jpg', 'https://shopee.tw', 'Liên kết đến shopee', 'Hiển thị'),
(9, 'home_banner_promotion_2', 'shopee-06.jpg', 'https://shopee.tw', 'Liên kết đến shopee', 'Hiển thị'),
(10, 'home_banner_promotion_3', 'shopee-07.jpg', 'https://shopee.tw', 'Liên kết đến shopee', 'Hiển thị'),
(11, 'home_banner_ads', 'shopee-05.jpg', 'https://shopee.tw', 'Liên kết đến shopee', 'Hiển thị'),
(12, 'home_banner_product', 'shopee-09.jfif', 'https://shopee.tw', 'Liên kết đến Shopee', 'Hiển thị');

-- --------------------------------------------------------

--
-- Table structure for table `quatang_sukien`
--

CREATE TABLE `quatang_sukien` (
  `id` int NOT NULL,
  `id_bienthe` int NOT NULL,
  `id_chuongtrinh` int NOT NULL,
  `dieukien` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tieude` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thongtin` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hinhanh` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `luotxem` int NOT NULL DEFAULT '0',
  `ngaybatdau` date DEFAULT NULL,
  `ngayketthuc` date DEFAULT NULL,
  `trangthai` enum('Hiển thị','Tạm ẩn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hiển thị',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quatang_sukien`
--

INSERT INTO `quatang_sukien` (`id`, `id_bienthe`, `id_chuongtrinh`, `dieukien`, `tieude`, `thongtin`, `hinhanh`, `luotxem`, `ngaybatdau`, `ngayketthuc`, `trangthai`, `deleted_at`) VALUES
(1, 1, 1, '2', 'Ưu đãi sinh nhật 13/10 - Tặng 1 sản phẩm bất kỳ', 'Mua 2 sản phẩm từ Trung Tâm Bán Hàng Siêu Thị Vina để nhận được ưu đãi tặng 1 sản phẩm nhân ngày sinh nhật 13/10', 'thuc-pham-bao-ve-suc-khoe-midu-menaq7-180mcg-2.webp', 0, '2025-10-18', '2025-11-02', 'Hiển thị', NULL),
(2, 2, 1, '5', 'Tặng 1 sản phẩm từ thương hiệu khi thêm 5 sản phẩm bất kỳ trong giỏ hàng của thương hiệu', 'Không có thông tin', 'sam-ngoc-linh-truong-sinh-do-thung-24lon-1.webp', 5, '2025-10-18', '2025-10-25', 'Hiển thị', NULL),
(3, 18, 1, '3', 'Tặng 1 quà Trung Thu khi mua 3 sản phẩm từ Trung Tâm Bán Hàng', 'Không có thông tin', 'banh-trung-thu-2025-thu-an-nhien-banh-chay-hop-2-banh-1-tra-1.webp', 12, '2025-10-01', '2025-11-20', 'Hiển thị', NULL),
(4, 27, 1, '2', 'Tặng 1 thiết bị y tế khi 2 sản phẩm y tế khác nhau của thương hiệu y tế ABENA', 'Không có thông tin', 'tam-lot-abena-pad-45x45-1.webp', 0, '2025-10-13', '2025-12-31', 'Hiển thị', NULL),
(5, 17, 1, '3', 'Tặng 1 sản phẩm bách hóa khi mua 3 sản phẩm bất kỳ từ Trung Tâm Bán Hàng nhân ngày sinh nhật 13/10', 'Không có thông tin', 'nuoc-rua-bat-bio-formula-bo-va-lo-hoi-tui-500ml-1.webp', 1200, '2025-10-13', '2025-12-31', 'Hiển thị', NULL),
(6, 44, 1, '3', 'Tặng 1 hộp quà tặng cao cấp từ NEST100 Ngũ Phúc Luxury', 'Mua bộ 3 sản phẩm khác nhau từ cửa hàng thương hiệu NEST100, tặng 1 hộp quà tặng cao cấp Ngũ Phúc Luxury trị giá ~900.000 VNĐ nhân dịp gần đầu năm 2026', 'hop-qua-tang-cao-cap-ngu-phuc-luxury-to-yen-tinh-che-va-yen-chung-nest100-cao-cap-kem-tui-2.webp', 5, '2025-10-01', '2026-02-15', 'Hiển thị', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sanpham`
--

CREATE TABLE `sanpham` (
  `id` int NOT NULL,
  `id_thuonghieu` int NOT NULL,
  `ten` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mota` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `xuatxu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sanxuat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trangthai` enum('Công khai','Chờ duyệt','Tạm ẩn','Tạm khóa') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Chờ duyệt',
  `giamgia` int NOT NULL DEFAULT '0',
  `luotxem` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Sản phẩm';

--
-- Dumping data for table `sanpham`
--

INSERT INTO `sanpham` (`id`, `id_thuonghieu`, `ten`, `slug`, `mota`, `xuatxu`, `sanxuat`, `trangthai`, `giamgia`, `luotxem`, `deleted_at`) VALUES
(1, 1, 'Keo ong xanh Tracybee Propolis Mint & Honey – Giảm đau rát họng, ho, viêm họng (Vị Bạc Hà)', 'keo-ong-xanh-tracybee-propolis-mint-honey-giam-dau-rat-hong-ho-viem-hong-vi-bac-ha', 'Bạn đang tìm kiếm giải pháp kháng khuẩn tự nhiên và giảm đau họng tức thì? Keo ong xanh Tracybee Propolis Mint & Honey là sự kết hợp hoàn hảo giữa dược liệu quý từ thiên nhiên và hương vị the mát, giúp bạn vượt qua những cơn đau rát họng, ho và viêm họng khó chịu một cách nhanh chóng.', 'Brazil', 'Nhập khẩu chính ngạch bởi Siêu Thị Vina', 'Công khai', 10, 1, NULL),
(2, 1, 'Mật ong Tây Bắc đông trùng hạ thảo X3 (Hũ 240g)', 'mat-ong-tay-bac-dong-trung-ha-thao-x3-hu-240g', 'Mật ong Tây Bắc Đông Trùng Hạ Thảo X3 là siêu phẩm bồi bổ sức khỏe, kết hợp giữa mật ong rừng Tây Bắc nguyên chất và hàm lượng Đông Trùng Hạ Thảo được tăng cường gấp 3 lần (X3). Sản phẩm mang đến giải pháp tiện lợi và hiệu quả tối ưu để nâng cao thể trạng, tăng cường đề kháng và phục hồi sức khỏe.', 'Việt Nam', 'Việt Nam', 'Công khai', 20, 0, NULL),
(3, 1, 'Sâm Ngọc Linh trường sinh đỏ (Thùng 24lon)', 'sam-ngoc-linh-truong-sinh-do-thung-24lon', 'Sâm Ngọc Linh Trường Sinh Đỏ là tinh hoa của dược liệu quý hiếm, mang đến giải pháp tiện lợi để bồi bổ sức khỏe và nâng cao thể trạng mỗi ngày. Được chiết xuất từ Sâm Ngọc Linh quý giá – \"Quốc bảo của Việt Nam\" – sản phẩm ở dạng lon uống liền giúp bạn hấp thu trọn vẹn dưỡng chất một cách nhanh chóng và hiệu quả.', 'Việt Nam', 'Việt Nam', 'Công khai', 0, 3, NULL),
(4, 1, 'Tinh dầu tràm tự nhiên ECO - Hỗ trợ giảm ho, cảm cúm, sổ mũi, cảm lạnh (Lọ 30ml)', 'tinh-dau-tram-tu-nhien-eco-ho-tro-giam-ho-cam-cum-so-mui-cam-lanh-lo-30ml', 'Tinh Dầu Tràm Tự Nhiên ECO là sản phẩm chiết xuất 100% từ lá tràm nguyên chất, mang trong mình những công dụng truyền thống tuyệt vời trong việc bảo vệ sức khỏe, đặc biệt là hệ hô hấp. Với khả năng kháng khuẩn, làm ấm và thư giãn, Tinh dầu Tràm ECO là người bạn đồng hành không thể thiếu trong tủ thuốc gia đình, giúp đối phó hiệu quả với các triệu chứng cảm thông thường.', 'Việt Nam', 'Việt Nam', 'Công khai', 85, 0, NULL),
(5, 1, 'Sữa non tổ yến Papamilk Height & Gain giúp tăng cân tăng chiều cao cho Trẻ từ 1-19 tuổi - Lon 830G', 'sua-non-to-yen-papamilk-height-gain-giup-tang-can-tang-chieu-cao-cho-tre-tu-1-19-tuoi-lon-830g', 'Sữa Non Tổ Yến Papamilk Height & Gain là công thức dinh dưỡng đột phá được thiết kế chuyên biệt để hỗ trợ tăng cân khỏe mạnh và tối ưu hóa chiều cao cho trẻ em và thanh thiếu niên từ 1 đến 19 tuổi. Sự kết hợp độc đáo giữa Sữa Non cao cấp, Tổ Yến quý giá cùng hệ dưỡng chất khoa học giúp con bạn xây dựng nền tảng vững chắc cho một tương lai phát triển vượt trội.', 'Việt Nam', 'Việt Nam', 'Công khai', 20, 0, NULL),
(6, 1, 'hahaha', 'hahahaha', 'ádasdasd', 'ss', 'ss', 'Công khai', 20, 3, NULL),
(9, 1, 'Thực phẩm bảo vệ sức khỏe: Midu MenaQ7 180mcg', 'thuc-pham-bao-ve-suc-khoe-midu-menaq7-180mcg', 'Midu MenaQ7 180mcg bổ sung canxi, Vitamin D3, Vitamin K2 dạng MenaQ7 và Arginine phù hợp với tất cả độ tuổi từ 1 đến 100 tuổi. Đặc biệt giúp phát triển chiều cao cho trẻ em 1-15 tuổi; mẹ bầu bổ sung canxi trong giai đoạn thai kì không gây tiểu đường, không gây táo bón và giúp con cao ngay từ trong bụng mẹ.', 'Việt Nam', 'Việt Nam', 'Công khai', 10, 53, NULL),
(10, 3, 'Collagen thủy phân hỗ trợ Da Móng Tóc Acai Labs Marine Collagen Beauty Australia 90v', 'collagen-thuy-phan-ho-tro-da-mong-toc-acai-labs-marine-collagen-beauty-australia-90v', 'Acacia Labs, với trụ sở chính tại Sydney, Australia, là thương hiệu hàng đầu trong lĩnh vực sản xuất thực phẩm chức năng, vitamin và khoáng chất. Chúng tôi tập trung vào việc nghiên cứu và phát triển các sản phẩm chăm sóc sức khỏe và sắc đẹp, mang đến cho khách hàng những giải pháp toàn diện cho một cuộc sống khỏe mạnh, tràn đầy năng lượng và hạnh phúc.\r\n\r\nKhởi nguồn từ vẻ đẹp thật sự đến từ bên trong, phòng thí nghiệm Acaci Labs với đội ngũ các chuyên gia hàng đầu thế giới đã không ngừng nghiên cứu tìm ra công thức và sản phẩm chất lượng tốt nhất để mang đến hạnh phúc lâu dài cho người sử dụng.', 'Australia', 'Australia', 'Công khai', 0, 84, NULL),
(11, 1, 'Viên uống Bishin Tripeptide Collagen Nhật Bản 60v', 'vien-uong-bishin-tripeptide-collagen-nhat-ban-60v', 'BISHIN chứa tinh chất Collagen tripeptide giúp tăng cường khả năng hấp thụ cho cơ thể, cấu trúc da, giúp da giữ được sự săn chắc, đàn hồi, tươi trẻ, hạn chế được các nếp nhăn (dấu hiệu của sự lão hóa) xuất hiện.', 'Nhật Bản', 'Phân phối tại Việt Nam', 'Công khai', 0, 3, NULL),
(12, 2, 'Dưỡng mi tế bào gốc C’Choi - Bio Placenta Lash Serum', 'duong-mi-te-bao-goc-cchoi-bio-placenta-lash-serum', 'DƯỠNG MI TẾ BÀO GỐC C’CHOI Bio-Placenta Lash Serum', 'Việt Nam', 'Việt Nam', 'Công khai', 30, 45, NULL),
(13, 1, 'Nước rửa bát Bio Formula - Bơ và Lô Hội (Túi 500ml)', 'nuoc-rua-bat-bio-formula-bo-va-lo-hoi-tui-500ml', 'Chiết xuất lô hội giúp làm dịu da tay khi tiếp xúc với chất tẩy rửa, đặc biệt dịu nhẹ với những người có da nhạy cảm. Dầu quả bơ dưỡng ẩm, bảo vệ da tay nhờ các acid béo thiết yếu trong dầu bơ. Chiết xuất rễ cây lá giang hỗ trợ làm sạch an toàn, giảm vi khuẩn bám trên bề mặt bát đĩa.', 'Ukraine', 'Ukraine', 'Công khai', 0, 1206, NULL),
(14, 1, 'Bánh Trung Thu 2025 - Thu An Nhiên (bánh chay hộp 2 bánh 1 trà)', 'banh-trung-thu-2025-thu-an-nhien-banh-chay-hop-2-banh-1-tra', 'Tết Trung Thu - Tết Đoàn Viên là dịp lý tưởng để gửi tặng những món quà ý nghĩa cho bạn bè, gia đình hay đối tác. Không chỉ đơn thuần là một nét đẹp văn hóa, quà tặng Trung Thu còn là biểu hiện của tấm chân tình và lời chúc mọi điều viên mãn. \r\n\r\nThấu hiểu và trân trọng giá trị truyền thống, Nonglamfood gửi đến quý khách hàng bộ quà tặng Trung Thu cao cấp “Thu An Nhiên”. Bánh được tinh tuyển từ dược liệu thượng hạng, làm hoàn toàn thủ công bởi các nghệ nhân có hơn 30 năm kinh nghiệm.\r\n\r\nNonglamfood ra mắt set “Thu An Nhiên” với hai loại bánh trung thu chay đặc biệt, được làm từ các nguyên liệu thượng hạng như blueberry, đông trùng hạ thảo kết hợp với các loại hạt dinh dưỡng như hạt macca, hạt sen,... hứa hẹn không chỉ mang đến những trải nghiệm tuyệt vời khi thưởng thức mà còn mang lại những lợi ích tuyệt vời về sức khỏe.\r\n\r\nTrung thu này, hãy để Nonglamfood đồng hành cùng bạn trên hành trình gửi trao “mỹ vị” mùa trăng đến những người yêu thương của mình nhé! ', 'Việt Nam', 'Việt Nam', 'Công khai', 70, 60, NULL),
(15, 1, 'Hạt điều rang muối loại 1 (còn vỏ lụa) Happy Nuts 500g', 'hat-dieu-rang-muoi-loai-1-con-vo-lua-happy-nuts-500g', 'Hạt điều rang muối Happy Nuts là một trong những loại hạt có hàm lượng carbohydrate, chất xơ thấp, nhưng chúng lại chứa nhiều vitamin, khoáng chất và chất chống oxy hóa. Chúng bao gồm vitamin E, K và B6, cùng với các khoáng chất như đồng, phốt pho, kẽm, magiê, sắt và selen.', 'Việt Nam', 'Việt Nam', 'Công khai', 10, 37399, NULL),
(16, 1, 'Kẹo Quả Sâm không đường Free Suger Ginseng Berry S candy 200g', 'keo-qua-sam-khong-duong-free-suger-ginseng-berry-s-candy-200g', 'Giảm đau họng. (không nên ngậm quá 3 viên/ ngày)\r\n\r\nTăng sinh Collagen.\r\n\r\nCân bằng huyết áp, ổn định thần kinh (khi nhức đầu hay mệt mỏi hãy dùng 1 viên và nghỉ ngơi sau 30 phút sẽ thấy giảm các triệu chứng khó chịu).\r\n\r\nGiảm triệu chứng chóng mặt, buồn nôn do say tàu xe\r\n\r\nBổ sung năng lượng nhanh, giảm stress, lo lắng, nhức đầu, chóng mặt.\r\n\r\nHạn chế cơn thèm ngọt, cung cấp năng lượng cho người bị tiểu đường', 'Hàn Quốc', 'KORYO CONFECTIONERY CO., LTD', 'Công khai', 25, 76, NULL),
(17, 1, 'Bột Matcha Gạo Rang Nhật Bản ONELIFE (Gói 100g)', 'bot-matcha-gao-rang-nhat-ban-onelife-goi-100g', 'Bột Matcha Gạo Rang Nhật Bản Onelife Onlife (Gói 100g) là loại bột trà cao cấp, nhuyễn mịn, được kết hợp giữa bột trà xanh Matcha Nhật Bản và chiết xuất gạo Nhật Niigata Koshihikari rang chín theo tỉ lệ đặc biệt, tạo nên vị trà ngọt hậu tự nhiên, không thêm đường hay bất kỳ thành phần hương liệu nào khác.', 'Việt Nam', 'Việt Nam', 'Công khai', 0, 118, NULL),
(18, 1, 'Nước rửa chén sả chanh COME ON làm sạch bát đĩa, an toàn da tay 1 lít', 'nuoc-rua-chen-sa-chanh-come-on-lam-sach-bat-dia-an-toan-da-tay-1-lit', 'Tên sản phẩm: Nước rửa chén sả chanh COME ON làm sạch bát đĩa, an toàn da tay 1 lít\r\nDung tích: 1 lít\r\nThương hiệu: COME ON', 'Việt Nam', 'Việt Nam', 'Công khai', 0, 73, NULL),
(19, 1, 'Găng lau Abena Wash Gloves (50 miếng/gói)', 'gang-lau-abena-wash-gloves-50-mienggoi', 'Abena là tập đoàn sản xuất sản phẩm chăm sóc sức khỏe hàng đầu đến từ Đan Mạch. Thành lập từ năm 1953, trải qua một giai đoạn hình thành và phát triển, Abena đã chinh phục được các thị trường khó tính Bắc Âu bằng chất lượng sản phẩm cũng như trách nhiệm xã hội của mình. Hầu hết các sản phẩm của công ty đều qua kiểm nghiệm lâm sàn của các chuyên gia da liễu và nhận được các chứng nhận y tế nghiêm ngặt của thị trường Bắc Âu như: Nordic Eco-Label, Asthma Allegry Nordic.', 'Việt Nam', 'Việt Nam', 'Công khai', 0, 52, NULL),
(20, 1, 'Tấm lót giường Abena Pad (giặt được) 85x90cm', 'tam-lot-giuong-abena-pad-giat-duoc-85x90cm', ' Abena là tập đoàn sản xuất sản phẩm chăm sóc sức khỏe hàng đầu đến từ Đan Mạch. Thành lập từ năm 1953, trải qua một giai đoạn hình thành và phát triển, Abena đã chinh phục được các thị trường khó tính Bắc Âu bằng chất lượng sản phẩm cũng như trách nhiệm xã hội của mình. Hầu hết các sản phẩm của công ty đều qua kiểm nghiệm lâm sàn của các chuyên gia da liễu và nhận được các chứng nhận y tế nghiêm ngặt của thị trường Bắc Âu như: Nordic Eco-Label, Asthma Allegry Nordic.', 'Việt Nam', 'Việt Nam', 'Công khai', 0, 76, NULL),
(21, 1, 'Máy Xông Khí Dung Cầm Tay Kachi YS35: Giải Pháp Hô Hấp Linh Hoạt Mọi Lúc, Mọi Nơi', 'may-xong-khi-dung-cam-tay-kachi-ys35-giai-phap-ho-hap-linh-hoat-moi-luc-moi-noi', 'Máy xông khí dung cầm tay Kachi YS35 giúp hỗ trợ điều trị và phòng ngừa các bệnh đường hô hấp như viêm phế quản, hen suyễn, viêm mũi xoang, cảm lạnh… Máy sử dụng công nghệ khí dung tạo hạt sương mịn, dễ thẩm thấu sâu vào hệ hô hấp, hiệu quả cao cho cả người lớn và trẻ em. Thiết kế nhỏ gọn, có thể dùng pin AA hoặc cáp Type-C tiện lợi.', 'Việt Nam', 'Việt Nam', 'Công khai', 0, 865, NULL),
(22, 1, 'Hũ Hít Thảo Dược Nhị Thiên Đường - Hũ 5g', 'hu-hit-thao-duoc-nhi-thien-duong-hu-5g', 'Hơn một Thế Kỷ gắn bó với bao Thế Hệ, thương hiệu Nhị Thiên Đường không chỉ là dầu gió lâu đời mà còn không ngừng đổi mới. Hũ Hít thảo dược Nhị Thiên Đường ra đời, kế thừa Tinh Hoa Trăm Năm, nay được NÂNG TẦM để phù hợp với nhịp sống hiện đại. Nhỏ gọn, tiện lợi, giúp thông mũi, sảng khoái tức thì – Một lựa chọn mới cho mọi độ tuổi, từ dân văn phòng, tài xế đến người lớn tuổi.', 'Việt Nam', 'Việt Nam', 'Công khai', 0, 28, NULL),
(23, 1, 'Tấm lót Abena Pad (45x45)', 'tam-lot-abena-pad-45x45', 'Abena là tập đoàn sản xuất sản phẩm chăm sóc sức khỏe hàng đầu đến từ Đan Mạch. Thành lập từ năm 1953, trải qua một giai đoạn hình thành và phát triển, Abena đã chinh phục được các thị trường khó tính Bắc Âu bằng chất lượng sản phẩm cũng như trách nhiệm xã hội của mình. Hầu hết các sản phẩm của công ty đều qua kiểm nghiệm lâm sàn của các chuyên gia da liễu và nhận được các chứng nhận y tế nghiêm ngặt của thị trường Bắc Âu như: Nordic Eco-Label, Asthma Allegry Nordic.', 'Việt Nam', 'Việt Nam', 'Công khai', 0, 229, NULL),
(24, 4, 'Nước yến sào Nest100 lon 190ml - Khay 30 lon', 'nuoc-yen-sao-nest100-lon-190ml-khay-30-lon', 'Nước Yến Sào cao cấp NEST100 được sản xuất từ yến sào, chứa nhiều acid amin và nguyên tố vi lượng cần thiết giúp Giải khát và làm mát cơ thể an toàn. Tăng cường sức khỏe, giảm căng thẳng, mệt mỏi.', 'Việt Nam', 'Việt Nam', 'Công khai', 0, 3, NULL),
(25, 4, 'Nước yến sào Nest100 lon 190ml - Hộp 5 lon', 'nuoc-yen-sao-nest100-lon-190ml-hop-5-lon', 'Nước Yến Sào cao cấp NEST100 được sản xuất từ yến sào, chứa nhiều acid amin và nguyên tố vi lượng cần thiết giúp Giải khát và làm mát cơ thể an toàn. Tăng cường sức khỏe, giảm căng thẳng, mệt mỏi.', 'Việt Nam', 'Việt Nam', 'Công khai', 0, 134, NULL),
(26, 4, 'Yến tổ Nest100 (Hộp 50g + túi)', 'yen-to-nest100-hop-50g-tui', 'Tổ yến sào Nest100 là sản phẩm của Công ty Aquapharm – yến sào Nest100. Được sản xuất theo quy trình hiện đại, hệ thống quản lý chất lượng theo tiêu chuẩn quốc tế: ISO 22000, HACCP, GMP, FSSC 22000; các công đoạn chế biến từ nguyên liệu đến thành phẩm được quản lý, kiểm soát chặt chẽ. Cam kết chất lượng trong từng sợi yến, tổ yến nguyên chất 100%. Quá trình chế biến làm sạch tổ yến bằng nước RO qua hệ thống lọc tinh và tiệt trùng bằng tia UV. Dùng hệ thống sấy lạnh để giữ được trọn vẹn giá trị dinh dưỡng của tổ yến. Đảm bảo nguyên tắc 3 không trong quá trình chế biến: không chà dầu, không chà muối, không tẩy trắng.', 'Việt Nam', 'Việt Nam', 'Công khai', 5, 7407, NULL),
(27, 5, 'Thực phẩm bảo vệ sức khoẻ ByeAlco (5 viên/vỉ)', 'thuc-pham-bao-ve-suc-khoe-byealco-5-vien-vi', 'BYEALCO là sản phẩm thiên nhiên với công thức đặc biệt được nghiên cứu chiết xuất từ các dược liệu quý. Sản phẩm giúp bảo vệ gan, tăng cường sức khỏe và giảm thiểu tác hại của rượu bia. Sản phẩm được sản xuất tại nhà máy đạt chuẩn GMP, ISO - Đạt các tiêu chuẩn nghiêm ngặt của Bộ y Tế Việt Nam và các tiêu chuẩn Quốc tế.', 'Việt Nam', 'Việt Nam', 'Công khai', 0, 5, NULL),
(28, 5, 'Cà Phê Sâm Canada', 'ca-phe-sam-canada', 'Khi nhắc đến cà phê chất lượng cao, cả thế giới nghĩ ngay đến Việt Nam: Hương thơm nổi bật, vị đậm đà, mạnh mẽ - Là một tài sản quý giá mà thiên nhiên ban tặng cho mảnh đất hình chữ S vốn giàu truyền thống văn hóa, lịch sử. Ở bên kia bán cầu, thổ dân Canada đã sử dụng nhân sâm trong vài nghìn năm như một loại thảo mộc tăng cường sức khỏe. Cà phê sâm Canada ra đời xuất phát từ niềm đam mê bất tận dành cho cà phê và khao khát tạo nên một thức uống không chỉ thơm ngon mà còn giúp người dùng duy trì sức khỏe và sắc đẹp. Sự kết hợp hài hòa giữa công thức truyền thống và hiện đại với hạt cà phê thượng hạng và sâm Canada mang đến loại cà phê sức khỏe riêng biệt trên thị trường giúp người tiêu dùng vừa tận hưởng được hương vị cà phê đậm đà mỗi ngày, vừa chăm sóc sức khỏe từ bên trong', 'Việt Nam', 'Việt Nam', 'Công khai', 0, 3, NULL),
(29, 5, 'Cà phê bào tử Linh Chi phá vách – Giúp tỉnh táo', 'ca-phe-bao-tu-linh-chi-pha-vach-giup-tinh-tao', 'Thực phẩm bổ sung Lingzhi Coffee - Cà phê sức khỏe giúp tỉnh táo, hỗ trợ bảo vệ gan', 'Việt Nam', 'Việt Nam', 'Công khai', 10, 8, NULL),
(30, 4, 'Nước Yến sào Đông trùng hạ thảo Nest100 - Có đường', 'nuoc-yen-sao-dong-trung-ha-thao-nest100-co-duong', 'Thành Phần: \r\nNước, yến sào đã chế biến (10-35%), đông trùng hạ thảo sấy thăng hoa (2500mg/L), đường phèn, chất làm dày (401, 415, 406, 327), chất bảo quản (211), màu tổng hợp (102, 110), hương tổng hợp dùng cho thực phẩm.', 'Việt Nam', 'Việt Nam', 'Công khai', 0, 134, NULL),
(31, 4, 'Nước Yến Sâm Ginnest – Có đường', 'nuoc-yen-sam-ginnest-co-duong', 'Thành Phần: \r\nNước, yến sào đã chế biến (35%), Nhân sâm (2143mg/L), đường phèn, chất làm dày (401, 415, 406, 327), chất bảo quản (211), màu tổng hợp (150d, 110), hương sâm tổng hợp dùng cho thực phẩm.', 'Việt Nam', 'Việt Nam', 'Công khai', 0, 2, NULL),
(32, 4, 'Hộp quà tặng Cao cấp - Ngũ Phúc Luxury tổ yến tinh chế và yến chưng Nest100 cao cấp (kèm túi)', 'hop-qua-tang-cao-cap-ngu-phuc-luxury-to-yen-tinh-che-va-yen-chung-nest100-cao-cap-kem-tui', 'Bộ quà tặng sức khỏe cao cấp bao gồm:\r\n01 hộp tổ yến tinh chế 10g\r\n01 lọ yến cao cấp đường phèn 70ml\r\n01 lọ yến cao cấp đường ăn kiêng 70ml\r\n01 lọ yến cao cấp Đông trùng hạ thảo 70ml\r\n01 lọ yến kids 2in1', 'Việt Nam', 'Việt Nam', 'Công khai', 10, 5, NULL);

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
  `trangthai` enum('Đã đọc','Chưa đọc','Tạm ẩn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thuonghieu`
--

CREATE TABLE `thuonghieu` (
  `id` int NOT NULL,
  `ten` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'logo_shop.jpg',
  `trangthai` enum('Hoạt động','Tạm khóa','Dừng hoạt động') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hoạt động'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `thuonghieu`
--

INSERT INTO `thuonghieu` (`id`, `ten`, `slug`, `logo`, `trangthai`) VALUES
(1, 'Trung Tâm Bán Hàng Siêu Thị Vina', 'trung-tam-ban-hang-sieu-thi-vina', 'trung-tam-ban-hang-sieu-thi-vina.png', 'Hoạt động'),
(2, 'C\'CHOI', 'cchoi', 'thuonghieu-logo.png', 'Hoạt động'),
(3, 'ACACI LABS', 'acaci-labs', 'thuonghieu-logo.png', 'Hoạt động'),
(4, 'GLOBAL (Yến Sào NEST100)', 'global-yen-sao-nest100', 'nest100.jpg', 'Hoạt động'),
(5, 'CHẤT VIỆT GROUP', 'chat-viet-group', 'chatvietgroup.jpg', 'Hoạt động');

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
(3, 'Đồ chơi minecraft', 153),
(4, 'Sách hán ngữ 3', 597),
(5, 'Huyndai decor', 62),
(6, 'Điện nội thất', 125),
(7, 'Móc khóa genshin', 247),
(8, 'Phiền Muộn Của Afratu', 13),
(9, 'Kẹo', 52),
(10, 'Sâm Ngọc Linh', 635),
(11, 'Thầy Hộ', 1),
(12, 'y tế', 1),
(13, 'abena', 77),
(14, 'a', 42),
(15, 'abena pad', 6),
(16, 'thiết bị y tế', 4),
(17, 'cà phê', 1),
(18, 'sâm', 1),
(19, 'bhasnh trung thu', 1),
(20, 'bánh trung thu', 1);

-- --------------------------------------------------------

--
-- Table structure for table `yeuthich`
--

CREATE TABLE `yeuthich` (
  `id` int NOT NULL,
  `id_nguoidung` int NOT NULL,
  `id_sanpham` int NOT NULL,
  `trangthai` enum('Hiển thị','Tạm ẩn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
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
-- Indexes for table `chuongtrinh`
--
ALTER TABLE `chuongtrinh`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `danhgia`
--
ALTER TABLE `danhgia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nguoidung` (`id_nguoidung`),
  ADD KEY `id_sanpham` (`id_sanpham`),
  ADD KEY `id_chitietdonhang` (`id_chitietdonhang`);

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
  ADD KEY `id_phuongthuc` (`id_phuongthuc`),
  ADD KEY `id_diachinguoidung` (`id_diachinguoidung`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_bienthe` (`id_bienthe`),
  ADD KEY `id_sukien` (`id_chuongtrinh`);

--
-- Indexes for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cuahang` (`id_thuonghieu`);

--
-- Indexes for table `thongbao`
--
ALTER TABLE `thongbao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nguoidung` (`id_nguoidung`);

--
-- Indexes for table `thuonghieu`
--
ALTER TABLE `thuonghieu`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `chuongtrinh`
--
ALTER TABLE `chuongtrinh`
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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `hinhanh_sanpham`
--
ALTER TABLE `hinhanh_sanpham`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `loaibienthe`
--
ALTER TABLE `loaibienthe`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `quangcao`
--
ALTER TABLE `quangcao`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `quatang_sukien`
--
ALTER TABLE `quatang_sukien`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `thuonghieu`
--
ALTER TABLE `thuonghieu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tukhoa`
--
ALTER TABLE `tukhoa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
-- Constraints for table `danhgia`
--
ALTER TABLE `danhgia`
  ADD CONSTRAINT `danhgia_ibfk_1` FOREIGN KEY (`id_nguoidung`) REFERENCES `nguoidung` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `danhgia_ibfk_2` FOREIGN KEY (`id_sanpham`) REFERENCES `sanpham` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `danhgia_ibfk_3` FOREIGN KEY (`id_chitietdonhang`) REFERENCES `chitiet_donhang` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

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
  ADD CONSTRAINT `donhang_ibfk_3` FOREIGN KEY (`id_phuongthuc`) REFERENCES `phuongthuc` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `donhang_ibfk_4` FOREIGN KEY (`id_diachinguoidung`) REFERENCES `diachi_nguoidung` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

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
  ADD CONSTRAINT `quatang_sukien_ibfk_3` FOREIGN KEY (`id_chuongtrinh`) REFERENCES `chuongtrinh` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`id_thuonghieu`) REFERENCES `thuonghieu` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

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
