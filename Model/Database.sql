-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2025 at 01:10 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cameravn`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
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
-- Dumping data for table `brands`
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
-- Table structure for table `carts`
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

-- --------------------------------------------------------

--
-- Table structure for table `categories`
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
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `parent_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Máy ảnh DSLR', 'dslr', 'Máy ảnh DSLR (Digital Single Lens Reflex) với độ bền cao và chất lượng ảnh vượt trội', NULL, NULL, 1, '2025-05-23 09:16:50', '2025-05-23 09:16:50'),
(2, 'Máy ảnh mirrorless', 'mirrorless', 'Máy ảnh mirrorless (không gương lật) nhỏ gọn với hiệu suất cao', NULL, NULL, 1, '2025-05-23 09:16:50', '2025-05-23 09:16:50'),
(3, 'Máy ảnh compact', 'compact', 'Máy ảnh compact nhỏ gọn, dễ sử dụng, tiện lợi mang theo', NULL, NULL, 1, '2025-05-23 09:16:50', '2025-05-23 09:16:50'),
(4, 'Ống kính (Lens)', 'lens', 'Ống kính chất lượng cao cho mọi nhu cầu nhiếp ảnh', NULL, NULL, 1, '2025-05-23 09:16:50', '2025-05-23 09:16:50'),
(5, 'Phụ kiện', 'accessory', 'Phụ kiện chính hãng cho máy ảnh và ống kính', NULL, NULL, 1, '2025-05-23 09:16:50', '2025-05-23 09:16:50');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
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

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
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

-- --------------------------------------------------------

--
-- Table structure for table `products`
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
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_new` tinyint(1) NOT NULL DEFAULT 0,
  `is_hot` tinyint(1) NOT NULL DEFAULT 0,
  `is_best` tinyint(1) NOT NULL DEFAULT 0,
  `rating` decimal(3,1) NOT NULL DEFAULT 0.0,
  `reviews_count` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `sku`, `short_description`, `description`, `price`, `old_price`, `cost`, `stock`, `sold_count`, `image_url`, `images`, `category_id`, `brand_id`, `weight`, `dimensions`, `specifications`, `colors`, `variations`, `is_featured`, `is_new`, `is_hot`, `is_best`, `rating`, `reviews_count`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Canon EOS R6 Mark II', 'canon-eos-r6-mark-ii', 'CAM-CAN-R6MK2', 'Máy ảnh mirrorless full-frame với khả năng chụp liên tiếp nhanh và quay video chất lượng cao', 'Canon EOS R6 Mark II là phiên bản nâng cấp của dòng máy ảnh mirrorless full-frame R6 với cảm biến CMOS 24.2MP, khả năng chụp liên tiếp 40fps, quay video 4K60p và ổn định hình ảnh 7.5 stop. Máy còn có tính năng Eye AF cải tiến và kết nối không dây tiện lợi.', 62990000.00, 64990000.00, NULL, 15, 25, 'View/assets/images/product/canon-eos-r6-mark-ii.jpg', NULL, 2, 1, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 4.8, 13, 1, '2025-05-23 09:16:50', '2025-05-23 15:27:15'),
(2, 'Sony Alpha A7 IV', 'sony-alpha-a7-iv', 'CAM-SON-A7IV', 'Máy ảnh mirrorless full-frame đa dụng với cảm biến mới, lý tưởng cho cả nhiếp ảnh và video', 'Sony Alpha A7 IV là máy ảnh mirrorless full-frame thế hệ thứ 4 với cảm biến back-illuminated 33MP mới, bộ xử lý BIONZ XR, quay video 4K60p 10-bit 4:2:2 và khả năng kết nối trực tiếp. Máy còn được trang bị màn hình cảm ứng lật xoay và hệ thống AF tiên tiến.', 52490000.00, 54990000.00, NULL, 10, 30, 'View/assets/images/products/sony-alpha-a7-iv.jpg', NULL, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 4.9, 28, 1, '2025-05-23 09:16:50', '2025-05-23 09:16:50'),
(3, 'Nikon Z6 II', 'nikon-z6-ii', 'CAM-NIK-Z6II', 'Máy ảnh mirrorless full-frame đa dụng với hiệu suất cao và khả năng quay video chuyên nghiệp', 'Nikon Z6 II là máy ảnh mirrorless full-frame với cảm biến BSI CMOS 24.5MP, bộ xử lý kép EXPEED 6, chụp liên tiếp 14fps, quay video 4K60p và hệ thống AF 273 điểm. Máy còn được trang bị 2 khe cắm thẻ nhớ và khả năng kết nối không dây.', 44990000.00, 47990000.00, NULL, 12, 18, 'View/assets/images/products/nikon-z6-ii.jpg', NULL, 2, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 4.7, 15, 1, '2025-05-23 09:16:50', '2025-05-23 09:16:50'),
(4, 'Fujifilm X-T5', 'fujifilm-x-t5', 'CAM-FUJ-XT5', 'Máy ảnh mirrorless APS-C với cảm biến 40MP, lý tưởng cho nhiếp ảnh phong cảnh và đường phố', 'Fujifilm X-T5 là máy ảnh mirrorless cao cấp với cảm biến X-Trans CMOS 5 HR 40.2MP, bộ xử lý X-Processor 5, chụp liên tiếp 15fps, quay video 6.2K và ổn định hình ảnh trong thân máy 7 stop. Thiết kế nhỏ gọn với nút điều khiển vật lý đặc trưng của Fujifilm.', 42990000.00, 0.00, NULL, 8, 12, 'View/assets/images/products/fujifilm-x-t5.jpg', NULL, 2, 4, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 4.8, 9, 1, '2025-05-23 09:16:50', '2025-05-23 09:16:50'),
(5, 'Canon RF 24-70mm f/2.8L IS USM', 'canon-rf-24-70mm-f28l-is-usm', 'LENS-CAN-RF2470F28L', 'Ống kính zoom tiêu chuẩn chuyên nghiệp cho máy ảnh Canon mirrorless', 'Canon RF 24-70mm f/2.8L IS USM là ống kính zoom tiêu chuẩn dòng L cho máy ảnh Canon mirrorless mount RF với khẩu độ f/2.8 ổn định, hệ thống ổn định hình ảnh 5 stop, motor lấy nét USM siêu âm nhanh và chính xác. Thiết kế chống bụi và nước với chất lượng hình ảnh vượt trội.', 56990000.00, 59990000.00, NULL, 5, 15, 'View/assets/images/products/canon-rf-24-70mm-f28l.jpg', NULL, 4, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 4.9, 18, 1, '2025-05-23 09:16:50', '2025-05-23 09:16:50'),
(6, 'Sony FE 50mm f/1.4 GM', 'sony-fe-50mm-f14-gm', 'LENS-SON-FE50F14GM', 'Ống kính prime cao cấp dòng G Master cho máy ảnh Sony FE mount', 'Sony FE 50mm f/1.4 GM là ống kính prime dòng G Master cao cấp với khẩu độ lớn f/1.4, thiết kế nhỏ gọn, motor XD Linear cho lấy nét nhanh và êm, hiệu ứng bokeh đẹp mắt. Được thiết kế cho máy ảnh mirrorless full-frame Sony với khả năng chống bụi và ẩm.', 48990000.00, 0.00, NULL, 6, 8, 'View/assets/images/products/sony-fe-50mm-f14-gm.jpg', NULL, 4, 2, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 5.0, 6, 1, '2025-05-23 09:16:50', '2025-05-23 09:16:50');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `city`, `district`, `ward`, `avatar`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@cameravn.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0123456789', 'Đại học Tôn Đức Thắng', 'TP.HCM', 'Quận 7', 'Phường Tân Phú', NULL, 'admin', 1, '2025-05-23 09:16:50', '2025-05-23 09:16:50'),
(2, 'Nhân viên', 'staff@cameravn.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0987654321', 'Đại học Tôn Đức Thắng', 'TP.HCM', 'Quận 7', 'Phường Tân Phú', NULL, 'admin', 1, '2025-05-23 09:16:50', '2025-05-23 09:16:50'),
(3, 'Khách hàng', 'customer@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0909123456', '123 Nguyễn Trãi', 'TP.HCM', 'Quận 1', 'Phường Bến Thành', NULL, 'admin', 1, '2025-05-23 09:16:50', '2025-05-23 09:16:50'),
(4, 'Bùi Dương Tấn Tài', '52300154@student.tdtu.edu.vn', '$2y$10$6w6BRg3FHdHndNZ3gdUES.f0bQ795crWi/ZCF.BYS9wvHS.eV16C6', '0868212407', NULL, NULL, NULL, NULL, NULL, 'admin', 1, '2025-05-23 16:42:12', '2025-05-23 16:42:12');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_product` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `fk_cart_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `fk_category_parent` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_order_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_orderitem_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_orderitem_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_product_brand` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_review_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_review_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `fk_wishlist_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_wishlist_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
