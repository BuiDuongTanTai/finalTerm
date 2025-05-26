-- Tạo bảng blogs nếu chưa tồn tại
CREATE TABLE IF NOT EXISTS `blogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `summary` text,
  `content` longtext,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `author_name` varchar(100) NOT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `published_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `category_id` (`category_id`),
  KEY `author_id` (`author_id`),
  KEY `status` (`status`),
  KEY `featured` (`featured`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tạo bảng blog_categories nếu chưa tồn tại
CREATE TABLE IF NOT EXISTS `blog_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tạo bảng tags nếu chưa tồn tại
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tạo bảng blog_tags nếu chưa tồn tại
CREATE TABLE IF NOT EXISTS `blog_tags` (
  `blog_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`blog_id`,`tag_id`),
  KEY `tag_id` (`tag_id`),
  CONSTRAINT `blog_tags_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `blog_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Thêm dữ liệu mẫu cho blog_categories
INSERT INTO `blog_categories` (`name`, `slug`, `description`) VALUES
('Tin tức', 'tin-tuc', 'Các tin tức mới nhất về công nghệ'),
('Hướng dẫn', 'huong-dan', 'Hướng dẫn sử dụng sản phẩm'),
('Đánh giá', 'danh-gia', 'Đánh giá sản phẩm');

-- Thêm dữ liệu mẫu cho tags
INSERT INTO `tags` (`name`, `slug`) VALUES
('Camera', 'camera'),
('Máy ảnh', 'may-anh'),
('Công nghệ', 'cong-nghe'),
('Hướng dẫn', 'huong-dan'),
('Đánh giá', 'danh-gia');

-- Thêm dữ liệu mẫu cho blogs
INSERT INTO `blogs` (`title`, `slug`, `summary`, `content`, `image`, `category_id`, `author_id`, `author_name`, `status`, `featured`, `views`, `created_at`, `published_at`) VALUES
('Hướng dẫn chọn máy ảnh phù hợp', 'huong-dan-chon-may-anh-phu-hop', 'Bài viết hướng dẫn cách chọn máy ảnh phù hợp với nhu cầu của bạn', '<p>Nội dung chi tiết về cách chọn máy ảnh...</p>', 'uploads/blog/camera-guide.jpg', 2, 1, 'Admin', 'published', 1, 1250, '2024-05-24 16:33:00', '2024-05-24 16:33:00'),
('Đánh giá Canon EOS R5', 'danh-gia-canon-eos-r5', 'Đánh giá chi tiết về máy ảnh Canon EOS R5', '<p>Nội dung đánh giá chi tiết...</p>', 'uploads/blog/canon-r5-review.jpg', 3, 1, 'Admin', 'published', 1, 980, '2024-05-24 15:30:00', '2024-05-24 15:30:00');

-- Thêm dữ liệu mẫu cho blog_tags
INSERT INTO `blog_tags` (`blog_id`, `tag_id`) VALUES
(1, 1), (1, 2), (1, 4), -- Tags cho bài viết 1
(2, 1), (2, 2), (2, 5); -- Tags cho bài viết 2 