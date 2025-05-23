-- Cơ sở dữ liệu cho CameraVN
-- Version: 1.0
-- Date: 2023-05-23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+07:00";

-- --------------------------------------------------------
-- Cấu trúc Database
-- --------------------------------------------------------

-- Bảng `users`
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng `categories`
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng `brands`
CREATE TABLE `brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng `products`
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `category_id` (`category_id`),
  KEY `brand_id` (`brand_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng `carts`
CREATE TABLE `carts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `options` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `session_id` (`session_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng `wishlists`
CREATE TABLE `wishlists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_product` (`user_id`,`product_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng `orders`
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng `order_items`
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `options` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng `reviews`
CREATE TABLE `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `comment` text NOT NULL,
  `images` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dữ liệu mẫu
-- --------------------------------------------------------

-- Dữ liệu bảng `users`
INSERT INTO `users` (`name`, `email`, `password`, `phone`, `address`, `city`, `district`, `ward`, `role`, `status`) VALUES
('Admin', 'admin@cameravn.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0123456789', 'Đại học Tôn Đức Thắng', 'TP.HCM', 'Quận 7', 'Phường Tân Phú', 'admin', 1),
('Nhân viên', 'staff@cameravn.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0987654321', 'Đại học Tôn Đức Thắng', 'TP.HCM', 'Quận 7', 'Phường Tân Phú', 'staff', 1),
('Khách hàng', 'customer@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0909123456', '123 Nguyễn Trãi', 'TP.HCM', 'Quận 1', 'Phường Bến Thành', 'customer', 1);

-- Dữ liệu bảng `categories`
INSERT INTO `categories` (`name`, `slug`, `description`, `status`) VALUES
('Máy ảnh DSLR', 'dslr', 'Máy ảnh DSLR (Digital Single Lens Reflex) với độ bền cao và chất lượng ảnh vượt trội', 1),
('Máy ảnh mirrorless', 'mirrorless', 'Máy ảnh mirrorless (không gương lật) nhỏ gọn với hiệu suất cao', 1),
('Máy ảnh compact', 'compact', 'Máy ảnh compact nhỏ gọn, dễ sử dụng, tiện lợi mang theo', 1),
('Ống kính (Lens)', 'lens', 'Ống kính chất lượng cao cho mọi nhu cầu nhiếp ảnh', 1),
('Phụ kiện', 'accessory', 'Phụ kiện chính hãng cho máy ảnh và ống kính', 1);

-- Dữ liệu bảng `brands`
INSERT INTO `brands` (`name`, `slug`, `description`, `status`) VALUES
('Canon', 'canon', 'Thương hiệu máy ảnh hàng đầu từ Nhật Bản với lịch sử lâu đời và sản phẩm chất lượng cao', 1),
('Sony', 'sony', 'Thương hiệu máy ảnh và điện tử hàng đầu với công nghệ tiên tiến', 1),
('Nikon', 'nikon', 'Thương hiệu máy ảnh chuyên nghiệp với hệ thống ống kính đa dạng', 1),
('Fujifilm', 'fujifilm', 'Thương hiệu máy ảnh nổi tiếng với màu sắc đặc trưng và thiết kế hoài cổ', 1),
('Panasonic', 'panasonic', 'Thương hiệu điện tử và máy ảnh với công nghệ video vượt trội', 1),
('Leica', 'leica', 'Thương hiệu máy ảnh cao cấp của Đức với chất lượng vượt trội và thiết kế tinh tế', 1);

-- Dữ liệu bảng `products`
INSERT INTO `products` (`name`, `slug`, `sku`, `short_description`, `description`, `price`, `old_price`, `stock`, `sold_count`, `image_url`, `category_id`, `brand_id`, `is_featured`, `is_new`, `is_hot`, `rating`, `reviews_count`, `status`) VALUES
('Canon EOS R6 Mark II', 'canon-eos-r6-mark-ii', 'CAM-CAN-R6MK2', 'Máy ảnh mirrorless full-frame với khả năng chụp liên tiếp nhanh và quay video chất lượng cao', 'Canon EOS R6 Mark II là phiên bản nâng cấp của dòng máy ảnh mirrorless full-frame R6 với cảm biến CMOS 24.2MP, khả năng chụp liên tiếp 40fps, quay video 4K60p và ổn định hình ảnh 7.5 stop. Máy còn có tính năng Eye AF cải tiến và kết nối không dây tiện lợi.', 62990000, 64990000, 15, 25, 'View/assets/images/products/canon-eos-r6-mark-ii.jpg', 2, 1, 1, 1, 1, 4.8, 12, 1),

('Sony Alpha A7 IV', 'sony-alpha-a7-iv', 'CAM-SON-A7IV', 'Máy ảnh mirrorless full-frame đa dụng với cảm biến mới, lý tưởng cho cả nhiếp ảnh và video', 'Sony Alpha A7 IV là máy ảnh mirrorless full-frame thế hệ thứ 4 với cảm biến back-illuminated 33MP mới, bộ xử lý BIONZ XR, quay video 4K60p 10-bit 4:2:2 và khả năng kết nối trực tiếp. Máy còn được trang bị màn hình cảm ứng lật xoay và hệ thống AF tiên tiến.', 52490000, 54990000, 10, 30, 'View/assets/images/products/sony-alpha-a7-iv.jpg', 2, 2, 1, 0, 1, 4.9, 28, 1),

('Nikon Z6 II', 'nikon-z6-ii', 'CAM-NIK-Z6II', 'Máy ảnh mirrorless full-frame đa dụng với hiệu suất cao và khả năng quay video chuyên nghiệp', 'Nikon Z6 II là máy ảnh mirrorless full-frame với cảm biến BSI CMOS 24.5MP, bộ xử lý kép EXPEED 6, chụp liên tiếp 14fps, quay video 4K60p và hệ thống AF 273 điểm. Máy còn được trang bị 2 khe cắm thẻ nhớ và khả năng kết nối không dây.', 44990000, 47990000, 12, 18, 'View/assets/images/products/nikon-z6-ii.jpg', 2, 3, 1, 0, 0, 4.7, 15, 1),

('Fujifilm X-T5', 'fujifilm-x-t5', 'CAM-FUJ-XT5', 'Máy ảnh mirrorless APS-C với cảm biến 40MP, lý tưởng cho nhiếp ảnh phong cảnh và đường phố', 'Fujifilm X-T5 là máy ảnh mirrorless cao cấp với cảm biến X-Trans CMOS 5 HR 40.2MP, bộ xử lý X-Processor 5, chụp liên tiếp 15fps, quay video 6.2K và ổn định hình ảnh trong thân máy 7 stop. Thiết kế nhỏ gọn với nút điều khiển vật lý đặc trưng của Fujifilm.', 42990000, 0, 8, 12, 'View/assets/images/products/fujifilm-x-t5.jpg', 2, 4, 1, 1, 0, 4.8, 9, 1),

('Canon RF 24-70mm f/2.8L IS USM', 'canon-rf-24-70mm-f28l-is-usm', 'LENS-CAN-RF2470F28L', 'Ống kính zoom tiêu chuẩn chuyên nghiệp cho máy ảnh Canon mirrorless', 'Canon RF 24-70mm f/2.8L IS USM là ống kính zoom tiêu chuẩn dòng L cho máy ảnh Canon mirrorless mount RF với khẩu độ f/2.8 ổn định, hệ thống ổn định hình ảnh 5 stop, motor lấy nét USM siêu âm nhanh và chính xác. Thiết kế chống bụi và nước với chất lượng hình ảnh vượt trội.', 56990000, 59990000, 5, 15, 'View/assets/images/products/canon-rf-24-70mm-f28l.jpg', 4, 1, 1, 0, 1, 4.9, 18, 1),

('Sony FE 50mm f/1.4 GM', 'sony-fe-50mm-f14-gm', 'LENS-SON-FE50F14GM', 'Ống kính prime cao cấp dòng G Master cho máy ảnh Sony FE mount', 'Sony FE 50mm f/1.4 GM là ống kính prime dòng G Master cao cấp với khẩu độ lớn f/1.4, thiết kế nhỏ gọn, motor XD Linear cho lấy nét nhanh và êm, hiệu ứng bokeh đẹp mắt. Được thiết kế cho máy ảnh mirrorless full-frame Sony với khả năng chống bụi và ẩm.', 48990000, 0, 6, 8, 'View/assets/images/products/sony-fe-50mm-f14-gm.jpg', 4, 2, 1, 1, 0, 5.0, 6, 1);

-- Foreign Keys
ALTER TABLE `categories` ADD CONSTRAINT `fk_category_parent` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
ALTER TABLE `products` ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
ALTER TABLE `products` ADD CONSTRAINT `fk_product_brand` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`);
ALTER TABLE `carts` ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
ALTER TABLE `carts` ADD CONSTRAINT `fk_cart_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
ALTER TABLE `wishlists` ADD CONSTRAINT `fk_wishlist_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
ALTER TABLE `wishlists` ADD CONSTRAINT `fk_wishlist_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
ALTER TABLE `orders` ADD CONSTRAINT `fk_order_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
ALTER TABLE `order_items` ADD CONSTRAINT `fk_orderitem_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
ALTER TABLE `order_items` ADD CONSTRAINT `fk_orderitem_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
ALTER TABLE `reviews` ADD CONSTRAINT `fk_review_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
ALTER TABLE `reviews` ADD CONSTRAINT `fk_review_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

COMMIT;