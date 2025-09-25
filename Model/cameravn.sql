-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 25, 2025 lúc 02:29 PM
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
-- Cơ sở dữ liệu: `cameravn`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `summary` text NOT NULL,
  `content` longtext NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `author_name` varchar(100) DEFAULT NULL,
  `views` int(11) DEFAULT 0,
  `status` enum('draft','published','archived') DEFAULT 'draft',
  `featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `published_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `slug`, `summary`, `content`, `image`, `category_id`, `author_id`, `author_name`, `views`, `status`, `featured`, `created_at`, `updated_at`, `published_at`) VALUES
(1, '10 kỹ thuật chụp ảnh phong cảnh đẹp mê hoặc', '10-ky-thuat-chup-anh-phong-canh', 'Khám phá những kỹ thuật chụp ảnh phong cảnh từ các nhiếp ảnh gia chuyên nghiệp. Bài viết tổng hợp 10 kỹ thuật giúp bạn nâng tầm bức ảnh phong cảnh của mình.', 'Nội dung chi tiết bài viết...', 'View/assets/images/blog1.jpg', 1, NULL, 'Nguyễn Văn A', 1250, 'published', 0, '2025-05-24 09:33:24', '2025-05-24 09:33:24', '2023-05-15 00:00:00'),
(2, 'Tìm hiểu về khẩu độ trong nhiếp ảnh: Từ F/1.4 đến F/22', 'tim-hieu-ve-khau-do-trong-nhiep-anh', 'Khẩu độ là một trong những yếu tố quan trọng nhất trong nhiếp ảnh. Bài viết giải thích chi tiết về khẩu độ và cách sử dụng hiệu quả.', 'Nội dung chi tiết bài viết...', 'View/assets/images/blog2.jpg', 2, NULL, 'Trần Thị B', 986, 'published', 0, '2025-05-24 09:33:24', '2025-05-24 09:33:24', '2023-05-10 00:00:00'),
(3, 'Phạm Hoài ThươngPhạm Hoài ThươngPhạm Hoài Thương', 'ph-m-ho-i-th-ngph-m-ho-i-th-ngph-m-ho-i-th-ng', 'Phạm Hoài ThươngPhạm Hoài ThươngPhạm Hoài Thương', '<p>Phạm Ho&agrave;i ThươngPhạm Ho&agrave;i ThươngPhạm Ho&agrave;i ThươngPhạm Ho&agrave;i ThươngPhạm Ho&agrave;i Thương</p>', 'uploads/blog/1748233381_hero.jpg', 4, 5, 'Phạm Hoài Thương', 0, 'published', 0, '2025-05-26 04:23:01', '2025-05-26 04:27:02', NULL),
(24, '10 Mẹo Chụp Ảnh Đẹp Bằng Điện Thoại', '10-meo-chup-anh-dep-bang-dien-thoai', 'Nâng tầm ảnh điện thoại của bạn với những mẹo đơn giản nhưng hiệu quả.', '<p>Chi tiết 10 mẹo...</p>', 'View/assets/images/blog/phone-photography.jpg', 8, 4, 'Bùi Dương Tấn Tài', 500, 'published', 0, '2025-07-12 06:11:02', '2025-07-12 06:11:02', '2025-07-12 13:11:02'),
(25, 'Top Phụ Kiện Nhiếp Ảnh Không Thể Thiếu Khi Du Lịch', 'top-phu-kien-nhiep-anh-khi-du-lich', 'Những phụ kiện nhỏ gọn nhưng hữu ích cho chuyến đi của bạn.', '<p>Danh sách phụ kiện...</p>', 'View/assets/images/blog/travel-accessories.jpg', 8, 5, 'Phạm Hoài Thương', 650, 'published', 1, '2025-07-12 06:11:02', '2025-07-12 06:11:02', '2025-07-12 13:11:02'),
(26, 'Đánh Giá Ống Kính Sony FE 35mm f/1.8', 'danh-gia-ong-kinh-sony-fe-35mm-f1-8', 'Đánh giá chi tiết về hiệu năng và chất lượng của ống kính Sony 35mm f/1.8.', '<p>Bài đánh giá...</p>', 'View/assets/images/blog/sony-35mm-review.jpg', 9, 7, 'Đặng Triệu Vỹ', 400, 'published', 0, '2025-07-12 06:11:02', '2025-07-12 06:11:02', '2025-07-12 13:11:02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Hướng dẫn', 'huong-dan', 'Các bài viết hướng dẫn chi tiết về nhiếp ảnh', '2025-05-24 09:33:23', '2025-05-24 09:33:23'),
(2, 'Kiến thức', 'kien-thuc', 'Kiến thức cơ bản và nâng cao về nhiếp ảnh', '2025-05-24 09:33:23', '2025-05-24 09:33:23'),
(3, 'Thủ thuật', 'thu-thuat', 'Các thủ thuật chụp ảnh hữu ích', '2025-05-24 09:33:23', '2025-05-24 09:33:23'),
(4, 'Hậu kỳ', 'hau-ky', 'Hướng dẫn chỉnh sửa và xử lý ảnh', '2025-05-24 09:33:23', '2025-05-24 09:33:23'),
(5, 'Thiết bị', 'thiet-bi', 'Review và giới thiệu các thiết bị nhiếp ảnh', '2025-05-24 09:33:23', '2025-05-24 09:33:23'),
(8, 'Bài viết', 'bai-viet', 'Các bài viết chung về nhiếp ảnh', '2025-07-12 06:11:02', '2025-07-12 06:11:02'),
(9, 'Sự kiện', 'su-kien', 'Thông tin các sự kiện nhiếp ảnh', '2025-07-12 06:11:02', '2025-07-12 06:11:02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `blog_tags`
--

CREATE TABLE `blog_tags` (
  `blog_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `blog_tags`
--

INSERT INTO `blog_tags` (`blog_id`, `tag_id`) VALUES
(3, 12),
(24, 1),
(24, 14),
(25, 1),
(25, 15),
(26, 2),
(26, 16);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `description`, `logo`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Canon', 'canon', 'Thương hiệu máy ảnh hàng đầu từ Nhật Bản với lịch sử lâu đời và sản phẩm chất lượng cao', NULL, 1, '2025-05-23 09:16:50', '2025-05-23 09:16:50'),
(2, 'Sony', 'sony', 'Thương hiệu máy ảnh và điện tử hàng đầu với công nghệ tiên tiến', NULL, 1, '2025-05-23 09:16:50', '2025-05-23 09:16:50'),
(3, 'Nikon', 'nikon', 'Thương hiệu máy ảnh chuyên nghiệp với hệ thống ống kính đa dạng', NULL, 1, '2025-05-23 09:16:50', '2025-05-23 09:16:50'),
(4, 'Fujifilm', 'fujifilm', 'Thương hiệu máy ảnh nổi tiếng với màu sắc đặc trưng và thiết kế hoài cổ', NULL, 1, '2025-05-23 09:16:50', '2025-05-23 09:16:50'),
(5, 'Panasonic', 'panasonic', 'Thương hiệu điện tử và máy ảnh với công nghệ video vượt trội', NULL, 1, '2025-05-23 09:16:50', '2025-05-23 09:16:50'),
(6, 'Leica', 'leica', 'Thương hiệu máy ảnh cao cấp của Đức với chất lượng vượt trội và thiết kế tinh tế', NULL, 1, '2025-05-23 09:16:50', '2025-05-23 09:16:50');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `options` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `session_id`, `product_id`, `quantity`, `options`, `created_at`, `updated_at`) VALUES
(8, 4, NULL, 6, 1, NULL, '2025-05-24 00:35:00', '2025-05-24 02:44:40');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `parent_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Máy ảnh DSLR', 'dslr', 'Máy ảnh DSLR (Digital Single Lens Reflex) với độ bền cao và chất lượng ảnh vượt trội', NULL, NULL, 1, '2025-05-23 09:16:50', '2025-05-23 09:16:50'),
(2, 'Máy ảnh mirrorless', 'mirrorless', 'Máy ảnh mirrorless (không gương lật) nhỏ gọn với hiệu suất cao', NULL, NULL, 1, '2025-05-23 09:16:50', '2025-05-23 09:16:50'),
(3, 'Máy ảnh compact', 'compact', 'Máy ảnh compact nhỏ gọn, dễ sử dụng, tiện lợi mang theo', NULL, NULL, 1, '2025-05-23 09:16:50', '2025-05-23 09:16:50'),
(4, 'Ống kính (Lens)', 'lens', 'Ống kính chất lượng cao cho mọi nhu cầu nhiếp ảnh', NULL, NULL, 1, '2025-05-23 09:16:50', '2025-05-23 09:16:50'),
(5, 'Phụ kiện', 'phu-kien', 'Phụ kiện chính hãng cho máy ảnh và ống kính', NULL, NULL, 1, '2025-05-23 09:16:50', '2025-05-24 07:58:01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `districts`
--

CREATE TABLE `districts` (
  `id` int(11) NOT NULL,
  `province_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `districts`
--

INSERT INTO `districts` (`id`, `province_id`, `name`, `code`, `created_at`) VALUES
(1, 2, 'Quận 1', 'Q1', '2025-05-24 22:26:36'),
(2, 2, 'Quận 2', 'Q2', '2025-05-24 22:26:36'),
(3, 2, 'Quận 3', 'Q3', '2025-05-24 22:26:36'),
(4, 2, 'Quận 4', 'Q4', '2025-05-24 22:26:36'),
(5, 2, 'Quận 5', 'Q5', '2025-05-24 22:26:36'),
(6, 2, 'Quận 6', 'Q6', '2025-05-24 22:26:36'),
(7, 2, 'Quận 7', 'Q7', '2025-05-24 22:26:36'),
(8, 2, 'Quận 8', 'Q8', '2025-05-24 22:26:36'),
(9, 2, 'Quận 9', 'Q9', '2025-05-24 22:26:36'),
(10, 2, 'Quận 10', 'Q10', '2025-05-24 22:26:36'),
(11, 2, 'Quận 11', 'Q11', '2025-05-24 22:26:36'),
(12, 2, 'Quận 12', 'Q12', '2025-05-24 22:26:36'),
(13, 2, 'Quận Bình Thạnh', 'QBT', '2025-05-24 22:26:36'),
(14, 2, 'Quận Gò Vấp', 'QGV', '2025-05-24 22:26:36'),
(15, 2, 'Quận Phú Nhuận', 'QPN', '2025-05-24 22:26:36'),
(16, 2, 'Quận Tân Bình', 'QTB', '2025-05-24 22:26:36'),
(17, 2, 'Quận Tân Phú', 'QTP', '2025-05-24 22:26:36'),
(18, 2, 'Quận Thủ Đức', 'QTD', '2025-05-24 22:26:36'),
(19, 2, 'Huyện Bình Chánh', 'HBC', '2025-05-24 22:26:36'),
(20, 2, 'Huyện Cần Giờ', 'HCG', '2025-05-24 22:26:36'),
(21, 2, 'Huyện Củ Chi', 'HCC', '2025-05-24 22:26:36'),
(22, 2, 'Huyện Hóc Môn', 'HHM', '2025-05-24 22:26:36'),
(23, 2, 'Huyện Nhà Bè', 'HNB', '2025-05-24 22:26:36'),
(24, 1, 'Quận Ba Đình', 'QBD', '2025-05-24 22:26:36'),
(25, 1, 'Quận Hoàn Kiếm', 'QHK', '2025-05-24 22:26:36'),
(26, 1, 'Quận Tây Hồ', 'QTH', '2025-05-24 22:26:36'),
(27, 1, 'Quận Long Biên', 'QLB', '2025-05-24 22:26:36'),
(28, 1, 'Quận Cầu Giấy', 'QCG', '2025-05-24 22:26:36'),
(29, 1, 'Quận Đống Đa', 'QDD', '2025-05-24 22:26:36'),
(30, 1, 'Quận Hai Bà Trưng', 'QHBT', '2025-05-24 22:26:36'),
(31, 1, 'Quận Hoàng Mai', 'QHM', '2025-05-24 22:26:36'),
(32, 1, 'Quận Thanh Xuân', 'QTX', '2025-05-24 22:26:36'),
(33, 1, 'Huyện Sóc Sơn', 'HSS', '2025-05-24 22:26:36'),
(34, 1, 'Huyện Đông Anh', 'HDA', '2025-05-24 22:26:36'),
(35, 1, 'Huyện Gia Lâm', 'HGL', '2025-05-24 22:26:36'),
(36, 1, 'Huyện Nam Từ Liêm', 'HNTL', '2025-05-24 22:26:36'),
(37, 1, 'Huyện Bắc Từ Liêm', 'HBTL', '2025-05-24 22:26:36'),
(38, 1, 'Huyện Me Linh', 'HML', '2025-05-24 22:26:36'),
(39, 1, 'Huyện Hà Đông', 'HHD', '2025-05-24 22:26:36'),
(40, 1, 'Huyện Sơn Tây', 'HST', '2025-05-24 22:26:36'),
(41, 1, 'Huyện Ba Vì', 'HBV', '2025-05-24 22:26:36'),
(42, 1, 'Huyện Phúc Thọ', 'HPT', '2025-05-24 22:26:36'),
(43, 1, 'Huyện Đan Phượng', 'HDP', '2025-05-24 22:26:36'),
(44, 1, 'Huyện Hoài Đức', 'HHD2', '2025-05-24 22:26:36'),
(45, 1, 'Huyện Quốc Oai', 'HQO', '2025-05-24 22:26:36'),
(46, 1, 'Huyện Thạch Thất', 'HTT', '2025-05-24 22:26:36'),
(47, 1, 'Huyện Chương Mỹ', 'HCM', '2025-05-24 22:26:36'),
(48, 1, 'Huyện Thanh Oai', 'HTO', '2025-05-24 22:26:36'),
(49, 1, 'Huyện Thường Tín', 'HTT2', '2025-05-24 22:26:36'),
(50, 1, 'Huyện Phú Xuyên', 'HPX', '2025-05-24 22:26:36'),
(51, 1, 'Huyện Ứng Hòa', 'HUH', '2025-05-24 22:26:36'),
(52, 1, 'Huyện Mỹ Đức', 'HMD', '2025-05-24 22:26:36');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `district` varchar(100) NOT NULL,
  `ward` varchar(100) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(50) NOT NULL,
  `payment_status` enum('pending','completed','failed','refunded') NOT NULL DEFAULT 'pending',
  `shipping_method` varchar(50) NOT NULL,
  `tracking_number` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `email`, `phone`, `address`, `city`, `district`, `ward`, `total_amount`, `shipping_fee`, `discount_amount`, `tax_amount`, `status`, `payment_method`, `payment_status`, `shipping_method`, `tracking_number`, `notes`, `created_at`, `updated_at`) VALUES
(1, 7, 'Đặng Triệu Vỹ', '52300274@tdtu.edu.vn', '0945727010', 'cac', 'TP.HCM', 'Quận 1', 'Phường 2', 2012637000.00, 0.00, 0.00, 99999999.99, 'processing', 'cod', 'pending', 'standard', '', 'acac', '2025-05-25 15:03:38', '2025-05-25 22:14:26'),
(2, 7, 'Đặng Triệu Vỹ', '52300274@tdtu.edu.vn', '0945727010', 'asd', 'Hà Nội', 'Quận 1', 'Phường 2', 47289000.00, 0.00, 0.00, 4299000.00, 'cancelled', 'cod', 'pending', 'standard', '', 'asd', '2025-05-25 15:07:57', '2025-05-25 22:12:46'),
(3, 7, 'Đặng Triệu Vỹ', '52300274@student.tdtu.edu.vn', '0945727010', 'phiền', 'TP.HCM', 'Quận 1', 'Phường 1', 62689000.00, 0.00, 0.00, 5699000.00, 'cancelled', 'cod', 'pending', 'standard', '', '', '2025-05-26 08:25:58', '2025-05-26 08:26:35'),
(4, 7, 'Đặng Triệu Vỹ', '52300274@student.tdtu.edu.vn', '0945727010', 'phien', 'TP.HCM', 'Quận 1', 'Phường 1', 47289000.00, 0.00, 0.00, 4299000.00, 'pending', 'cod', 'pending', 'standard', NULL, '', '2025-05-26 08:28:15', '2025-05-26 08:28:15'),
(5, 8, 'Phạm Hoài Thương', 'phucoccho0147@gmail.com', '0708624193', 'asd', 'TP.HCM', 'Quận 2', 'Phường 1', 53889000.00, 0.00, 0.00, 4899000.00, 'pending', 'cod', 'pending', 'standard', NULL, '', '2025-05-26 03:40:04', '2025-05-26 03:40:04'),
(6, 9, 'Phạm Hoài Thương', 'terrybin50@gmail.com', '0708624193', 'asdadasd', 'Hà Nội', 'Quận 3', 'Phường 2', 250806000.00, 50000.00, 0.00, 22796000.00, 'shipped', 'cod', 'pending', 'express', '', 'asd', '2025-05-26 04:15:15', '2025-05-26 04:21:54'),
(7, 9, 'Phạm Hoài Thương', 'terrybin50@gmail.com', '0708624193', 'asdsadsadsadsad', 'Đà Nẵng', 'Quận 2', 'Phường 3', 1149488998.90, 0.00, 0.00, 99999999.99, 'pending', 'cod', 'pending', 'standard', NULL, 'asdasd', '2025-05-26 04:28:52', '2025-05-26 04:28:52'),
(8, 9, 'Phạm Hoài Thương', 'terrybin50@gmail.com', '0708624193', 'asdsadsadsadsa', 'Hà Nội', 'Quận 2', 'Phường 2', 141867000.00, 0.00, 0.00, 12897000.00, 'pending', 'cod', 'pending', 'standard', NULL, 'asdasdsadasd', '2025-05-26 20:01:27', '2025-05-26 20:01:27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `options` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `name`, `price`, `quantity`, `options`) VALUES
(1, 1, 2, 'Sony Alpha A7 IV', 52490000.00, 10, NULL),
(3, 1, 3, 'Nikon Z6 II', 44990000.00, 8, NULL),
(4, 2, 4, 'Fujifilm X-T5', 42990000.00, 1, NULL),
(5, 3, 5, 'Canon RF 24-70mm f/2.8L IS USM', 56990000.00, 1, NULL),
(6, 4, 4, 'Fujifilm X-T5', 42990000.00, 1, NULL),
(7, 5, 6, 'Sony FE 50mm f/1.4 GM', 48990000.00, 1, NULL),
(8, 6, 5, 'Canon RF 24-70mm f/2.8L IS USM', 56990000.00, 4, NULL),
(9, 7, 3, 'Nikon Z6 II', 44990000.00, 1, NULL),
(10, 7, 18, 'Phạm Hoài Thương', 999999999.00, 1, NULL),
(11, 8, 4, 'Fujifilm X-T5', 42990000.00, 3, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(15,2) NOT NULL,
  `old_price` decimal(15,2) DEFAULT NULL,
  `cost` decimal(15,2) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `sold_count` int(11) NOT NULL DEFAULT 0,
  `image_url` varchar(255) DEFAULT NULL,
  `images` text DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `dimensions` varchar(100) DEFAULT NULL,
  `specifications` text DEFAULT NULL,
  `colors` text DEFAULT NULL,
  `variations` text DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0 COMMENT 'Sản phẩm nổi bật',
  `is_new` tinyint(1) DEFAULT 0 COMMENT 'Sản phẩm mới',
  `is_hot` tinyint(1) NOT NULL DEFAULT 0,
  `is_best` tinyint(1) NOT NULL DEFAULT 0,
  `rating` decimal(3,1) NOT NULL DEFAULT 0.0,
  `reviews_count` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `badges` text DEFAULT NULL COMMENT 'JSON array chứa các badge: hot, new, bestseller, discount',
  `is_bestseller` tinyint(1) DEFAULT 0 COMMENT 'Sản phẩm bán chạy',
  `is_discount` tinyint(1) DEFAULT 0 COMMENT 'Sản phẩm giảm giá',
  `is_promotion` tinyint(1) DEFAULT 0 COMMENT 'Sản phẩm khuyến mãi',
  `promotion_url` varchar(500) DEFAULT NULL COMMENT 'Link custom cho nút mua ngay'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `sku`, `short_description`, `description`, `price`, `old_price`, `cost`, `stock`, `sold_count`, `image_url`, `images`, `category_id`, `brand_id`, `weight`, `dimensions`, `specifications`, `colors`, `variations`, `is_featured`, `is_new`, `is_hot`, `is_best`, `rating`, `reviews_count`, `status`, `created_at`, `updated_at`, `badges`, `is_bestseller`, `is_discount`, `is_promotion`, `promotion_url`) VALUES
(2, 'Sony Alpha A7 IV', 'sony-alpha-a7-iv', 'CAM-SON-A7IV', 'Máy ảnh mirrorless full-frame đa dụng với cảm biến mới, lý tưởng cho cả nhiếp ảnh và video', 'Sony Alpha A7 IV là máy ảnh mirrorless full-frame thế hệ thứ 4 với cảm biến back-illuminated 33MP mới, bộ xử lý BIONZ XR, quay video 4K60p 10-bit 4:2:2 và khả năng kết nối trực tiếp. Máy còn được trang bị màn hình cảm ứng lật xoay và hệ thống AF tiên tiến.', 52490000.00, 54990000.00, NULL, 0, 40, 'View/assets/images/products/sony-alpha-a7-iv.jpg', NULL, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 4.9, 28, 1, '2025-05-23 09:16:50', '2025-05-26 07:41:50', '[\"bestseller\"]', 0, 0, 0, NULL),
(3, 'Nikon Z6 II', 'nikon-z6-ii', 'CAM-NIK-Z6II', 'Máy ảnh mirrorless full-frame đa dụng với hiệu suất cao và khả năng quay video chuyên nghiệp', 'Nikon Z6 II là máy ảnh mirrorless full-frame với cảm biến BSI CMOS 24.5MP, bộ xử lý kép EXPEED 6, chụp liên tiếp 14fps, quay video 4K60p và hệ thống AF 273 điểm. Máy còn được trang bị 2 khe cắm thẻ nhớ và khả năng kết nối không dây.', 44990000.00, 47990000.00, NULL, 3, 27, 'View/assets/images/products/nikon-z6-ii.jpg', NULL, 2, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 4.7, 15, 1, '2025-05-23 09:16:50', '2025-05-26 04:28:52', '[\"discount\"]', 0, 0, 0, NULL),
(4, 'Fujifilm X-T5', 'fujifilm-x-t5', 'CAM-FUJ-XT5', 'Máy ảnh mirrorless APS-C với cảm biến 40MP, lý tưởng cho nhiếp ảnh phong cảnh và đường phố', 'Fujifilm X-T5 là máy ảnh mirrorless cao cấp với cảm biến X-Trans CMOS 5 HR 40.2MP, bộ xử lý X-Processor 5, chụp liên tiếp 15fps, quay video 6.2K và ổn định hình ảnh trong thân máy 7 stop. Thiết kế nhỏ gọn với nút điều khiển vật lý đặc trưng của Fujifilm.', 42990000.00, 0.00, NULL, 3, 17, 'View/assets/images/products/fujifilm-x-t5.jpg', NULL, 2, 4, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 4.8, 9, 1, '2025-05-23 09:16:50', '2025-05-26 20:01:27', '[\"new\"]', 0, 0, 0, NULL),
(5, 'Canon RF 24-70mm f/2.8L IS USM', 'canon-rf-24-70mm-f28l-is-usm', 'LENS-CAN-RF2470F28L', 'Ống kính zoom tiêu chuẩn chuyên nghiệp cho máy ảnh Canon mirrorless', 'Canon RF 24-70mm f/2.8L IS USM là ống kính zoom tiêu chuẩn dòng L cho máy ảnh Canon mirrorless mount RF với khẩu độ f/2.8 ổn định, hệ thống ổn định hình ảnh 5 stop, motor lấy nét USM siêu âm nhanh và chính xác. Thiết kế chống bụi và nước với chất lượng hình ảnh vượt trội.', 56990000.00, 59990000.00, NULL, 0, 20, 'View/assets/images/products/canon-rf-24-70mm-f28l.jpg', NULL, 4, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 4.9, 18, 1, '2025-05-23 09:16:50', '2025-05-26 04:15:15', NULL, 0, 0, 0, NULL),
(6, 'Sony FE 50mm f/1.4 GM', 'sony-fe-50mm-f-1-4-gm', 'LENS-SON-FE50F14GM', 'Sony FE 50mm f/1.4 GM là ống kính prime dòng G Master cao cấp với khẩu độ lớn f/1.4, thiết kế nhỏ gọn, motor XD Linear cho lấy nét nhanh và êm, hiệu ứng bokeh đẹp mắt. Được thiết kế cho máy ảnh mirrorless full-frame Sony với khả năng chống bụi và ẩm.', 'Sony FE 50mm f/1.4 GM là ống kính prime dòng G Master cao cấp với khẩu độ lớn f/1.4, thiết kế nhỏ gọn, motor XD Linear cho lấy nét nhanh và êm, hiệu ứng bokeh đẹp mắt. Được thiết kế cho máy ảnh mirrorless full-frame Sony với khả năng chống bụi và ẩm.', 48990000.00, 0.00, NULL, 13, 9, 'View/assets/images/products/sony-fe-50mm-f14-gm.jpg', NULL, 4, 2, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 5.0, 6, 1, '2025-05-23 09:16:50', '2025-05-26 03:40:04', '[\"hot\"]', 0, 0, 0, NULL),
(18, 'Phạm Hoài Thương', 'pham-hoai-thuong', NULL, 'Phạm Hoài ThươngPhạm Hoài ThươngPhạm Hoài ThươngPhạm Hoài ThươngPhạm Hoài ThươngPhạm Hoài ThươngPhạm Hoài ThươngPhạm Hoài Thương', 'Phạm Hoài ThươngPhạm Hoài ThươngPhạm Hoài ThươngPhạm Hoài ThươngPhạm Hoài ThươngPhạm Hoài ThươngPhạm Hoài ThươngPhạm Hoài Thương', 999999999.00, 1111111111.00, NULL, 49, 1, 'View/assets/images/products/6833ebadcc5b5_hero - Copy.jpg', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0.0, 0, 1, '2025-05-26 04:18:53', '2025-05-26 04:28:52', '[\"hot\"]', 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `provinces`
--

CREATE TABLE `provinces` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `provinces`
--

INSERT INTO `provinces` (`id`, `name`, `code`, `created_at`) VALUES
(1, 'Hà Nội', 'HN', '2025-05-24 22:26:36'),
(2, 'TP. Hồ Chí Minh', 'HCM', '2025-05-24 22:26:36'),
(3, 'Đà Nẵng', 'DN', '2025-05-24 22:26:36'),
(4, 'Cần Thơ', 'CT', '2025-05-24 22:26:36'),
(5, 'Hải Phòng', 'HP', '2025-05-24 22:26:36'),
(6, 'An Giang', 'AG', '2025-05-24 22:26:36'),
(7, 'Bà Rịa - Vũng Tàu', 'BRVT', '2025-05-24 22:26:36'),
(8, 'Bắc Giang', 'BG', '2025-05-24 22:26:36'),
(9, 'Bắc Kạn', 'BK', '2025-05-24 22:26:36'),
(10, 'Bạc Liêu', 'BL', '2025-05-24 22:26:36'),
(11, 'Bắc Ninh', 'BN', '2025-05-24 22:26:36'),
(12, 'Bến Tre', 'BT', '2025-05-24 22:26:36'),
(13, 'Bình Định', 'BD', '2025-05-24 22:26:36'),
(14, 'Bình Dương', 'BDUONG', '2025-05-24 22:26:36'),
(15, 'Bình Phước', 'BP', '2025-05-24 22:26:36'),
(16, 'Bình Thuận', 'BTH', '2025-05-24 22:26:36'),
(17, 'Cà Mau', 'CM', '2025-05-24 22:26:36'),
(18, 'Cao Bằng', 'CB', '2025-05-24 22:26:36'),
(19, 'Đắk Lắk', 'DL', '2025-05-24 22:26:36'),
(20, 'Đắk Nông', 'DNONG', '2025-05-24 22:26:36'),
(21, 'Điện Biên', 'DB', '2025-05-24 22:26:36'),
(22, 'Đồng Nai', 'DNAI', '2025-05-24 22:26:36'),
(23, 'Đồng Tháp', 'DT', '2025-05-24 22:26:36'),
(24, 'Gia Lai', 'GL', '2025-05-24 22:26:36'),
(25, 'Hà Giang', 'HG', '2025-05-24 22:26:36'),
(26, 'Hà Nam', 'HNAM', '2025-05-24 22:26:36'),
(27, 'Hà Tĩnh', 'HT', '2025-05-24 22:26:36'),
(28, 'Hải Dương', 'HD', '2025-05-24 22:26:36'),
(29, 'Hậu Giang', 'HGG', '2025-05-24 22:26:36'),
(30, 'Hòa Bình', 'HB', '2025-05-24 22:26:36'),
(31, 'Hưng Yên', 'HY', '2025-05-24 22:26:36'),
(32, 'Khánh Hòa', 'KH', '2025-05-24 22:26:36'),
(33, 'Kiên Giang', 'KG', '2025-05-24 22:26:36'),
(34, 'Kon Tum', 'KT', '2025-05-24 22:26:36'),
(35, 'Lai Châu', 'LC', '2025-05-24 22:26:36'),
(36, 'Lâm Đồng', 'LD', '2025-05-24 22:26:36'),
(37, 'Lạng Sơn', 'LS', '2025-05-24 22:26:36'),
(38, 'Lào Cai', 'LCA', '2025-05-24 22:26:36'),
(39, 'Long An', 'LA', '2025-05-24 22:26:36'),
(40, 'Nam Định', 'ND', '2025-05-24 22:26:36'),
(41, 'Nghệ An', 'NA', '2025-05-24 22:26:36'),
(42, 'Ninh Bình', 'NB', '2025-05-24 22:26:36'),
(43, 'Ninh Thuận', 'NT', '2025-05-24 22:26:36'),
(44, 'Phú Thọ', 'PT', '2025-05-24 22:26:36'),
(45, 'Phú Yên', 'PY', '2025-05-24 22:26:36'),
(46, 'Quảng Bình', 'QB', '2025-05-24 22:26:36'),
(47, 'Quảng Nam', 'QN', '2025-05-24 22:26:36'),
(48, 'Quảng Ngãi', 'QNG', '2025-05-24 22:26:36'),
(49, 'Quảng Ninh', 'QNH', '2025-05-24 22:26:36'),
(50, 'Quảng Trị', 'QT', '2025-05-24 22:26:36'),
(51, 'Sóc Trăng', 'ST', '2025-05-24 22:26:36'),
(52, 'Sơn La', 'SL', '2025-05-24 22:26:36'),
(53, 'Tây Ninh', 'TN', '2025-05-24 22:26:36'),
(54, 'Thái Bình', 'TB', '2025-05-24 22:26:36'),
(55, 'Thái Nguyên', 'TNG', '2025-05-24 22:26:36'),
(56, 'Thanh Hóa', 'TH', '2025-05-24 22:26:36'),
(57, 'Thừa Thiên Huế', 'TTH', '2025-05-24 22:26:36'),
(58, 'Tiền Giang', 'TG', '2025-05-24 22:26:36'),
(59, 'Trà Vinh', 'TV', '2025-05-24 22:26:36'),
(60, 'Tuyên Quang', 'TQ', '2025-05-24 22:26:36'),
(61, 'Vĩnh Long', 'VL', '2025-05-24 22:26:36'),
(62, 'Vĩnh Phúc', 'VP', '2025-05-24 22:26:36'),
(63, 'Yên Bái', 'YB', '2025-05-24 22:26:36');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `comment` text NOT NULL,
  `images` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tags`
--

INSERT INTO `tags` (`id`, `name`, `slug`, `created_at`) VALUES
(1, 'Nhiếp ảnh', 'nhiep-anh', '2025-05-24 09:33:24'),
(2, 'Máy ảnh', 'may-anh', '2025-05-24 09:33:24'),
(3, 'Ống kính', 'ong-kinh', '2025-05-24 09:33:24'),
(4, 'Khẩu độ', 'khau-do', '2025-05-24 09:33:24'),
(5, 'Tốc độ màn trập', 'toc-do-man-trap', '2025-05-24 09:33:24'),
(6, 'ISO', 'iso', '2025-05-24 09:33:24'),
(7, 'Chụp ảnh chân dung', 'chup-anh-chan-dung', '2025-05-24 09:33:24'),
(8, 'Chụp ảnh phong cảnh', 'chup-anh-phong-canh', '2025-05-24 09:33:24'),
(9, 'Hậu kỳ', 'hau-ky', '2025-05-24 09:33:24'),
(10, 'Lightroom', 'lightroom', '2025-05-24 09:33:24'),
(11, 'Photoshop', 'photoshop', '2025-05-24 09:33:24'),
(12, 'DSLR', 'dslr', '2025-05-24 09:33:24'),
(13, 'Mirrorless', 'mirrorless', '2025-05-24 09:33:24'),
(14, 'Mẹo', 'meo', '2025-07-12 06:11:02'),
(15, 'Phụ kiện', 'phu-kien', '2025-07-12 06:11:02'),
(16, 'Đánh giá', 'danh-gia', '2025-07-12 06:11:02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `ward` varchar(100) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` enum('admin','staff','customer') NOT NULL DEFAULT 'customer',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `birthday`, `gender`, `address`, `city`, `district`, `ward`, `avatar`, `role`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Nhân viên', 'staff@cameravn.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0987654321', NULL, NULL, 'Đại học Tôn Đức Thắng', 'TP.HCM', 'Quận 7', 'Phường Tân Phú', NULL, 'staff', 1, '2025-05-23 09:16:50', '2025-05-23 09:16:50'),
(4, 'Bùi Dương Tấn Tài', '52300154@student.tdtu.edu.vn', '$2y$10$ZIlbFSCaKAfMupItJsg0j.UH1hHRq4rzOd5sc6g/31T3zevUBg3PG', '0868212407', NULL, NULL, '', '', '', '', 'View/assets/images/uploads/users/683123efce74f_IMG_4423.jpeg', 'admin', 1, '2025-05-23 16:42:12', '2025-05-25 16:31:33'),
(5, 'Phạm Hoài Thương', '52300262@student.tdtu.edu.vn', '$2y$10$v8pKe.YFjSAvyWFieZGGfeA657s8/sIYQRclmwfFeJpypNCFesSz2', '0708624193', NULL, NULL, NULL, NULL, NULL, NULL, '../View/assets/images/uploads/users/6833edbfc1f43_blog3.jpg', 'admin', 1, '2025-05-24 06:59:29', '2025-05-26 04:27:43'),
(6, 'Phạm Hoài Thương', 'binmin81@gmail.com', '$2y$10$7CrnacSQoNfEeQAWWxO2.u8tA57hr8hNfLhmBqfPxi/p6xqnsp1d.', '0708624193', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'customer', 1, '2025-05-24 07:13:52', '2025-05-24 07:13:52'),
(7, 'Đặng Triệu Vỹ', '52300274@student.tdtu.edu.vn', '$2y$10$BtZSvDrK93ynw3953ImhPOcSWqCwknsu7ZP9uI4.VOBaDDokCvBo.', '0945727010', NULL, NULL, '', 'TP.HCM', '', '', NULL, 'admin', 1, '2025-05-24 12:17:25', '2025-05-26 07:32:42'),
(8, 'Phạm Hoài Thương', 'phucoccho0147@gmail.com', '$2y$10$xJZQZvGYtUEbVXopaEuRy.xLmAnBMwUlWFx5IUS5a/6FrtmM79Cxm', '0708624193', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'customer', 1, '2025-05-26 03:30:04', '2025-05-26 03:30:04'),
(9, 'Phạm Hoài Thương', 'terrybin50@gmail.com', '$2y$10$i/jtlyIunUV5LsrwWvPyMOBBBeRcQ0dmTya5phQzndVX8Ij/5TusC', '0708624193', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'customer', 1, '2025-05-26 04:08:42', '2025-05-26 04:08:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wards`
--

CREATE TABLE `wards` (
  `id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `wards`
--

INSERT INTO `wards` (`id`, `district_id`, `name`, `code`, `created_at`) VALUES
(1, 1, 'Phường Tân Định', 'PTD', '2025-05-24 22:26:36'),
(2, 1, 'Phường Đa Kao', 'PDK', '2025-05-24 22:26:36'),
(3, 1, 'Phường Bến Nghé', 'PBN', '2025-05-24 22:26:36'),
(4, 1, 'Phường Bến Thành', 'PBT', '2025-05-24 22:26:36'),
(5, 1, 'Phường Nguyễn Thái Bình', 'PNTB', '2025-05-24 22:26:36'),
(6, 1, 'Phường Phạm Ngũ Lão', 'PPNL', '2025-05-24 22:26:36'),
(7, 1, 'Phường Cầu Ông Lãnh', 'PCOL', '2025-05-24 22:26:36'),
(8, 1, 'Phường Cô Giang', 'PCG', '2025-05-24 22:26:36'),
(9, 1, 'Phường Nguyễn Cư Trinh', 'PNCT', '2025-05-24 22:26:36'),
(10, 1, 'Phường Cầu Kho', 'PCK', '2025-05-24 22:26:36'),
(11, 7, 'Phường Tân Thuận Đông', 'PTTD', '2025-05-24 22:26:36'),
(12, 7, 'Phường Tân Thuận Tây', 'PTTT', '2025-05-24 22:26:36'),
(13, 7, 'Phường Tân Kiểng', 'PTK', '2025-05-24 22:26:36'),
(14, 7, 'Phường Tân Hưng', 'PTH', '2025-05-24 22:26:36'),
(15, 7, 'Phường Bình Thuận', 'PBT7', '2025-05-24 22:26:36'),
(16, 7, 'Phường Tân Quy', 'PTQ', '2025-05-24 22:26:36'),
(17, 7, 'Phường Phú Thuận', 'PPT', '2025-05-24 22:26:36'),
(18, 7, 'Phường Tân Phú', 'PTP7', '2025-05-24 22:26:36'),
(19, 7, 'Phường Tân Phong', 'PTPG', '2025-05-24 22:26:36'),
(20, 7, 'Phường Phú Mỹ', 'PPM', '2025-05-24 22:26:36');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wishlists`
--

CREATE TABLE `wishlists` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_published_at` (`published_at`),
  ADD KEY `idx_views` (`views`);

--
-- Chỉ mục cho bảng `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Chỉ mục cho bảng `blog_tags`
--
ALTER TABLE `blog_tags`
  ADD PRIMARY KEY (`blog_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Chỉ mục cho bảng `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Chỉ mục cho bảng `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `province_id` (`province_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Chỉ mục cho bảng `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `wards`
--
ALTER TABLE `wards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `district_id` (`district_id`);

--
-- Chỉ mục cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_product` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `provinces`
--
ALTER TABLE `provinces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `wards`
--
ALTER TABLE `wards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `blogs_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `blog_tags`
--
ALTER TABLE `blog_tags`
  ADD CONSTRAINT `blog_tags_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blog_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `fk_cart_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `fk_category_parent` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `districts_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_order_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_orderitem_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_orderitem_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_product_brand` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_review_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_review_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `wards`
--
ALTER TABLE `wards`
  ADD CONSTRAINT `wards_ibfk_1` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`);

--
-- Các ràng buộc cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `fk_wishlist_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_wishlist_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
