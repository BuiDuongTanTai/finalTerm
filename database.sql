-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 26, 2025 lúc 06:17 PM
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
(16, 'Cách chọn máy ảnh phù hợp cho người mới bắt đầu', 'cach-chon-may-anh-phu-hop-cho-nguoi-moi-bat-dau', 'Hướng dẫn chi tiết cách chọn máy ảnh đầu tiên phù hợp với nhu cầu và ngân sách.', '<p>Khi bắt đầu hành trình nhiếp ảnh, việc chọn máy ảnh phù hợp là bước đầu tiên quan trọng...</p>', 'View/assets/images/blog-camera-beginner.jpg', 2, 4, 'Bùi Dương Tấn Tài', 2145, 'published', 1, '2025-05-26 16:14:04', '2025-05-26 16:14:04', '2025-05-26 23:14:04'),
(17, 'So sánh DSLR vs Mirrorless: Nên chọn loại nào?', 'so-sanh-dslr-vs-mirrorless-nen-chon-loai-nao', 'Phân tích ưu nhược điểm của máy ảnh DSLR và Mirrorless.', '<p>Cuộc tranh luận giữa DSLR và Mirrorless đã kéo dài nhiều năm...</p>', 'View/assets/images/blog-dslr-vs-mirrorless.jpg', 2, 5, 'Phạm Hoài Thương', 1876, 'published', 1, '2025-05-26 16:14:04', '2025-05-26 16:14:04', '2025-05-26 23:14:04'),
(18, '10 lỗi thường gặp khi chụp ảnh chân dung', '10-loi-thuong-gap-khi-chup-anh-chan-dung', 'Tổng hợp những lỗi phổ biến mà nhiếp ảnh gia mắc phải khi chụp ảnh chân dung.', '<p>Chụp ảnh chân dung là một trong những thể loại nhiếp ảnh phổ biến nhất...</p>', 'View/assets/images/blog-portrait-mistakes.jpg', 3, 7, 'Đặng Triệu Vỹ', 1632, 'published', 0, '2025-05-26 16:14:04', '2025-05-26 16:14:04', '2025-05-26 23:14:04'),
(19, 'Hướng dẫn sử dụng chế độ Manual hiệu quả', 'huong-dan-su-dung-che-do-manual-hieu-qua', 'Khám phá cách sử dụng chế độ Manual để có toàn quyền kiểm soát máy ảnh.', '<p>Chế độ Manual (M) cho phép bạn kiểm soát hoàn toàn các thông số ISO...</p>', 'View/assets/images/blog-manual-mode.jpg', 3, 4, 'Bùi Dương Tấn Tài', 1543, 'published', 1, '2025-05-26 16:14:04', '2025-05-26 16:14:04', '2025-05-26 23:14:04'),
(20, 'Review chi tiết Canon EOS R6 Mark II', 'review-chi-tiet-canon-eos-r6-mark-ii', 'Đánh giá toàn diện về máy ảnh Canon EOS R6 Mark II.', '<p>Canon EOS R6 Mark II là phiên bản nâng cấp đáng chú ý...</p>', 'View/assets/images/blog-r6-mark-ii-review.jpg', 6, 5, 'Phạm Hoài Thương', 2341, 'published', 1, '2025-05-26 16:14:04', '2025-05-26 16:14:04', '2025-05-26 23:14:04'),
(21, 'Kỹ thuật chụp ảnh Golden Hour và Blue Hour', 'ky-thuat-chup-anh-golden-hour-va-blue-hour', 'Tìm hiểu cách tận dụng ánh sáng tự nhiên đẹp nhất trong ngày.', '<p>Golden Hour và Blue Hour là hai khoảng thời gian vàng cho nhiếp ảnh...</p>', 'View/assets/images/blog-golden-blue-hour.jpg', 3, 7, 'Đặng Triệu Vỹ', 1789, 'published', 0, '2025-05-26 16:14:04', '2025-05-26 16:14:04', '2025-05-26 23:14:04'),
(22, 'Cách tạo hiệu ứng Bokeh đẹp mắt', 'cach-tao-hieu-ung-bokeh-dep-mat', 'Bí quyết tạo ra hiệu ứng bokeh ấn tượng trong nhiếp ảnh.', '<p>Bokeh là thuật ngữ để chỉ phần nền mờ trong ảnh...</p>', 'View/assets/images/blog-bokeh-effect.jpg', 3, 4, 'Bùi Dương Tấn Tài', 1234, 'published', 0, '2025-05-26 16:14:04', '2025-05-26 16:14:04', '2025-05-26 23:14:04'),
(23, 'Top 5 máy ảnh mirrorless tốt nhất 2025', 'top-5-may-anh-mirrorless-tot-nhat-2025', 'Danh sách những máy ảnh mirrorless được đánh giá cao nhất năm 2025.', '<p>Thị trường máy ảnh mirrorless ngày càng sôi động...</p>', 'View/assets/images/blog-top-mirrorless-2025.jpg', 6, 5, 'Phạm Hoài Thương', 2567, 'published', 1, '2025-05-26 16:14:04', '2025-05-26 16:14:04', '2025-05-26 23:14:04'),
(24, '10 Mẹo Chụp Ảnh Đẹp Bằng Điện Thoại', '10-meo-chup-anh-dep-bang-dien-thoai', 'Nâng tầm ảnh điện thoại của bạn với những mẹo đơn giản nhưng hiệu quả.', '<p>Chi tiết 10 mẹo...</p>', 'View/assets/images/blog/phone-photography.jpg', 8, 4, 'Bùi Dương Tấn Tài', 500, 'published', 0, '2025-05-26 16:16:26', '2025-05-26 16:16:26', '2025-05-26 23:16:26'),
(25, 'Top Phụ Kiện Nhiếp Ảnh Không Thể Thiếu Khi Du Lịch', 'top-phu-kien-nhiep-anh-khi-du-lich', 'Những phụ kiện nhỏ gọn nhưng hữu ích cho chuyến đi của bạn.', '<p>Danh sách phụ kiện...</p>', 'View/assets/images/blog/travel-accessories.jpg', 8, 5, 'Phạm Hoài Thương', 650, 'published', 1, '2025-05-26 16:16:26', '2025-05-26 16:16:26', '2025-05-26 23:16:26'),
(26, 'Đánh Giá Ống Kính Sony FE 35mm f/1.8', 'danh-gia-ong-kinh-sony-fe-35mm-f1-8', 'Đánh giá chi tiết về hiệu năng và chất lượng của ống kính Sony 35mm f/1.8.', '<p>Bài đánh giá...</p>', 'View/assets/images/blog/sony-35mm-review.jpg', 9, 7, 'Đặng Triệu Vỹ', 400, 'published', 0, '2025-05-26 16:16:26', '2025-05-26 16:16:26', '2025-05-26 23:16:26');

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
(6, 'Reviews', 'reviews', 'Đánh giá chi tiết các sản phẩm nhiếp ảnh', '2025-05-26 16:14:04', '2025-05-26 16:14:04'),
(7, 'Xu hướng', 'xu-huong', 'Các xu hướng mới trong nhiếp ảnh', '2025-05-26 16:14:04', '2025-05-26 16:14:04'),
(8, 'Bài viết', 'bai-viet', 'Các bài viết chung về nhiếp ảnh', '2025-05-26 16:16:26', '2025-05-26 16:16:26'),
(9, 'Sự kiện', 'su-kien', 'Thông tin các sự kiện nhiếp ảnh', '2025-05-26 16:16:26', '2025-05-26 16:16:26');

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
(3, 7, 'Đặng Triệu Vỹ', '52300274@student.tdtu.edu.vn', '0945727010', 'phiền', 'TP.HCM', 'Quận 1', 'Phường 1', 62689000.00, 0.00, 0.00, 5699000.00, 'delivered', 'cod', 'pending', 'standard', '', '', '2025-05-26 08:25:58', '2025-05-26 15:34:22'),
(4, 7, 'Đặng Triệu Vỹ', '52300274@student.tdtu.edu.vn', '0945727010', 'phien', 'TP.HCM', 'Quận 1', 'Phường 1', 47289000.00, 0.00, 0.00, 4299000.00, 'pending', 'cod', 'pending', 'standard', NULL, '', '2025-05-26 08:28:15', '2025-05-26 08:28:15'),
(5, 8, 'Phạm Hoài Thương', 'binmin81@gmail.com', '0708624193', '12345678', 'Hà Nội', 'Quận 1', 'Phường 2', 62689000.00, 0.00, 0.00, 5699000.00, 'shipped', 'cod', 'pending', 'standard', '', 'asdas', '2025-05-26 11:31:47', '2025-05-26 15:34:12');

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
(2, 1, 1, 'Canon EOS R6 Mark II', 62990000.00, 15, NULL),
(3, 1, 3, 'Nikon Z6 II', 44990000.00, 8, NULL),
(4, 2, 4, 'Fujifilm X-T5', 42990000.00, 1, NULL),
(5, 3, 5, 'Canon RF 24-70mm f/2.8L IS USM', 56990000.00, 1, NULL),
(6, 4, 4, 'Fujifilm X-T5', 42990000.00, 1, NULL),
(7, 5, 5, 'Canon RF 24-70mm f/2.8L IS USM', 56990000.00, 1, NULL);

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
(1, 'Canon EOS R6 Mark 00000', 'canon-eos-r6-mark-00000', 'CAM-CAN-R6MK2', 'Canon EOS R6 Mark II là phiên bản nâng cấp của dòng máy ảnh mirrorless full-frame R6 với cảm biến CMOS 24.2MP, khả năng chụp liên tiếp 40fps, quay video 4K60p và ổn định hình ảnh 7.5 stop. Máy còn có tính năng Eye AF cải tiến và kết nối không dây tiện lợi.\r\n\r\n', 'Canon EOS R6 Mark II là phiên bản nâng cấp của dòng máy ảnh mirrorless full-frame R6 với cảm biến CMOS 24.2MP, khả năng chụp liên tiếp 40fps, quay video 4K60p và ổn định hình ảnh 7.5 stop. Máy còn có tính năng Eye AF cải tiến và kết nối không dây tiện lợi.\r\n\r\n', 50000000.00, 64990000.00, NULL, 0, 40, 'View/assets/images/products/68346a52dc0c6_683458efbedba_canon-eos-r6-mark-ii.jpg', NULL, 2, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 4.8, 12, 1, '2025-05-23 09:16:50', '2025-05-26 13:19:14', NULL, 0, 0, 0, ''),
(2, 'Sony Alpha A7 IV', 'sony-alpha-a7-iv', 'CAM-SON-A7IV', 'Sony Alpha A7 IV là máy ảnh mirrorless full-frame thế hệ thứ 4 với cảm biến back-illuminated 33MP mới, bộ xử lý BIONZ XR, quay video 4K60p 10-bit 4:2:2 và khả năng kết nối trực tiếp. Máy còn được trang bị màn hình cảm ứng lật xoay và hệ thống AF tiên tiến.', 'Sony Alpha A7 IV là máy ảnh mirrorless full-frame thế hệ thứ 4 với cảm biến back-illuminated 33MP mới, bộ xử lý BIONZ XR, quay video 4K60p 10-bit 4:2:2 và khả năng kết nối trực tiếp. Máy còn được trang bị màn hình cảm ứng lật xoay và hệ thống AF tiên tiến.', 52490000.00, 54990000.00, NULL, 0, 40, 'View/assets/images/products/sony-alpha-a7-iv.jpg', NULL, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 4.9, 28, 1, '2025-05-23 09:16:50', '2025-05-26 12:07:51', '[\"bestseller\"]', 0, 0, 0, ''),
(3, 'Nikon Z6 II', 'nikon-z6-ii', 'CAM-NIK-Z6II', 'Máy ảnh mirrorless full-frame đa dụng với hiệu suất cao và khả năng quay video chuyên nghiệp', 'Nikon Z6 II là máy ảnh mirrorless full-frame với cảm biến BSI CMOS 24.5MP, bộ xử lý kép EXPEED 6, chụp liên tiếp 14fps, quay video 4K60p và hệ thống AF 273 điểm. Máy còn được trang bị 2 khe cắm thẻ nhớ và khả năng kết nối không dây.', 44990000.00, 47990000.00, NULL, 4, 26, 'View/assets/images/products/nikon-z6-ii.jpg', NULL, 2, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 4.7, 15, 1, '2025-05-23 09:16:50', '2025-05-26 07:41:50', '[\"discount\"]', 0, 0, 0, NULL),
(4, 'Fujifilm X-T5', 'fujifilm-x-t5', 'CAM-FUJ-XT5', 'Máy ảnh mirrorless APS-C với cảm biến 40MP, lý tưởng cho nhiếp ảnh phong cảnh và đường phố', 'Fujifilm X-T5 là máy ảnh mirrorless cao cấp với cảm biến X-Trans CMOS 5 HR 40.2MP, bộ xử lý X-Processor 5, chụp liên tiếp 15fps, quay video 6.2K và ổn định hình ảnh trong thân máy 7 stop. Thiết kế nhỏ gọn với nút điều khiển vật lý đặc trưng của Fujifilm.', 42990000.00, 0.00, NULL, 6, 14, 'View/assets/images/products/fujifilm-x-t5.jpg', NULL, 2, 4, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 4.8, 9, 1, '2025-05-23 09:16:50', '2025-05-26 08:28:15', '[\"new\"]', 0, 0, 0, NULL),
(5, 'Canon RF 24-70mm f/2.8L IS USM', 'canon-rf-24-70mm-f28l-is-usm', 'LENS-CAN-RF2470F28L', 'Ống kính zoom tiêu chuẩn chuyên nghiệp cho máy ảnh Canon mirrorless', 'Canon RF 24-70mm f/2.8L IS USM là ống kính zoom tiêu chuẩn dòng L cho máy ảnh Canon mirrorless mount RF với khẩu độ f/2.8 ổn định, hệ thống ổn định hình ảnh 5 stop, motor lấy nét USM siêu âm nhanh và chính xác. Thiết kế chống bụi và nước với chất lượng hình ảnh vượt trội.', 56990000.00, 59990000.00, NULL, 3, 17, 'View/assets/images/products/canon-rf-24-70mm-f28l.jpg', NULL, 4, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 4.9, 18, 1, '2025-05-23 09:16:50', '2025-05-26 11:31:47', NULL, 0, 0, 0, NULL),
(6, 'Sony FE 50mm f/1.4 GM', 'sony-fe-50mm-f-1-4-gm', 'LENS-SON-FE50F14GM', 'Sony FE 50mm f/1.4 GM là ống kính prime dòng G Master cao cấp với khẩu độ lớn f/1.4, thiết kế nhỏ gọn, motor XD Linear cho lấy nét nhanh và êm, hiệu ứng bokeh đẹp mắt. Được thiết kế cho máy ảnh mirrorless full-frame Sony với khả năng chống bụi và ẩm.', 'Sony FE 50mm f/1.4 GM là ống kính prime dòng G Master cao cấp với khẩu độ lớn f/1.4, thiết kế nhỏ gọn, motor XD Linear cho lấy nét nhanh và êm, hiệu ứng bokeh đẹp mắt. Được thiết kế cho máy ảnh mirrorless full-frame Sony với khả năng chống bụi và ẩm.', 48990000.00, 0.00, NULL, 14, 8, 'View/assets/images/products/sony-fe-50mm-f14-gm.jpg', NULL, 4, 2, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 5.0, 6, 1, '2025-05-23 09:16:50', '2025-05-26 07:41:50', '[\"hot\"]', 0, 0, 0, NULL),
(18, 'Canon EOS R5', 'canon-eos-r5', 'CAM-CAN-R5', 'Máy ảnh mirrorless full-frame 45MP với khả năng quay 8K', 'Canon EOS R5 là máy ảnh mirrorless cao cấp với cảm biến 45MP, quay video 8K, chụp liên tiếp 20fps.', 89990000.00, 94990000.00, NULL, 5, 23, 'View/assets/images/products/canon-eos-r5.jpg', NULL, 2, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 4.9, 34, 1, '2025-05-26 16:14:04', '2025-05-26 16:14:04', NULL, 0, 0, 0, NULL),
(19, 'Canon EOS 5D Mark IV', 'canon-eos-5d-mark-iv', 'CAM-CAN-5DMK4', 'DSLR full-frame 30.4MP chuyên nghiệp', 'Canon EOS 5D Mark IV với cảm biến 30.4MP, quay video 4K, chụp liên tiếp 7fps.', 67990000.00, 72990000.00, NULL, 8, 18, 'View/assets/images/products/canon-5d-mark-iv.jpg', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 4.8, 28, 1, '2025-05-26 16:14:04', '2025-05-26 16:14:04', NULL, 0, 0, 0, NULL),
(20, 'Canon EOS 90D', 'canon-eos-90d', 'CAM-CAN-90D', 'DSLR APS-C 32.5MP với hiệu suất cao', 'Canon EOS 90D với cảm biến APS-C 32.5MP, chụp liên tiếp 10fps, quay video 4K.', 32990000.00, 0.00, NULL, 12, 31, 'View/assets/images/products/canon-90d.jpg', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 4.7, 22, 1, '2025-05-26 16:14:04', '2025-05-26 16:14:04', NULL, 0, 0, 0, NULL),
(21, 'Sony Alpha A7R V', 'sony-alpha-a7r-v', 'CAM-SON-A7RV', 'Mirrorless full-frame 61MP độ phân giải cao', 'Sony Alpha A7R V với cảm biến 61MP, bộ xử lý BIONZ XR, chụp liên tiếp 10fps.', 99990000.00, 0.00, NULL, 3, 8, 'View/assets/images/products/sony-a7r-v.jpg', NULL, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 5.0, 15, 1, '2025-05-26 16:14:04', '2025-05-26 16:14:04', NULL, 0, 0, 0, NULL),
(22, 'Sony Alpha A7 III', 'sony-alpha-a7-iii', 'CAM-SON-A7III', 'Mirrorless full-frame 24.2MP đa năng', 'Sony Alpha A7 III với cảm biến 24.2MP, chụp liên tiếp 10fps, quay video 4K.', 42990000.00, 46990000.00, NULL, 15, 67, 'View/assets/images/products/sony-a7-iii.jpg', NULL, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 4.8, 89, 1, '2025-05-26 16:14:04', '2025-05-26 16:14:04', NULL, 0, 0, 0, NULL),
(23, 'Sony Alpha A6400', 'sony-alpha-a6400', 'CAM-SON-A6400', 'Mirrorless APS-C 24.2MP cho creator', 'Sony Alpha A6400 với cảm biến APS-C 24.2MP, chụp liên tiếp 11fps, quay video 4K.', 24990000.00, 27990000.00, NULL, 20, 45, 'View/assets/images/products/sony-a6400.jpg', NULL, 2, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 4.6, 56, 1, '2025-05-26 16:14:04', '2025-05-26 16:14:04', NULL, 0, 0, 0, NULL),
(24, 'Nikon Z9', 'nikon-z9', 'CAM-NIK-Z9', 'Flagship mirrorless full-frame 45.7MP', 'Nikon Z9 là máy ảnh mirrorless hàng đầu với cảm biến 45.7MP, chụp liên tiếp 20fps.', 139990000.00, 0.00, NULL, 2, 5, 'View/assets/images/products/nikon-z9.jpg', NULL, 2, 3, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 4.9, 12, 1, '2025-05-26 16:14:04', '2025-05-26 16:14:04', NULL, 0, 0, 0, NULL),
(25, 'Nikon D850', 'nikon-d850', 'CAM-NIK-D850', 'DSLR full-frame 45.7MP chuyên nghiệp', 'Nikon D850 với cảm biến 45.7MP, chụp liên tiếp 7fps, quay video 4K.', 79990000.00, 84990000.00, NULL, 6, 14, 'View/assets/images/products/nikon-d850.jpg', NULL, 1, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 4.8, 31, 1, '2025-05-26 16:14:04', '2025-05-26 16:14:04', NULL, 0, 0, 0, NULL),
(26, 'Fujifilm X-H2S', 'fujifilm-x-h2s', 'CAM-FUJ-XH2S', 'Mirrorless APS-C 26.1MP tốc độ cao', 'Fujifilm X-H2S với cảm biến X-Trans CMOS 5 HS 26.1MP, chụp liên tiếp 40fps.', 59990000.00, 0.00, NULL, 7, 11, 'View/assets/images/products/fujifilm-x-h2s.jpg', NULL, 2, 4, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 4.7, 18, 1, '2025-05-26 16:14:04', '2025-05-26 16:14:04', NULL, 0, 0, 0, NULL),
(27, 'Fujifilm X-T4', 'fujifilm-x-t4', 'CAM-FUJ-XT4', 'Mirrorless APS-C 26.1MP với ổn định', 'Fujifilm X-T4 với cảm biến X-Trans CMOS 4 26.1MP, chụp liên tiếp 15fps.', 39990000.00, 42990000.00, NULL, 11, 26, 'View/assets/images/products/fujifilm-x-t4.jpg', NULL, 2, 4, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 4.6, 33, 1, '2025-05-26 16:14:04', '2025-05-26 16:14:04', NULL, 0, 0, 0, NULL),
(28, 'Canon RF 85mm f/1.2L USM', 'canon-rf-85mm-f12l-usm', 'LENS-CAN-RF85F12L', 'Ống kính chân dung cao cấp f/1.2', 'Canon RF 85mm f/1.2L USM là ống kính chân dung premium với khẩu độ cực lớn f/1.2.', 69990000.00, 0.00, NULL, 4, 12, 'View/assets/images/products/canon-rf-85mm-f12l.jpg', NULL, 4, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 4.9, 21, 1, '2025-05-26 16:14:04', '2025-05-26 16:14:04', NULL, 0, 0, 0, NULL),
(29, 'Canon RF 16-35mm f/2.8L IS USM', 'canon-rf-16-35mm-f28l-is-usm', 'LENS-CAN-RF1635F28L', 'Ống kính góc rộng chuyên nghiệp', 'Canon RF 16-35mm f/2.8L IS USM với khẩu độ f/2.8 ổn định, ổn định hình ảnh 5 stop.', 64990000.00, 67990000.00, NULL, 6, 8, 'View/assets/images/products/canon-rf-16-35mm-f28l.jpg', NULL, 4, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 4.8, 15, 1, '2025-05-26 16:14:04', '2025-05-26 16:14:04', NULL, 0, 0, 0, NULL),
(30, 'Canon RF 70-200mm f/2.8L IS USM', 'canon-rf-70-200mm-f28l-is-usm', 'LENS-CAN-RF70200F28L', 'Ống kính tele zoom chuyên nghiệp', 'Canon RF 70-200mm f/2.8L IS USM với khẩu độ f/2.8 ổn định.', 74990000.00, 0.00, NULL, 3, 9, 'View/assets/images/products/canon-rf-70-200mm-f28l.jpg', NULL, 4, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 4.9, 19, 1, '2025-05-26 16:14:04', '2025-05-26 16:14:04', NULL, 0, 0, 0, NULL),
(31, 'Sony FE 24-70mm f/2.8 GM II', 'sony-fe-24-70mm-f28-gm-ii', 'LENS-SON-FE2470F28GM2', 'Ống kính zoom tiêu chuẩn G Master II', 'Sony FE 24-70mm f/2.8 GM II với thiết kế quang học cải tiến.', 64990000.00, 0.00, NULL, 5, 7, 'View/assets/images/products/sony-fe-24-70mm-f28-gm-ii.jpg', NULL, 4, 2, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 4.8, 13, 1, '2025-05-26 16:14:04', '2025-05-26 16:14:04', NULL, 0, 0, 0, NULL),
(32, 'Sony FE 85mm f/1.4 GM', 'sony-fe-85mm-f14-gm', 'LENS-SON-FE85F14GM', 'Ống kính chân dung G Master f/1.4', 'Sony FE 85mm f/1.4 GM với khẩu độ f/1.4, thiết kế quang học 11 thành phần.', 49990000.00, 52990000.00, NULL, 8, 16, 'View/assets/images/products/sony-fe-85mm-f14-gm.jpg', NULL, 4, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 4.9, 24, 1, '2025-05-26 16:14:04', '2025-05-26 16:14:04', NULL, 0, 0, 0, NULL),
(33, 'Sony FE 16-35mm f/2.8 GM', 'sony-fe-16-35mm-f28-gm', 'LENS-SON-FE1635F28GM', 'Ống kính góc rộng G Master', 'Sony FE 16-35mm f/2.8 GM với khẩu độ f/2.8 ổn định.', 59990000.00, 0.00, NULL, 4, 11, 'View/assets/images/products/sony-fe-16-35mm-f28-gm.jpg', NULL, 4, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 4.7, 18, 1, '2025-05-26 16:14:04', '2025-05-26 16:14:04', NULL, 0, 0, 0, NULL),
(34, 'Nikon Z 24-70mm f/2.8 S', 'nikon-z-24-70mm-f28-s', 'LENS-NIK-Z2470F28S', 'Ống kính zoom tiêu chuẩn S-Line', 'Nikon Z 24-70mm f/2.8 S với thiết kế quang học S-Line cao cấp.', 59990000.00, 62990000.00, NULL, 6, 13, 'View/assets/images/products/nikon-z-24-70mm-f28-s.jpg', NULL, 4, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 4.8, 20, 1, '2025-05-26 16:14:04', '2025-05-26 16:14:04', NULL, 0, 0, 0, NULL),
(35, 'Nikon Z 85mm f/1.8 S', 'nikon-z-85mm-f18-s', 'LENS-NIK-Z85F18S', 'Ống kính chân dung S-Line f/1.8', 'Nikon Z 85mm f/1.8 S với khẩu độ f/1.8, thiết kế nhỏ gọn.', 21990000.00, 0.00, NULL, 12, 28, 'View/assets/images/products/nikon-z-85mm-f18-s.jpg', NULL, 4, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 4.7, 35, 1, '2025-05-26 16:14:04', '2025-05-26 16:14:04', NULL, 0, 0, 0, NULL),
(36, 'Manfrotto Befree Advanced Carbon', 'manfrotto-befree-advanced-carbon', 'ACC-MAN-BEFREE', 'Chân máy carbon du lịch nhỏ gọn', 'Manfrotto Befree Advanced Carbon với chất liệu carbon nhẹ, thiết kế gập gọn.', 12990000.00, 14990000.00, NULL, 15, 42, 'View/assets/images/products/manfrotto-befree-carbon.jpg', NULL, 5, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 4.6, 38, 1, '2025-05-26 16:14:04', '2025-05-26 16:14:04', NULL, 0, 0, 0, NULL),
(37, 'Peak Design Everyday Backpack V2', 'peak-design-everyday-backpack-v2', 'ACC-PD-BACKPACK', 'Balo nhiếp ảnh đa năng 30L', 'Peak Design Everyday Backpack V2 30L với thiết kế modular.', 8990000.00, 0.00, NULL, 20, 56, 'View/assets/images/products/peak-design-backpack.jpg', NULL, 5, 6, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 4.8, 47, 1, '2025-05-26 16:14:04', '2025-05-26 16:14:04', NULL, 0, 0, 0, NULL),
(38, 'SanDisk Extreme Pro CFexpress', 'sandisk-extreme-pro-cfexpress', 'ACC-SD-CFEXPRESS', 'Thẻ nhớ CFexpress Type B 128GB', 'SanDisk Extreme Pro CFexpress Type B 128GB với tốc độ đọc 1700MB/s.', 4990000.00, 5490000.00, NULL, 25, 73, 'View/assets/images/products/sandisk-cfexpress.jpg', NULL, 5, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 4.5, 62, 1, '2025-05-26 16:14:04', '2025-05-26 16:14:04', NULL, 0, 0, 0, NULL);

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
(14, 'Mẹo', 'meo', '2025-05-26 16:16:26'),
(15, 'Phụ kiện', 'phu-kien', '2025-05-26 16:16:26'),
(16, 'Đánh giá', 'danh-gia', '2025-05-26 16:16:26');

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
(1, 'Admin User', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', 1, '2025-05-26 16:14:04', '2025-05-26 16:14:04'),
(2, 'Nhân viên', 'staff@cameravn.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0987654321', NULL, NULL, 'Đại học Tôn Đức Thắng', 'TP.HCM', 'Quận 7', 'Phường Tân Phú', NULL, 'staff', 1, '2025-05-23 09:16:50', '2025-05-23 09:16:50'),
(4, 'Bùi Dương Tấn Tài', '52300154@student.tdtu.edu.vn', '$2y$10$ZIlbFSCaKAfMupItJsg0j.UH1hHRq4rzOd5sc6g/31T3zevUBg3PG', '0868212407', NULL, NULL, '', '', '', '', 'View/assets/images/uploads/users/683123efce74f_IMG_4423.jpeg', 'admin', 1, '2025-05-23 16:42:12', '2025-05-25 16:31:33'),
(5, 'Phạm Hoài Thương', '52300262@student.tdtu.edu.vn', '$2y$10$v8pKe.YFjSAvyWFieZGGfeA657s8/sIYQRclmwfFeJpypNCFesSz2', '0708624193', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', 1, '2025-05-24 06:59:29', '2025-05-24 06:59:29'),
(7, 'Đặng Triệu Vỹ', '52300274@student.tdtu.edu.vn', '$2y$10$BtZSvDrK93ynw3953ImhPOcSWqCwknsu7ZP9uI4.VOBaDDokCvBo.', '0945727010', NULL, NULL, '', 'TP.HCM', '', '', NULL, 'admin', 1, '2025-05-24 12:17:25', '2025-05-26 07:32:42'),
(8, 'Phạm Hoài Thương', 'binmin81@gmail.com', '$2y$10$OQJlrzrmVUr5eqHQZdHeKuxeOL2Lgby3o5WkIuc07Du0N.Ns2Gjc2', '0708624193', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'customer', 1, '2025-05-26 11:22:46', '2025-05-26 11:22:46');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `wards`
--
ALTER TABLE `wards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
